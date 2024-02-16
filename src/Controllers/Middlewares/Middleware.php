<?php

namespace App\Controllers\Middlewares;


final class Middleware {

    const MIDDLEWARE_MAP = [
        'guest' => GuestMiddleware::class,
        'auth' => AuthMiddleware::class
    ];
    public function handle(string $middleware) {
        $middleware = strtolower($middleware);
        if (array_key_exists($middleware, self::MIDDLEWARE_MAP)) {
            $className = self::MIDDLEWARE_MAP[$middleware];
            if (class_exists($className)) { 
                $middleware = new $className();
                $middleware->handle();
            }
        }
    }
}