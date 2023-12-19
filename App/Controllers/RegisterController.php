<?php

declare(strict_types=1);

namespace App\Controllers;

use App\AppCore\Routing\Url;
use App\AppCore\Utils\Debug;
use App\AppCore\Utils\Persist;
use App\AppCore\View\View;
use App\Routes\Routes;
use App\Validations\RegisterValidation;

class RegisterController
{
    // zobrazení formuláře
    public function create(): void
    {
        View::make('Register', [
            'title' => 'Registrace',
            'errorMessage' => Persist::get('errorMessage'),
            'formData' => Persist::get('formData')
        ]);

        Persist::delete(['errorMessage', 'formData']);
    }

    // zpracování odeslaných dat
    public function store(): void
    {
        $validationResult = RegisterValidation::validate($_POST);

        if ($validationResult === true) {
            Debug::dd($_POST);
        } else {
            Persist::set('errorMessage', $validationResult);
            Persist::set('formData', $_POST);
        }

        Url::redirect(Routes::Register);
    }
}