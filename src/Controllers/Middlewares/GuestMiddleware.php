<?php

namespace App\Controllers\Middlewares;

class GuestMiddleware extends AbstractMiddleware {
    public function handle() {
        if(currentUser()) {
            header('location: /');
            exit();
        }
    }
}