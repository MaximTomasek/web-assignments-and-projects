<?php

declare(strict_types=1);

namespace App\Controllers;

use App\AppCore\Controller\Controller;
use App\AppCore\Routing\Url;
use App\AppCore\Utils\Debug;
use App\AppCore\Utils\Persist;
use App\AppCore\Utils\Sanitize;
use App\AppCore\View\View;
use App\Models\UserModel;
use App\Routes\Routes;
use App\Validations\LoginValidation;

class LoginController extends Controller
{
    private UserModel $model;

    public function __construct()
    {
        parent::__construct();

        $this->model = new UserModel($this->connection);
    }

    public function create(): void
    {
        View::make('Login', [
            'title' => 'Přihlášení',
            'errorMessage' => Persist::get('errorMessage'),
            'successMessage' => Persist::get('successMessage'),
            'formData' => Persist::get('formData')
        ]);

        Persist::delete(['errorMessage', 'successMessage', 'formData']);
    }

    public function store(): void
    {
        $sanitizedData = Sanitize::process($_POST);
        $validationResult = LoginValidation::validate($sanitizedData);

        if ($validationResult === true) {
            $user = $this->model->getUserByEmail($sanitizedData['email']);

            if ($user) {
                if (password_verify($sanitizedData['password'], $user->password)) {
                    Persist::set('loggedUser', $user);
                    Url::redirect(Routes::Todos);
                } else {
                    Persist::set('errorMessage', 'error');
                }
            } else {
                Persist::set('errorMessage', 'notRegistered');
            }
        } else {
            Persist::set('errorMessage', $validationResult);
        }

        Persist::set('formData', $sanitizedData);
        Url::redirect(Routes::Login);
    }
}