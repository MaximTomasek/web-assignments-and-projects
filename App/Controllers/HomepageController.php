<?php

declare(strict_types=1);

namespace App\Controllers;

use App\AppCore\View\View;

class HomepageController
{
    public function index(): void
    {
        View::make('Homepage');
    }
}