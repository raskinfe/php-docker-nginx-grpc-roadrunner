<?php

namespace App\Controllers;

use App\Services\View;
use App\Core\Request;
use Doctrine\ORM\EntityManager;
use App\Models\User;
use App\Core\App;

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

    public function authenticate(EntityManager $entityManager, Request $request) {
        $user = $entityManager->getRepository(User::class)->findOneBy(['username'=> $request->get('username')]);
        if (!$user) { 
            return View::make(path: 'login', args: [
                'title' => 'Signup page',
                'errors' => [
                    'username' => $request->get('username'),
                    'body' => 'wrong username'
                ],
                'request' => App::resolve(Request::class)->getAll(),
            ]);
        }

        if (!$this->checkPassword($user, $request->get('password'))) {
            return View::make(path: 'login', args: [
                'title' => 'Signup page',
                'errors' => [
                    'password' => $request->get('password'),
                    'body' => 'wrong password'
                ],
                'request' => App::resolve(Request::class)->getAll(),
            ]);
        }

        setActiveUser($user);
        
        $this->redirect(to: '/');
    }

    private function checkPassword(User $user, string $password) {
        return $user->getPassword() === $password;
    }

    private function validateUser(User $user, EntityManager $entityManager) {
        $existing = $entityManager->getRepository(User::class)
        ->findOneBy(['username' => $user->getUsername()]);
        
        if(!empty($existing)) { 
            throw new \Exception('Username is taken. please choose a different one');
        }

        $existing = $entityManager->getRepository(User::class)
        ->findOneBy(['email' => $user->getEmail()]);

        if(!empty($existing)) { 
            throw new \Exception('This email address is registered with us.');
        }
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
            $user->setPassword($password);

            $this->validateUser(user: $user, entityManager: $entityManager);

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