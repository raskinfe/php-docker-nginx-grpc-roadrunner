<?php

namespace App\Services;

use App\Core\App;
use App\Controllers\Middlewares\Middleware;

class Router {

    public $routes = [];
    
    public function __construct() {}

    public function get(string $path, string | array | callable $controller): Router
    {
        return $this->addRoutes(uri: $path, controller: $controller, method: 'GET');
    }
    public function post(string $path, string | array | callable $controller): Router
    {
        return $this->addRoutes(uri: $path, controller: $controller, method: 'POST');
    }

    public function put(string $path, string | array | callable $controller) : Router
    {
        return $this->addRoutes(uri: $path, controller: $controller, method: 'PUT');
    }
    public function patch(string $path, string | array | callable $controller): Router
    {
        return $this->addRoutes(uri: $path, controller: $controller, method: 'PATCH');
    }
    public function delete(string $path, string | array | callable $controller): Router
    {
        return $this->addRoutes(uri: $path, controller: $controller, method: 'DELETE');
    }

    public function route(string $uri, string $method)
    {
        if (!$this->hasRoute($uri)) { 
            header('location: /404');
            exit();
        }

        foreach ($this->routes as $route) {
            if ($route['uri'] === $uri && $route['method'] === strtoupper($method)) {
                if (isset($route['middleware'])) {
                    (new Middleware)->handle($route['middleware']);
                }

                $controller = $route['controller'];
    
                if (is_callable($controller)) {
                    call_user_func($controller);
                } elseif (is_array($controller) && count($controller) === 2) {
                    [$class, $method] = $controller;
    
                    if (class_exists($class)) {
                        $reflector = new \ReflectionClass($class);

                        $constructor = $reflector->getConstructor();
    
                        if ($constructor && $constructor->getNumberOfRequiredParameters() > 0) {
                            throw new Exception("Constructor of '{$class}' requires arguments, which is not supported");
                        }
    
                        $instance = $reflector->newInstanceWithoutConstructor();
    
                        if ($reflector->hasMethod($method)) {
                            $methodReflector = $reflector->getMethod($method);
                            $parameters = [];
    
                            foreach ($methodReflector->getParameters() as $parameter) {
                                if ($parameter->getType() && !$parameter->getType()->isBuiltin()) {
                                    if (!App::serviceExist($parameter->getType()->getName())) {
                                
                                        App::bind($parameter->getType()->getName(), function () use ($parameter) {
                                            $parameterClass = new \ReflectionClass($parameter->getType()->getName());
                                            $instance = $parameterClass->newInstanceWithoutConstructor();
                                            return $instance;
                                        });
                                    }
                                    
                                    $parameters[] = App::resolve($parameter->getType()->getName());
                                } elseif ($parameter->isDefaultValueAvailable()) {
                                    $parameters[] = $parameter->getDefaultValue();
                                } else {
                                    throw new Exception("Unable to resolve parameter '{$parameter->getName()}' for method '{$method}'");
                                }
                            }
    
                            $methodReflector->invokeArgs($instance, $parameters);
                        } else {
                            throw new Exception("Method '{$method}' not found in class '{$class}'");
                        }
                    } else {
                        throw new Exception("Class '{$class}' not found");
                    }
                } else {
                    throw new Exception("Invalid controller format");
                }
            }
        }
    }
    

    private function addRoutes(string $uri, $controller, string $method): Router
    {
        $this->routes[] = [
            'uri' => $uri,
            'controller' => $controller,
            'method' => $method,
        ];
        return $this;
    }

    private function hasRoute(string $uri): bool 
    {
        return in_array($uri, array_column($this->routes, 'uri'));
    }

    public function only(string $role) 
    {
        $this->routes[array_key_last($this->routes)]['middleware'] = $role; 
    }
}