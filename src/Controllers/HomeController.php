<?php

namespace App\Controllers;

use App\Services\View;

class HomeController extends BaseController {


    public function index() {
        return View::make("index");
    }
}