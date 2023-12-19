<?php

declare(strict_types=1);

namespace App\Routes;

enum Routes: string
{
    case Homepage = '/';
    case Login = '/prihlaste-se';
    case Logout = '/odhlasit-se';
    case RequestPasswordRecovery = '/reset-hesla/zadost';
    case PasswordRecovery = '/reset-hesla/{token}';
    case Register = '/registrace';
    case AppError = '/chyba';
}