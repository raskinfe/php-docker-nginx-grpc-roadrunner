<?php

use App\Controllers\HomeController;
use App\Controllers\LoginController;
use App\Controllers\NoteController;
use App\Controllers\RegisterController;
use App\Core\Router;
use App\Services\View;

$router = new Router();

$router->get("/", [HomeController::class, "index"]);
$router->get("/register", [RegisterController::class, "index"])->only("index");
$router->post("/register", [RegisterController::class, "store"]);
$router->get("/login", [LoginController::class, "index"])->only('guest');
$router->post("/login", [LoginController::class,"authenticate"]);
$router->get("/logout", [LoginController::class, 'logout'])->only('auth');
$router->get("/notes", [NoteController::class,"index"])->only('auth');
$router->post("/create-note", [NoteController::class, "create"])->only('auth');
$router->get("/note", [NoteController::class,"get"])->only('auth');
$router->patch("/note", [NoteController::class,"update"])->only('auth');
$router->delete("/note", [NoteController::class,"destroy"])->only('auth');

//  EDIT LATER and HANDLE IN CONTROLLER CLASS
$router->get("/about", function() {
    return View::make('about', ['title' => 'About']);
})->only('auth');
$router->get("/contact", function() {
    return View::make('contact', ['title'=> 'Contact']);
})->only('auth');
$router->get("/404", function() {
    return View::make("404", ["title"=> "Not found"]);
});

$requestUri = explode('?', $_SERVER['REQUEST_URI'])[0];
$requestMethod = $_POST['_method'] ?? $_SERVER['REQUEST_METHOD'] ?? '';
setActiveLink($requestUri);
$router->route($requestUri, $requestMethod);

