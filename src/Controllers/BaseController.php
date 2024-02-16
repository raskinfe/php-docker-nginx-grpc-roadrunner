<?php

namespace App\Controllers;
class BaseController {
    protected function redirect(string $to) {
        header("Location: $to");
        exit();
    }
}