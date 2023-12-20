<?php

use App\AppCore\Routing\Url;
use App\Routes\Routes;

include "Components/HtmlHead.php";
?>
    <div class="panel main-content">
        <header class="panel-header">
            <a href="<?= Url::create(Routes::Homepage)?>">
                <svg width="32" height="24" viewBox="0 0 32 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0.939339 10.9393C0.353552 11.5251 0.353552 12.4749 0.939339 13.0607L10.4853 22.6066C11.0711 23.1924 12.0208 23.1924 12.6066 22.6066C13.1924 22.0208 13.1924 21.0711 12.6066 20.4853L4.12132 12L12.6066 3.51472C13.1924 2.92893 13.1924 1.97918 12.6066 1.3934C12.0208 0.80761 11.0711 0.80761 10.4853 1.3934L0.939339 10.9393ZM32 10.5L2 10.5L2 13.5L32 13.5L32 10.5Z" fill="black"/>
                </svg>
            </a>
            <h1>Přihlášení</h1>
        </header>
    <main>
        <?php
            if (isset($this->data['successMessage'])) {
                echo '<div class="message message--success">';
                switch ($this->data['successMessage']) {
                    case 'registration':
                        echo 'Registrace proběhla úspěšně, nyní se můžete přihlásit.';
                        break;
                    case 'passwordChanged':
                        echo 'Vaše heslo bylo změněno, nyní se můžete přihlásit.';
                        break;
                    default:
                        echo 'Zkontrolujte svůj email, odeslali jsem vám odkaz pro obnovení hesla.';
                }
                echo '</div>';
            }

            if (isset($this->data['errorMessage'])) {
                echo '<div class="message message--error">';
                switch ($this->data['errorMessage']) {
                    case 'notRegistered':
                        echo 'Zadaný email není registrován.';
                        break;
                    default:
                        echo 'Zadané údaje nejsou správné. <span class="open-dialog" data-dialog="forgotten-password">Zapomenuté heslo</span>?';
                }
                echo '</div>';
            }
        ?>
        <form name="login" form action="<?= Url::create(Routes::Login)?>" method="post" class="panel-form" onsubmit="return validateForm('login')" novalidate>
            <label for="email" class="input-label">Email</label>
            <input type="email" name="email" id="email" class="input" value="<?= isset($this->data['formData']) ? $this->data['formData']['email'] : '' ?>" required>
            <label for="password" class="input-label">Heslo</label>
            <input type="password" name="password" id="password" class="input" required>
            <input type="submit" value="Přihlásit se" class="button button--right">
        </form>

    
    <a href="<?= Url::create(Routes::Register)?>" class="panel-link">Vytvořit účet</a>
    </main>
        <dialog id="forgotten-password" class="dialog">
            <div class="close-dialog-wrapper">
                <span class="close-dialog">✕</span>
            </div>
            <form action="<?= Url::create(Routes::RequestPasswordRecovery)?>" method="post" class="panel-form panel-form--dialog">
                <label for="reg-email" class="input-label">Registrační email</label>
                <input type="email" name="email" id="reg-email" class="input" value="<?= isset($this->data['formData']) ? $this->data['formData']['email'] : '' ?>" required>
                <input type="submit" value="Obnovit zapomenuté heslo" class="button button--full button--dialog">
            </form>
        </dialog>
    </div>
<?php
include "Components/Footer.php";
include "Components/HtmlFoot.php";