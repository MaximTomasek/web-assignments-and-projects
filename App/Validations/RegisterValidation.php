<?php

declare(strict_types=1);

namespace App\Validations;

class RegisterValidation
{
    public static function validate(array $data): true|string
    {
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL) || strlen($data['username']) === 0) {
            return 'error';
        }

        if (preg_match(
            '/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$/',
            $data['password']) === false) {
            return 'password';
        }

        if ($data['password'] !== $data['confirm-password']) {
            return 'confirmPassword';
        }

        if (!isset($data['terms'])) {
            return 'error';
        }

        return true;
    }
}