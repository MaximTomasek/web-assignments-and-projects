<?php

declare(strict_types=1);

namespace App\Validations;

class LoginValidation
{
    public static function validate(array $data): true|string
    {
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL) || strlen($data['password']) === 0) {
            return 'error';
        }

        return true;
    }
}