<?php

namespace App\Core\Validators;

final class Validator {

    const VALIDATOR_MAP = [
        'login' => LoginValidator::class,
        'register' => RegisterValidator::class,
    ];
    public function validate(array $data, string $key): array {
        if (!array_key_exists($key, self::VALIDATOR_MAP)) {
            throw new \InvalidArgumentException($key. "Validator not found");
        }

        $validator = self::VALIDATOR_MAP[$key];
        return (new $validator)->validate($data);
    }
}