<?php

use App\AppCore\Routing\Url;
use App\Routes\Routes;

include "Components/HtmlHead.php";
?>
    <nav>
        <div class="nav container">
            <a href="<?= Url::create(Routes::Homepage)?>" class="logo">náhodný <span>blog</span></a>
            <a href="<?= Url::create(Routes::Login)?>" class="button">Příhlásit se</a>
            <a href="<?= Url::create(Routes::Register)?>" class="registration">Vytvořit účet</a>
        </div>
    </nav>

    <main>
        <h1>Stránka nenalezena</h1>
        <p>Stránka, kterou hledáte v aplikaci neexistuje. Máte správný odkaz?</p>
    </main>

<?php
include "Components/Footer.php";
include "Components/HtmlFoot.php";