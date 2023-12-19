<?php

declare(strict_types=1);

namespace App\Routes;

enum Routes: string
{
    case Homepage = '/';
    case Login = '/prihlaste-se';
    case Register = '/registrace';
    case AppError = '/chyba';
}