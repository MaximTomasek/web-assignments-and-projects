<?php

declare(strict_types=1);

namespace App\AppCore\Utils;

class Debug
{
    public static function d(mixed $var): void
    {
        echo '<pre>';
        var_dump($var);
        echo '</pre>';
    }

    public static function dd(mixed $var): never
    {
        echo '<pre>';
        var_dump($var);
        echo '</pre>';
        exit();
    }
}