<?php

declare(strict_types=1);

namespace App\Controllers;

use App\AppCore\Routing\Url;
use App\AppCore\Utils\Persist;
use App\Routes\Routes;

class LogoutController
{
    public function destroy(): void
    {
        Persist::delete('loggedUser');
        Url::redirect(Routes::Homepage);
    }
}