<?php

namespace App\Services;

class Container {

    private $bindings = [];

    public function bind(string $key, callable $factory) 
    {
        $this->bindings[$key] = $factory;
    }

    public function serviceExist(string $key) {
        return isset($this->bindings[$key]);
    }

    public function resolve(string $key) 
    {
        
        if (!array_key_exists($key, $this->bindings)) {
            throw new \Exception("No binding found for $key");
        }

        $resolver = $this->bindings[$key];

        return call_user_func($resolver); 
    }

    // private static $instances = [];

    // public function set(string $key, $value) {
    //     self::$instances[$key] = $value;
    // }

    // static function get(string $key, $args=null) { 
    //     if (array_key_exists($key, Container::$instances)) {
    //         return Container::$instances[$key];
    //     }

    //     $className = ucfirst($key);
    //     if (class_exists($className)) {
    //         $reflector = new \ReflectionClass($className);

    //         $constructor = $reflector->getConstructor();

    //         if ($constructor && $constructor->getParameters()) {
    //             $instance = $reflector->newInstanceArgs($args);
    //         } else {
    //             $instance = new $className;
    //         }

    //         return Container::$instances[$key] = $instance;
    //     }

    //     throw new \Exception("Class not found");
    // }

}