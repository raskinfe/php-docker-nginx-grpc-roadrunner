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

}