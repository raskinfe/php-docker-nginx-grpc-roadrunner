<?php

use App\Controllers\HomeController;
use App\Controllers\NoteController;
use App\Services\Router;
use App\Services\View;

$router = new Router();

$router->get("/", [HomeController::class, "index"]);
$router->get("/login", [HomeController::class, "login"])->only('guest');
$router->post("/login", [HomeController::class,"authenticate"]);
$router->get("/register", [HomeController::class, "register"])->only("index");
$router->post("/register", [HomeController::class, "store"]);
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
$router->get("/logout", function() {
    session_unset();
    return View::make("index", ["title"=> "Home"]);
})->only('auth');
$router->get("/404", function() {
    return View::make("404", ["title"=> "Not found"]);
});

$uri = explode('?', $_SERVER['REQUEST_URI'])[0];
$method = $_POST['_method'] ?? $_SERVER['REQUEST_METHOD'];

setActiveLink($uri);
$router->route($uri, $method);