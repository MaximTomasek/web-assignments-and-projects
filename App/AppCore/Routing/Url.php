<?php

declare(strict_types=1);

namespace App\AppCore\Routing;

use App\Routes\Routes;

class Url
{
    /**
     * @param Routes $route cesta, ze které chceme vytvořit odkaz
     * @param array $params acosiativné pole ve tvaru ['id' => 5]
     * @return string
     */
    public static function create(Routes $route, array $params = []): string
    {
        $url = $route->value;
        if ($params) {
            $regexArray = [];
            $values = [];
            foreach ($params as $key => $value) {
                $regexArray[] = "/{$key}/";
                $values[] = $value;
            }

            $url = preg_replace(
                $regexArray,
                $values,
                $route->value
            );
        }

        $folders = getenv('APP_SUB_FOLDERS');

        if ($folders) {
            $folders = substr($folders, 0, strlen($folders) - 2);
        }

        return getenv('APP_DOMAIN') . $folders . $url;
    }

    public static function redirect(Routes $route, array $params = []): never
    {
        $newLocation = self::create($route, $params);
        header("Location: $newLocation");
        exit();
    }
}