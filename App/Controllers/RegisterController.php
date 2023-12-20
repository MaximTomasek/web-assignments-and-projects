<?php

declare(strict_types=1);

namespace App\Controllers;

use App\AppCore\Controller\Controller;
use App\AppCore\Routing\Url;
use App\AppCore\Utils\Email;
use App\AppCore\Utils\Persist;
use App\AppCore\Utils\Sanitize;
use App\AppCore\View\View;
use App\Models\UserModel;
use App\Routes\Routes;
use App\Validations\RegisterValidation;

class RegisterController extends Controller
{
    private UserModel $model;

    public function __construct()
    {
        parent::__construct();

        $this->model = new UserModel($this->connection);
    }

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
        $sanitizedData = Sanitize::process($_POST);
        $validationResult = RegisterValidation::validate($sanitizedData);

        if ($validationResult === true) {
            $userExists = $this->model->getUserByEmail($sanitizedData['email']);

            if ($userExists) {
                Persist::set('errorMessage', 'userRegistered');
            } else {
                $this->model->createUser(
                    $sanitizedData['email'],
                    $sanitizedData['username'],
                    password_hash($sanitizedData['password'], PASSWORD_BCRYPT)
                );

                Persist::set('successMessage', 'registration');
                Email::send(
                    $sanitizedData['email'],
                    getenv('APP_EMAIL'),
                    'Registrace byla úspěšná',
                    'Dobrý den, vaše registrace v Úkoly.loc byla úspěšná :)'
                );
                Url::redirect(Routes::Login);
            }
        } else {
            Persist::set('errorMessage', $validationResult);
        }

        Persist::set('formData', $sanitizedData);
        Url::redirect(Routes::Register);
    }
}