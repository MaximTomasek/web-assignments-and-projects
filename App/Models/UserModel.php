<?php

declare(strict_types=1);

namespace App\Models;

use App\AppCore\Model\Model;
use App\AppCore\Routing\Url;
use App\Routes\Routes;
use PDO;
use PDOException;

class UserModel extends Model
{
    public function getUserByEmail(string $email): object|false
    {
        try {
            $statement = $this->connection->prepare('SELECT * FROM `users` WHERE `email`=?');
            $statement->execute([$email]);

            return $statement->fetch(PDO::FETCH_OBJ);
        } catch(PDOException $e) {
            Url::redirect(Routes::AppError);
        }
    }

    public function createUser(string $email, string $userName, string $passwordHash): void
    {
        try {
            $statement = $this->connection->prepare('INSERT INTO `users`(`username`, `email`, `password`) VALUES (?, ?, ?)');
            $statement->execute([$userName, $email, $passwordHash]);
        } catch(PDOException $e) {
            Url::redirect(Routes::AppError);
        }
    }

    public function changePassword(int $userId, string $passwordHash): void
    {
        try {
            $statement = $this->connection->prepare('UPDATE `users` SET `password`=? WHERE `id`=?');
            $statement->execute([$passwordHash, $userId]);
        } catch(PDOException $e) {
            Url::redirect(Routes::AppError);
        }
    }
}