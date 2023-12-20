<?php

declare(strict_types=1);

namespace App\Controllers;

use App\AppCore\Controller\Controller;
use App\AppCore\Routing\Url;
use App\AppCore\Utils\Debug;
use App\AppCore\Utils\Persist;
use App\AppCore\Utils\Sanitize;
use App\AppCore\View\View;
use App\Models\PasswordRecoveryModel;
use App\Models\UserModel;
use App\Routes\Routes;
use App\Validations\PasswordRecoveryValidation;
use DateInterval;
use DateTime;
use Exception;

class PasswordRecoveryController extends Controller
{
    private UserModel $userModel;
    private PasswordRecoveryModel $passwordRecoveryModel;

    public function __construct()
    {
        parent::__construct();

        $this->userModel = new UserModel($this->connection);
        $this->passwordRecoveryModel = new PasswordRecoveryModel($this->connection);
    }

    public function store(): void
    {
        $sanitizedData = Sanitize::process($_POST);
        $validationResult = PasswordRecoveryValidation::validateRecoveryRequest($sanitizedData);

        if ($validationResult === true) {
            $user = $this->userModel->getUserByEmail($sanitizedData['email']);

            $emailSent = $this->passwordRecoveryModel->createEntry($user->email, $user->id);

            if ($emailSent) {
                Persist::set('successMessage', 'emailSent');
                Url::redirect(Routes::Login);
            }
        } else {
            Persist::set('errorMessage', $validationResult);
        }

        Persist::set('formData', $sanitizedData);
        Url::redirect(Routes::Login);
    }

    public function edit(array $urlParams): void
    {
        $tokenExpired = false; // vypršela platnost tokenu nebo se již nenachází v DB?
        $tokenCheck = $this->passwordRecoveryModel->getEntry($urlParams['token']);

        if($tokenCheck) { // test zda již není v DB
            // Token necháme aktivní pouze 24 hodin
            // vytvoříme si nový objekt DateTime, aby se nám lépe pracovalo s datumy
            try {
                $expireDate = new DateTime($tokenCheck->created); // pokud je řetězec datumu poškozený, může to vyvolat výjimku - proto voláme uvnitř try/catch
                $expireDate->add(DateInterval::createFromDateString('1 day')); // přidáme 1 den k času vytvoření a získáme tak datum expirace tokenu
                $currentDate = new DateTime(); // aktuální datum a čas

                // pokud je aktuální datum větší než datum expirace
                if ($currentDate > $expireDate) {
                    $tokenExpired = true;
                    // a odstraníme záznam z DB
                    $this->passwordRecoveryModel->deleteEntry($urlParams['token']);
                }
            } catch (Exception $e) {
                $tokenExpired = true;
            }
        } else {
            $tokenExpired = true;
        }


        View::make('PasswordRecovery', [
            'title' => 'Obnova hesla',
            'token' => $urlParams['token'],
            'tokenExpired' => $tokenExpired,
            'errorMessage' => Persist::get('errorMessage')
        ]);

        Persist::delete('errorMessage');
    }

    public function update(array $urlParams): void
    {
        $sanitizedData = Sanitize::process($_POST);
        $validationResult = PasswordRecoveryValidation::validateNewPassword($sanitizedData);

        if ($validationResult === true) {
            $tokenData = $this->passwordRecoveryModel->getEntry($urlParams['token']);
            // nastavení nového hesla
            $this->userModel->changePassword($tokenData->user_id, password_hash($sanitizedData['password'], PASSWORD_BCRYPT));
            // odstranění tokenu -> už ho nepotřebujeme
            $this->passwordRecoveryModel->deleteEntry($urlParams['token']);

            Persist::set('successMessage', 'passwordChanged');
            Url::redirect(Routes::Login);
        } else {
            Persist::set('errorMessage', $validationResult);
        }

        Url::redirect(Routes::PasswordRecovery, $urlParams);
    }
}