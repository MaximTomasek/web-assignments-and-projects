<?php

use App\AppCore\Routing\Url;
use App\Routes\Routes;

include "Components/HtmlHead.php";
?>

<div class="panel main-content ">
  <header class="panel-header">
    <a href="<?= Url::create(Routes::Homepage)?>">
      <svg width="32" height="24" viewBox="0 0 32 24" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M0.939339 10.9393C0.353552 11.5251 0.353552 12.4749 0.939339 13.0607L10.4853 22.6066C11.0711 23.1924 12.0208 23.1924 12.6066 22.6066C13.1924 22.0208 13.1924 21.0711 12.6066 20.4853L4.12132 12L12.6066 3.51472C13.1924 2.92893 13.1924 1.97918 12.6066 1.3934C12.0208 0.80761 11.0711 0.80761 10.4853 1.3934L0.939339 10.9393ZM32 10.5L2 10.5L2 13.5L32 13.5L32 10.5Z" fill="black"/>
      </svg>
    </a>
    <h1>Vytvořit účet</h1>
  </header>
  <main>
        <?php
            if (isset($this->data['errorMessage'])) {
                echo '<div class="message message--error">';
                switch ($this->data['errorMessage']) {
                    case 'userRegistered':
                        echo 'Registrace se nezdařila - zadaný email je již zaregistrován.';
                        break;
                    case 'password':
                        echo 'Heslo musí obsahovat číslici, velké a malé písmeno a musí mít nejméne 8 znaků.';
                        break;
                    case 'confirmPassword':
                        echo 'Heslo a Heslo znovu se neshodují.';
                        break;
                    default:
                        echo 'Registrace se nepovedla, prosím zkontrolujte vyplněné údaje.';
                }
                echo '</div>';
            }
            ?>
    <form name="register" form action="<?= Url::create(Routes::Register)?>" method="post" class="panel-form" onsubmit="return validateForm('register')" novalidate>
      <label for="email" class="input-label">Email</label>
      <input type="email" name="email" id="email" class="input" value="<?= isset($this->data['formData']) ? $this->data['formData']['email'] : '' ?>" required>
      <label for="password" class="input-label">Heslo</label>
      <input type="password" name="password" id="password" class="input" required>
      <label for="confirm-password" class="input-label">Heslo znovu</label>
      <input type="password" name="confirm-password" id="confirm-password" class="input" data-compare="password" data-message="Heslo a Heslo znovu se neshodují." required>
      <label for="terms" class="checkbox-label">
        <input type="checkbox" name="terms" id="terms" class="checkbox" required>
        <span>Souhlasím s <a href="#" class="link-blue">podmínkami použití</a> aplikace</span>
      </label>
      <input type="submit" value="Vytvořit účet" class="button button--mt">
    </form> 

    <a href="<?= Url::create(Routes::Login)?>" class="panel-link">Přihlášení</a>
  </main>
</div>
<footer>
  <div class="footer-container">
      <div class="sec aboutus">
          <h2>O mně</h2>
          <p>Jsem vyučený kuchař a také mám maturitu v oboru podnikání. Je mi 23 let a na to že jsem docela mladý tak jsem si už vyzkoušel několik zaměstnání. Pracoval jsem jako prodejce v elektru, účetní a poradce životního pojištění. Od 15 let jsem chodil do posilovny do 18 let a poté ze zdravotních důvodů jsem musel přestat.</p>
          <ul class="sci">
              <li><a href="#"><i class="bx bxl-facebook"></i></a></li>
              <li><a href="#"><i class="bx bxl-instagram"></i></a></li>
              <li><a href="#"><i class="bx bxl-twitter"></i></a></li>
              <li><a href="#"><i class="bx bxl-linkedin"></i></a></li>
          </ul>
      </div>
      <div class="sec quicklinks">
          <h2>Rychlé odkazy</h2>
          <ul>
              <li><a href="#">Domů</a></li>
              <li><a href="#">Informace o mně</a></li>
              <li><a href="#">Ochrana osobních údajů</a></li>
              <li><a href="#">Podmínky použití</a></li>
              <li><a href="#">Cookies</a></li>
          </ul>
      </div>
      <div class="sec contactBx">
          <h2>Kontaktní informace</h2>
          <ul class="info">
              <li>
                  <span><i class='bx bxs-map'></i></span>
                  <span>Kpt.Jaroše 2410 <br> Tábor, 39003 <br> CZ</span>
              </li>
              <li>
                  <span><i class='bx bx-envelope' ></i></span>
                  <p><a href="maximtomasek@gmail.com">maximtomasek@gmail.com</a></p>
              </li>
          </ul>
      </div>
  </div>
  <p style="text-align: center">&copy; 2023</p>
</footer>

<?php
include "Components/HtmlFoot.php";