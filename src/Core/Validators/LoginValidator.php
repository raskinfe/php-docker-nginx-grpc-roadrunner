<?php

namespace App\Core\Validators;
use App\Models\User;

class LoginValidator extends AbstractValidator {

    public function validate(array $data): array {

        if(empty($data["username"]) || empty($data["password"])) {
            $this->addError(['username' => $data['username'],'body' => 'username is required']);
            $this->addError(['password' => $data['password'],'body' => 'password is required']);
            return $this->errors;
        }

        $this->validateUsername(username: $data["username"], user: $data['user']);
        
        if (!count($this->errors) > 0) {
            $this->validatePassword(password: $data["password"], user: $data['user']);
        }

        return $this->errors;
    }

    private function validateUsername(User | null $user, string $username) {
        if (!$user) { 
            $this->addError(['username' => $username,'body' => 'wrong username']);
        }
    }

    private function validatePassword(User | null $user, string $password) { 
        if (!password_verify($password, $user->getPassword())) {
            $this->addError(
                [
                    'password' => $password,
                    'body' => 'wrong password'
                ]
            );
        }
    }

}