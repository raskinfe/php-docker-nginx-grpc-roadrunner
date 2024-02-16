<?php

namespace App\Core\Validators;
use App\Models\User;
use Doctrine\ORM\EntityManager;

class RegisterValidator extends AbstractValidator {

    public function validate(array $data): array {

        if(empty($data["username"]) || empty($data["password"]) || empty($data['email'])) {
            $this->addError(['username' => $data['username'],'body' => 'username is required']);
            $this->addError(['password' => $data['password'],'body' => 'password is required']);
            $this->addError(['email' => $data['email'],'body' => 'email is required']);
            return $this->errors;
        }

        $this->validateEntry(user: $data['user'], em: $data['entityManager']);

        return $this->errors;
    }

    private function validateEntry(User $user, EntityManager $em) {
        $existing = $em->getRepository(User::class)
        ->findOneBy(['username' => $user->getUsername()]);

        if(!empty($existing)) { 
            $this->addError(['username'=> $user->getUsername(), 'body' => 'Username is taken. please choose a different one']);
        }

        $existing =$em->getRepository(User::class)
        ->findOneBy(['email' => $user->getEmail()]);

        if(!empty($existing)) { 
            $this->addError(['email'=> $user->getEmail(), 'body' => 'an account with this email already exist']);
        }
    }

}