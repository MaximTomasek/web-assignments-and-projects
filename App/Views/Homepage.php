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
<main class="main-content">
    <header class="home" id="home">
        <div class="home-text container">
            <h1 class="home-title">Blogger</h1>
            <span class="home-subtitle">Vás zdroj skvělého obsahu</span>
        </div>
    </header>
    <section class="about container" id="about">
        <div class="contentBx">
            <h2 class="titleText">Aktuální témata</h2>
            <p class="title-text">
                Aktuální témata, které zde najdete, se budou týkat různých odvětví. Na této webové stránce najdete aktuality z odvětví sportu, gastronomie ale také zajímavé zprávy ohledně nových poznatků.
                <br>Budu velice rád, pokud napíšete pod téma váš pohled na dané téma a také pokud budete mít nápad, jak by se nějaká věc dala udělat jinak.
            </p>
        </div>
        <div class="imgBx">
            <img src="Resources/images/about.png" alt="muž v šatně posilovny" class="fitBg">
        </div>
    </section>

    <div class="post-filter container">
        <span class="filter-item active-filter" data-filter="all">Vše</span>
        <span class="filter-item" data-filter="tech">Tech</span>
        <span class="filter-item" data-filter="food">Gastronomie</span>
        <span class="filter-item" data-filter="news">Zprávy</span>
    </div>
    
    <section class="post container">
        <!-- Post 1 -->
        <div class="post-box tech">
            <img src="Resources/images/pexels-tranmautritam-326503.jpg" alt="monitory kde jsou zobrazeny fotky" class="post-img">
            <h2 class="category">Tech</h2>
            <a href="../../App/html-templates/fig.html" class="post-title">Webová stránka pro design digitálních produktů.</a>
            <span class="post-date">12 únor 2023</span>
            <p class="post-description">Figma je pro lidi, kteří chtějí testovat návrhy pro webové stránky mobilní aplikace a další digitální produkty. Je to oblíbený nástroj pro designery produktové manažery autory a vývojáře a pomáhá komukoli, kdo se podílí na procesu navrhování poskytovat zpětnou vazbu a činit lepší rozhodnutí.</p>
            <div class="profile">
                <img src="Resources/images/about.png" alt="muž v šatně posilovny" class="profile-img">
                <span class="profile-name">MKHB</span>
            </div>
        </div>
        <!-- Post 2 -->
        <div class="post-box food">
            <img src="Resources/images/pexels-tima-miroshnichenko-6694543.jpg" alt="notebook kde je otevřen účetní program" class="post-img">
            <h2 class="category">Tech</h2>
            <a href="../../App/html-templates/money.html" class="post-title">Účetní program Money S3.</a>
            <span class="post-date">13 únor 2023</span>
            <p class="post-description">Money S3 je účetní software pro živnostníky i firmy. Tento program si můžete vyzkoušet zdarma a osobně já mám s tímto programem docela dobré zkušenosti, protože na tomto programu jsem se učil účetnictví na střední škole.</p>
            <div class="profile">
                <img src="Resources/images/about.png" alt="muž v šatně posilovny" class="profile-img">
                <span class="profile-name">MKHB</span>
            </div>
        </div>
        <!-- Post 3 -->
        <div class="post-box food">
            <img src="Resources/images/pexels-yente-van-eynde-2403392.jpg" alt="servírování jídla na talíř" class="post-img">
            <h2 class="category">Gastronomie</h2>
            <a href="../../App/html-templates/candle.html" class="post-title">Jak uvařit klasickou svíčkovou omáčku na smetaně.</a>
            <span class="post-date">14 únor 2023</span>
            <p class="post-description">Suroviny na svíčkovou omáčku na smetaně pro 6 porcí: 1 200 g zadního hovězího, 450 g kořenové zeleniny (mrkev, celer, petržel ve stejném poměru), 1.5 cibule, 75 g plnotučné hořčice, 3 polévkové lžíce cukru,3 polévkové lžíce octa, 150 g oleje, 150 g másla, 150 g uzené slaniny, 1.5 polévkové lžíce mouky (nebo podle potřeby), 375 ml smetany na šlehánní 33%, 5 ks bobkového listu, 8 ks nového koření, 8 količek pepře, citronová šťáva na dochucení, sůl, vývar.</p> 
            <div class="profile">
                <img src="Resources/images/about.png" alt="muž v šatně posilovny" class="profile-img">
                <span class="profile-name">MKHB</span>
            </div>
        </div>
        <!-- Post 4 -->
        <div class="post-box news">
            <img src="Resources/images/pexels-yugantar-sambhangphe-4034204.jpg" alt="tablet kde jsou nakresleny hory" class="post-img">
            <h2 class="category">Tech</h2>
            <a href="../../App/html-templates/afinity.html" class="post-title">Základy programu Affinity Designer</a>
            <span class="post-date">15 únor 2023</span>
            <p class="post-description">Affinity Designer je vektorový grafický editor. Dobrá věc na Affinity Designer programu je to, že oproti Adobe Ilustrator programu Affinity Designer nemá měsíční poplatky.</p>
            <div class="profile">
                <img src="Resources/images/about.png" alt="muž v šatně posilovny" class="profile-img">
                <span class="profile-name">MKHB</span>
            </div>
        </div>
        <!-- Post 5 -->
        <div class="post-box tech">
            <img src="Resources/images/pexels-matheus-bertelli-7172646.jpg" alt="klávesnice a počítačová myš" class="post-img">
            <h2 class="category">Tech</h2>
            <a href="../../App/html-templates/customization.html" class="post-title">Zajímavé počítačové periferie</a>
            <span class="post-date">16 únor 2023</span>
            <p class="post-description">Periferie je hardware, který se připojuje k počítači a rozšiřuje jeho možnosti. Tento hardware slouží k vstupu nebo výstupu dat do počítače nebo z počítače. Periferie jsou k počítači připojeny prostřednictvím různých konektorů např. USB.</p>
            <div class="profile">
                <img src="Resources/images/about.png" alt="muž v šatně posilovny" class="profile-img">
                <span class="profile-name">MKHB</span>
            </div>
        </div>
        <!-- Post 6 -->
        <div class="post-box news">
            <img src="Resources/images/pexels-lee-catherine-collins-2652236.jpg" alt="stojan na jednoruční činky spolu s činkami" class="post-img">
            <h2 class="category">Zprávy</h2>
            <a href="../../App/html-templates/news.html" class="post-title">Novinky ohledně cvičení</a>
            <span class="post-date">17 únor 2023</span>
            <p class="post-description">Já sám vím, že je docela těžké najít odpovědi na otázky ve fitness sféře. Pamatuji si na to, jak jsem začínal se silovým tréninkem a také si pamatuji na tu spoustu chyb, které jsem dělal a vím, že spoustu věcí bych dnes udělal jinak.</p>
            <div class="profile">
                <img src="Resources/images/about.png" alt="muž v šatně posilovny" class="profile-img">
                <span class="profile-name">MKHB</span>
            </div>
        </div>
        <!-- Post 7 -->
        <div class="post-box tech">
            <img src="Resources/images/pexels-danny-meneses-943096.jpg" alt="notebook který má na obrazovce otevřený kód" class="post-img">
            <h2 class="category">Tech</h2>
            <a href="../../App/html-templates/beginnings.html" class="post-title">Základy html</a>
            <span class="post-date">18 únor 2023</span>
            <p class="post-description">HTML je zkratka pro Hypertext Markup Language. HTML je název značkovacího jazyka používaného pro tvorbu webových stránek, které jsou propojeny hypertextovými odkazy. HTML je jedním z hlavních jazyků pro vytváření webových stránek.</p>
            <div class="profile">
                <img src="Resources/images/about.png" alt="muž v šatně posilovny" class="profile-img">
                <span class="profile-name">MKHB</span>
            </div>
        </div>
        <!-- Post 1 -->
        <div class="post-box news">
            <img src="Resources/images/pexels-ella-olsson-1640770.jpg" alt="tři misky s rýží a zeleninou" class="post-img">
            <h2 class="category">Zprávy</h2>
            <a href="../../App/html-templates/diet.html" class="post-title">Nové informace ohledně keto diety</a>
            <span class="post-date">19 únor 2023</span>
            <p class="post-description">Ketogenní dieta obvykle snižuje celkový příjem sacharidů na méně než 50 gramů denně. Pro představu 50 gramů sacharidů je méně než je obsaženo v bagetě. Lidi kteří se řídí podle ketogenní diety jí malé množství sacharidů jako je například 20 gramů sacharidů denně. Obecně platí, že průměrný denní příjem tuků činí 70-80 % z celkového kalorického příjmu, 5-10 % sacharidů a 10-20 % bílkovin.</p>
            <div class="profile">
                <img src="Resources/images/about.png" alt="muž v šatně posilovny" class="profile-img">
                <span class="profile-name">MKHB</span>
            </div>
        </div>
        <!-- Post 9 -->
        <div class="post-box food">
            <img src="Resources/images/pexels-anna-tarazevich-6937447.jpg" alt="házení rýže v pánvi" class="post-img">
            <h2 class="category">Gastronomie</h2>
            <a href="../../App/html-templates/advice.html" class="post-title">Jak se stát kuchařem pokud nemáte pracovní zkušenosti.</a>
            <span class="post-date">20 únor 2023</span>
            <p class="post-description">Pokud jste na tom podobně, jak jsem na tom já a máte výuční list v oboru Kuchař / Číšník, ale bohužel nemáte dostatek pracovních zkušeností na to, aby jste mohli dělat samostatného kuchaře tak pro vás mám radu.</p>
            <div class="profile">
                <img src="Resources/images/about.png" alt="muž v šatně posilovny" class="profile-img">
                <span class="profile-name">MKHB</span>
            </div>
        </div>
    </section>
</main>
<?php
include "Components/Footer.php";
include "Components/HtmlFoot.php";