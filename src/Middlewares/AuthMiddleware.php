<?php

namespace App\Middlewares;

class AuthMiddleware extends AbstractMiddleware {
    public function handle() {
        if(!currentUser()) {
            header('location: /');
            exit();
        }
    }
}