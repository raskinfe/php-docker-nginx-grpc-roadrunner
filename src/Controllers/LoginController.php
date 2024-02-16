<?php

namespace App\Controllers;

use App\Core\Request;
use Doctrine\ORM\EntityManager;
use App\Models\User;
use App\Core\App;
use App\Core\Validators\Validator;
use App\Services\View;

class LoginController extends BaseController {

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

        setActiveUser($user);
        session_regenerate_id(true);
        $this->redirect(to: '/');
    }

    public function store(EntityManager $entityManager, Request $request) {
        $name = $request->get('name');
        $email = $request->get('email');
        $password = $request->get('password');
        $username = $request->get('username');
        $user = new User();


        try {
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

        } catch(\Exception $e) {
            $message= $e->getMessage();
            setFlashMessage(message: $message, type:'error');
            return View::make(path: 'register', args: [
                'title' => 'Signup page',
                'request' => App::resolve(Request::class)->getAll(),
            ]);
        }
    }

}