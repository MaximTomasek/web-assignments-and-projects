<?php

declare(strict_types=1);

namespace App;

use App\AppCore\Exceptions\EnvFileNotFoundException;
use App\AppCore\Utils\EnvParser;

class App {
    public function __construct()
    {
        session_start();

        try {
            EnvParser::parse("../.env");
        } catch(EnvFileNotFoundException $e) {
            // TODO: nahradit lepším zpracováním chyby
            echo "Chyba aplikace...";
            die();
        }
    }

    public function run(): void
    {
        // TODO: doopravdy spustit aplikaci
        echo "Aplikace běží...";
    }
}