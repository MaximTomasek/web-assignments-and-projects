<?php

declare(strict_types=1);

namespace App\AppCore\Routing;

use App\AppCore\Enums\HttpMethod;
use App\Routes\Routes;
use Closure;
use App\AppCore\Exceptions\RouteNotFoundException;

/**
 * Třída Router - zjednodušeně řečeno se jedná o rozcestník, který přerozděluje
 * práci uvnitř PHP programu, podle toho, na kterou stránku příjde uživatel (rozlišuje
 * se podle odkazu).
 */
class Router
{
    /** @var Route[] $routes */
    private array $routes;

    public function __construct()
    {
        $this->routes = [];
    }

    // Soukromá metoda pro test, zda se cesta už zaregistrovaná
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

    // Soukromá metoda pro registraci nových cest.
    private function addRoute(
        HttpMethod $method,
        string $route,
        array|Closure $handler, // [JménoKontroleru, metoda] nebo funkce, která rovnou něco zobrazí (bez DB apod.)
        bool $protected,
    ): void
    {
        if (!$this->routeExists($route, $method)) {
            // pokud cesta není již zaregistrována, tak ji přidáme do pole cest (zaregistrujeme)
            // cesta je reprezentována Objektem Route, který obsahuje všechny potřebné informace.
            $this->routes[] = new Route($route, $method, $handler, $protected);
        }
    }

    // Cesty, které zobrazují obsah
    public function get(Routes $route, array|Closure $handler, bool $protected = false): Router
    {
        $this->addRoute(HttpMethod::Get, $route->value, $handler, $protected);
        return $this;
    }

    // Cesty pro vytváření nového obsahu
    public function post(Routes $route, array|Closure $handler, bool $protected = false): Router
    {
        $this->addRoute(HttpMethod::Post, $route->value, $handler, $protected);
        return $this;
    }

    // Cesty pro úpravu existujícího obsahu
    public function patch(Routes $route, array|Closure $handler, bool $protected = false): Router
    {
        $this->addRoute(HttpMethod::Patch, $route->value, $handler, $protected);
        return $this;
    }

    // Cesty pro mazání obsahu
    public function delete(Routes $route, array|Closure $handler, bool $protected = false): Router
    {
        $this->addRoute(HttpMethod::Delete, $route->value, $handler, $protected);
        return $this;
    }

    // Metoda pro přerozdělování práce uvnitř aplikace.
    public function resolveRequest(): void
    {
        // URL kam přišel uživatel, ze kterého získáváme:
        // - pouze cestu bez domény
        // - odstraňujeme podsložky (v mém případě codingschool_winter/public/)
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

        // Cyklem projdeme všechny zaregistrované cesty
        foreach ($this->routes as $route) {
            // Odkazy s dynamickými prvky budeme zapisovat následovně:
            //  cesta v routeru -> regulární výraz pro hledání shody -> jak vypadá odkaz v prohlížeči (kam přišel uživatel)
            //
            // /prispevek/{id} -> /prispevek/.* -> /prispevek/5
            // /prispevek/{id}/edit -> /prispevek/.*/edit -> /prispevek/5/edit
            // nebo
            // /prispevek/{slug}/edit -> /prispevek/.*/edit -> /prispevek/jak-programovat-v-php/edit
            $routeRegex = preg_replace(
                '|{.*}|',
                '.*',
                $route->route
            );

            // Test regulárním výrazem zda skutečný odkaz kam uživatel přišel
            // je shodný s cestou zaregistrovanou v Routeru
            $match = preg_match("|^$routeRegex$|", $requestRoute);

            // Test jestli odkaz odpovídá aktuální cestě a zároveň jestli je správná i HTTP methoda požadavku
            if ($match === 1 && $route->method->value === $requestMethod) {
                if ($route->protected && !isset($_SESSION['loggedUser'])) {
                    // Přesměrování na hlavní stránku
                    Url::redirect(Routes::AppError);
                }

                $params = []; // pomocná proměnná pro uložení parametrů z odkazu -> ['id' => 5]

                // Pokud uživatel není na hlavní stránce aplikace -> vytovříme pole parametrů
                if ($requestRoute !== '/') {
                    // cestu zaregistrovanou v routeru i odkaz kam příšel uživatel
                    // rozdelíme podle lomítka na jednotlivá "slova"
                    $routeParts = explode('/', $route->route);
                    $requestRouteParts = explode('/', $requestRoute);

                    // cyklem projdeme rozdělenou cestu a hledáme zástupné identifikátory v {}
                    foreach ($routeParts as $index => $value) {
                        $idName = [];
                        // Hledání shody se způsobem zápisu zástupných ID (např. {page})
                        preg_match(
                            '/(?<={).+?(?=})/',
                            $value,
                            $idName
                        );

                        // pokud jsme našli shodu, přidáme ji do pole parametrů
                        if ($idName) {
                            // v $idName[0] je slovo uvnitř {} -> ovšem nyní bez {}, závorky jsme
                            // odstranili pomocí fce preg_match
                            // takže vytváříme např ['id' => 5]
                            $params[$idName[0]] = $requestRouteParts[$index];
                        }
                    }
                }

                // test jestli je obsluha požadavku funkce -> pokud ano, zavoláme ji a zastavíme router pomocí return
                if (is_callable($route->handler)) {
                    call_user_func($route->handler);
                    return;
                }

                // test jestli je obsluha třída -> první prvek v poli
                if (class_exists($route->handler[0])) {
                    // pokud ano, vytvoříme z ní nový objekt
                    $controller = new $route->handler[0](); // new JmenoKontroleru();
                    // a otestujeme, zda obsahuje metodu, kterou jsme předali jako druhý prvek pole
                    if (method_exists($controller, $route->handler[1])) {
                        $method = $route->handler[1];
                        // pokud ano, zavoláme ji a vyřídíme tak požadavek uživatele -> následně zastavíme router pomocí return
                        $controller->$method($params);
                        return;
                    }
                }
            }
        }

        // Pokud jsme se dostali až sem, znamená to, že uživatel zadal do prohlížeče
        // odkaz, pro který není zaregistrována žádná cesta -> vyhodíme výjimku, na kterou následně zareagujeme
        // v jiné části programu
        throw new RouteNotFoundException("Route: $requestRoute not found!");
    }
}