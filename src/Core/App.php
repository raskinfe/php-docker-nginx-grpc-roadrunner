<?php

namespace App\Core;

use App\Services\Container;

class App {

    private static Container $container;
    public static function setContainer(Container $container) 
    {
        static::$container = $container;
    }

    public static function getContainer(): Container
    {
        return static::$container;
    }

    public static function serviceExist(string $service): bool {
        return static::$container->serviceExist($service);
    }

    public static function bind(string $key, callable $resolver) 
    {
        static::$container->bind($key, $resolver);
    }

    public static function resolve(string $key) 
    {
        return static::$container->resolve($key);
    }
}