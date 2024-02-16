<?php

namespace App\Controllers;

use App\Services\View;

class HomeController extends BaseController {


    public function index() {
        return View::make("index");
    }
    public function login() {
        return View::make('login', [
            'title' => 'Login page'
        ]);
    }

    public function register() {
        return View::make('register', [
            'title'=> 'Signup page'
        ]);
    }
}