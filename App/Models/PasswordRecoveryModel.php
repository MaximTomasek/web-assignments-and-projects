<?php

declare(strict_types=1);

namespace App\Models;

use App\AppCore\Model\Model;
use App\AppCore\Routing\Url;
use App\AppCore\Utils\Email;
use App\Routes\Routes;
use PDO;
use PDOException;

class PasswordRecoveryModel extends Model
{
    public function getEntry(string $token): object|false
    {
        try {
            $statement = $this->connection->prepare('SELECT * FROM `password_reset` WHERE `token`=?');
            $statement->execute([$token]);

            return $statement->fetch(PDO::FETCH_OBJ);
        } catch(PDOException $e) {
            Url::redirect(Routes::AppError);
        }
    }

    public function createEntry(string $email, int $userId): bool
    {
        try {
            $token = md5(strval(time()));

            $statement = $this->connection->prepare('INSERT INTO `password_reset`(`user_id`, `token`) VALUES (?, ?)');
            $statement->execute([$userId, $token]);

            $link = Url::create(Routes::PasswordRecovery, ['token' => $token]);

            return Email::send($email, getenv('APP_EMAIL'), 'Žádost o reset hesla', 'Pro nastavení nového hesla kliněte na následující odkaz: <a href="' . $link . '">' . $link . '</a>');
        } catch(PDOException $e) {
            Url::redirect(Routes::AppError);
        }
    }

    public function deleteEntry(string $token): void
    {
        try {
            $statement = $this->connection->prepare('DELETE FROM `password_reset` WHERE `token`=?');
            $statement->execute([$token]);
        } catch(PDOException $e) {
            Url::redirect(Routes::AppError);
        }
    }
}