<?php

namespace App\Controllers;


use App\Models\User;
use App\Core\App;
use App\Core\Validators\Validator;
use App\Services\View;
use Doctrine\ORM\EntityManager;
use App\Core\Request;



class RegisterController extends BaseController {

    public function index() {
        return View::make('register', [
            'title'=> 'Signup page'
        ]);
    }

    public function store(EntityManager $entityManager, Request $request) {
        $name = $request->get('name');
        $email = $request->get('email');
        $password = $request->get('password');
        $username = $request->get('username');
        $user = new User();

        $user->setName($name);
        $user->setUsername($username);
        $user->setEmail($email);

        $errors = (new Validator)->validate(array_merge($request->getAll(), ['user' => $user, 'entityManager' => $entityManager]), 'register');

        if (count($errors) > 0) {
            return View::make('register', [
                'title' => 'Login',
                'errors' => $errors,
                'request' => App::resolve(Request::class)->getAll(),
            ]);
        }

        $hash = password_hash($password, PASSWORD_BCRYPT);
        $user->setPassword($hash);

        $entityManager->persist($user);
        $entityManager->flush();

        $message= 'You have been successfully registered!!!';

        setFlashMessage(message: $message);
        $this->redirect(to: '/login');
    }


}