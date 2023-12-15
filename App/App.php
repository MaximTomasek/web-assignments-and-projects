<?php

declare(strict_types=1);

namespace App;

use App\AppCore\Exceptions\EnvFileNotFoundException;
use App\AppCore\Exceptions\RouteNotFoundException;
use App\AppCore\Routing\Router;
use App\AppCore\Utils\EnvParser;
use App\Routes\Routes;
use Closure;

class App {
    private Router $router;

    public function __construct()
    {
        session_start();
        define('__APP_ROOT__', $_SERVER['DOCUMENT_ROOT'] . '/');

        try {
            EnvParser::parse("../.env");
        } catch(EnvFileNotFoundException $e) {
            // TODO: zobrazit správnou šablonu
            echo "Chyba aplikace...";
            die();
        }

        $this->router = new Router();
    }

    private function registerRoutes(): void
    {
        $this->router->get(Routes::Homepage, Closure::fromCallable(
            function() {
                echo "Hlavní stránka";
            }));
    }

    public function run(): void
    {
        try {
            $this->registerRoutes();
            $this->router->resolveRequest();
        } catch (RouteNotFoundException $e) {
            http_response_code(404);
            // TODO: zobrazit správnou šablonu
            echo "Stránka nenalezena!";
        }
    }
}