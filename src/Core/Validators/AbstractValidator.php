<?php

namespace App\Core\Validators;

abstract class AbstractValidator {
    protected $errors = [];
    public function validate(array $data){}
    protected function addError($errors) {
        foreach($errors as $key => $message) {
            $this->errors[$key] = $message;
        }
    }
}