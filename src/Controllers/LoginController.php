<?php

namespace App\Controllers;

use App\Core\Request;
use Doctrine\ORM\EntityManager;
use App\Models\User;
use App\Core\App;
use App\Core\Validators\Validator;
use App\Services\View;

class LoginController extends BaseController {

    public function index() {
        return View::make('login', [
            'title' => 'Login page'
        ]);
    }

    public function authenticate(EntityManager $entityManager, Request $request) {
        $user = $entityManager->getRepository(User::class)->findOneBy(["username"=> $request->get("username")]);
        $errors = (new Validator)->validate(array_merge($request->getAll(), ['user' => $user]), 'login');

        if (count($errors) > 0) {
            return View::make('login', [
                'title' => 'Login',
                'errors' => $errors,
                'request' => App::resolve(Request::class)->getAll(),
            ]);
        }

        $this->login(user: $user);
    }
    private function login(User $user) 
    {
        setActiveUser($user);
        session_regenerate_id(true);
        $this->redirect(to: '/');
    }

    public function logout() 
    {
        session_unset();
        $params = session_get_cookie_params();
        setcookie(session_name(),"", time() - 3600, $params['path']);
        return View::make("index", ["title"=> "Home"]);
    }

}