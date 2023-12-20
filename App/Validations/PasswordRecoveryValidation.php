<?php

declare(strict_types=1);

namespace App\Validations;

class PasswordRecoveryValidation
{
    public static function validateRecoveryRequest(array $data): true|string
    {
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            return 'error';
        }

        return true;
    }

    public static function validateNewPassword(array $data): true|string
    {
        if (preg_match(
                '/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$/',
                $data['password']) === false) {
            return 'password';
        }

        if ($data['password'] !== $data['confirm-password']) {
            return 'confirmPassword';
        }

        return true;
    }
}