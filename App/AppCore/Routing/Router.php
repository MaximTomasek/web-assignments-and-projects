<?php

declare(strict_types=1);

namespace App\AppCore\Routing;

use App\AppCore\Enums\HttpMethod;
use Closure;
use App\AppCore\Exceptions\RouteNotFoundException;

class Router
{
    /** @var Route[] $routes */
    private array $routes;

    public function __construct()
    {
        $this->routes = [];
    }

    private function routeExists(string $route, HttpMethod $method): bool
    {
        foreach ($this->routes as $currentRoute) {
            if (
                $currentRoute->route === $route &&
                $currentRoute->method === $method
            ) {
                return true;
            }
        }

        return false;
    }

    private function addRoute(
        HttpMethod $method,
        string $route,
        array|Closure $handler, // [JménoKontroleru, metoda] nebo funkce, která rovnou něco zobrazí (bez DB apod.)
        bool $protected,
    ): void
    {
        if (!$this->routeExists($route, $method)) {
            $this->routes[] = new Route($route, $method, $handler, $protected);
        }
    }

    // Cesty, které zobrazují obsah
    public function get(string $route, array|Closure $handler, bool $protected = false): Router
    {
        $this->addRoute(HttpMethod::Get, $route, $handler, $protected);
        return $this;
    }

    // Cesty pro vytváření nového obsahu
    public function post(string $route, array|Closure $handler, bool $protected = false): Router
    {
        $this->addRoute(HttpMethod::Post, $route, $handler, $protected);
        return $this;
    }

    // Cesty pro úpravu existujícího obsahu
    public function patch(string $route, array|Closure $handler, bool $protected = false): Router
    {
        $this->addRoute(HttpMethod::Patch, $route, $handler, $protected);
        return $this;
    }

    // Cesty pro mazání obsahu
    public function delete(string $route, array|Closure $handler, bool $protected = false): Router
    {
        $this->addRoute(HttpMethod::Delete, $route, $handler, $protected);
        return $this;
    }

    public function resolveRequest(): void
    {
        // URL kam přišel uživatel, ze kterého získáváme:
        // - pouze cestu bez domény
        // - odstraňujeme podsložky
        $requestRoute = str_replace(
            getenv('APP_SUB_FOLDERS'),
            '',
            parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
        );

        // Zjištění metody požadavku:
        // - pokud se jedná o formulář, kde cheme jinou metodu než POST, tak bude
        //   uložená ve skrytém poli _method
        // - jinak vezmeme metodu požadavku z $_SERVER
        $requestMethod = htmlspecialchars($_POST['_method'] ?? $_SERVER['REQUEST_METHOD']);

        foreach ($this->routes as $route) {
            // Cesty s dynamickými prvky budeme zapisovat následovně:
            // /prispevek/{id} -> /prispevek/.*
            // /prispevek/{id}/edit -> /prispevek/.*/edit (/prispevek/5/edit)
            // nebo
            // /prispevek/{slug}/edit -> /prispevek/.*/edit
            $routeRegex = preg_replace(
                '|{.*}|',
                '.*',
                $route->route
            );

            // Test regulárním výrazem zda skutečný odkaz kam uživatel přišel
            // je shodný s cestou zaregistrovanou v Routeru
            $match = preg_match("|^$routeRegex$|", $requestRoute);

            // Test jestli odkaz odpovídá aktuální cestě a zároveň jestli je správná i methoda požadavku
            if ($match === 1 && $route->method->value === $requestMethod) {
                if ($route->protected && !isset($_SESSION['loggedUser'])) {
                    // Přesměrování na hlavní stránku
                    // TODO: vytvořit pomocnou třídu pro přesměrování
                }

                $params = []; // pomocná proměnná pro uložení parametrů z odkazu -> ['id' => 5]

                if ($requestRoute !== '/') {
                    $routeParts = explode('/', $route->route);
                    $requestRouteParts = explode('/', $requestRoute);

                    foreach ($routeParts as $index => $value) {
                        $idName = [];
                        preg_match(
                            '/(?<={).+?(?=})/',
                            $value,
                            $idName
                        );

                        if ($idName) {
                            $params[$idName[0]] = $requestRouteParts[$index];
                        }
                    }
                }

                if (is_callable($route->handler)) {
                    call_user_func($route->handler);
                    return;
                }

                if (class_exists($route->handler[0])) {
                    $controller = new $route->handler[0](); // new JmenoKontroleru();

                    if (method_exists($controller, $route->handler[1])) {
                        $method = $route->handler[1];
                        $controller->$method($params);
                    }
                }
            }
        }

        throw new RouteNotFoundException("Route: $requestRoute not found!");
    }
}