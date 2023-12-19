<?php

declare(strict_types=1);

namespace App;

use App\AppCore\Exceptions\EnvFileNotFoundException;
use App\AppCore\Exceptions\RouteNotFoundException;
use App\AppCore\Routing\Router;
use App\AppCore\Utils\EnvParser;
use App\AppCore\View\View;
use App\Controllers\RegisterController;
use App\Routes\Routes;
use Closure;
use App\Controllers\HomepageController;

class App {
    private Router $router;

    public function __construct()
    {
        session_start();

        try {
            EnvParser::parse("../.env");
        } catch(EnvFileNotFoundException $e) {
            View::make('AppError');
            die();
        }

        define('__APP_ROOT__', $_SERVER['DOCUMENT_ROOT'] . '/');
        define('__APP_RESOURCES__', getenv('APP_DOMAIN') . getenv('APP_SUB_FOLDERS') . 'Resources/');

        $this->router = new Router();
    }

    private function registerRoutes(): void
    {
        $this->router->get(Routes::Homepage, [HomepageController::class, 'index']);
        $this->router->get(Routes::AppError, Closure::fromCallable(
            function () {
                View::make('AppError');
            }
        ));

        $this->router
            ->get(Routes::Register, [RegisterController::class, 'create'])
            ->post(Routes::Register, [RegisterController::class, 'store']);
    }

    public function run(): void
    {
        try {
            $this->registerRoutes();
            $this->router->resolveRequest();
        } catch (RouteNotFoundException $e) {
            http_response_code(404);
            View::make('NotFound');
        }
    }
}