<?php

declare(strict_types=1);

namespace App\AppCore\Database;

use PDO;
use PDOException;

class Database
{
    private PDO|null $connection;

    public function __construct()
    {
        try {
            $host = getenv('MYSQL_HOST');
            $database = getenv('MYSQL_DATABASE');

            $this->connection = new PDO(
                "mysql:host=$host;dbname=$database;charset=utf8mb4",
                getenv('MYSQL_USER'),
                getenv('MYSQL_PASSWORD'),
                array(
                    PDO::ATTR_EMULATE_PREPARES => false,
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                )
            );
        } catch(PDOException $e) {
            // TODO: nahradit lepším zpracováním chyby
            echo "Chyba aplikace";
        }
    }

    public function __destruct()
    {
        $this->connection = null;
    }

    public function getConnection(): PDO
    {
        if (!$this->connection) {
            // TODO: nahradit lepším zpracováním chyby
            echo "Chyba aplikace";
        }

        return $this->connection;
    }
}