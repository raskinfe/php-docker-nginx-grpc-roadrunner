<?php

namespace App\Core;

interface ValidatorInterface {
    public function validate(array $data);
}