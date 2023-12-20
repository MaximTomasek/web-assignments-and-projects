<?php

use App\AppCore\Routing\Url;
use App\AppCore\Utils\Debug;
use App\Routes\Routes;

include "Components/HtmlHead.php";
?>
    <div class="panel main-content">
        <header>
            <h1>Obnovení hesla</h1>
        </header>
    <main>
        <?php
        if(isset($this->data['token']) && !$this->data['tokenExpired']) {
            if (isset($this->data['errorMessage'])) {
                echo '<div class="message message--error">';
                echo match ($this->data['errorMessage']) {
                    'password' => 'Heslo musí obsahovat číslici, velké a malé písmeno a musí mít nejméne 8 znaků.',
                    default => 'Heslo a Heslo znovu se neshodují.',
                };
                echo '</div>';
            }
        ?>

        <form action="<?= Url::create(Routes::PasswordRecovery, ['token' => $this->data['token']])?>" method="post" class="panel-form">
            <input type="hidden" name="_method" value="PATCH">
            <label for="password" class="input-label">Heslo</label>
            <input type="password" name="password" id="password" class="input" required>
            <label for="confirm-password" class="input-label">Heslo znovu</label>
            <input type="password" name="confirm-password" id="confirm-password" class="input" required>
            <input type="submit" value="Nastavit nové heslo" class="button button--right">
        </form>
        <?php
    } else {
    ?>  
    <div class="message message--error">Použitý klíč pro obnovu hesla již není aktivní!</div>
            <form action="<?= Url::create(Routes::RequestPasswordRecovery)?>" method="post" class="panel-form">
                <label for="reg-email" class="input-label">Registrační email</label>
                <input type="email" name="email" id="reg-email" class="input" value="<?= isset($this->data['formData']) ? $this->data['formData']['email'] : '' ?>" required>
                <input type="submit" value="Vytvořit nový klíč" class="button button--full button--dialog">
            </form>
        <?php
        }
        ?>

            <a href="<?= Url::create(Routes::Homepage)?>" class="panel-link">Přejít na hlavní stránku aplikace</a>
        </main>
    </div>
<?php
include "Components/Footer.php";
include "Components/HtmlFoot.php";