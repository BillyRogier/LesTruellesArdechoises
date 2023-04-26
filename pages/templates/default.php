<?php

use App\Table\Info;

$infoTable = new Info();
$info = $infoTable->findOne();

?>
<!DOCTYPE html>
<html lang="fr-FR">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="<?= URL ?>/assets/img/logo_responsive.svg" type="image/x-icon">
    <link rel="stylesheet" href="<?= URL ?>/assets/css/reset.css">
    <meta name="description" content="<?= $app->desc ?>" />
    <link rel="stylesheet" href="<?= URL ?>/assets/css/style.css">
    <script src="<?= URL ?>/assets/js/script.js" defer></script>
    <script src="<?= URL ?>/assets/js/carousel.js" type="module" defer></script>
    <script src="<?= URL ?>/assets/js/main.js" type="module" defer></script>
    <title><?= $app->title ?></title>
</head>

<body>
    <header>
        <nav>
            <div class="grid menu-burger">
                <div class="bar"></div>
                <div class="bar"></div>
                <div class="bar"></div>
            </div>
            <a href="<?= URL ?>" class="logo responsive"><img src="<?= URL ?>/assets/img/logo_responsive.svg" alt="logo"></a>
            <a href="<?= URL ?>" class="logo"><img src="<?= URL ?>/assets/img/logo.svg" alt="logo"></a>
            <a href="<?= URL ?>/contact" class="btn contact">Contact</a>
            <a href="<?= URL ?>/contact" class="icon"> <img src="<?= URL ?>/assets/icon/contact_icon.svg" alt=""> </a>
        </nav>
        <div class="menu grid">
            <ul class="nav_links grid">
                <li><a href="<?= URL ?>/about" class="link about_link">À propos</a></li>
                <li><a href="<?= URL ?>/project" class="link projects_link">Nos projets</a></li>
                <?php if (isset($reviews) && !empty($reviews)) : ?>
                    <li><a href="<?= URL ?>#review" class="link">Nos Avis</a></li>
                <?php endif ?>
            </ul>
            <div class="menu-foot grid">
                <div class="line"></div>
                <div class="mini-foot grid">
                    <a href="<?= $info->getInstagram() ?>" target="_blank"><img src="<?= URL ?>/assets/icon/instagram_icon.svg" class="icon" alt=""></a>
                    <a href="<?= $info->getFacebook() ?>" target="_blank"><img src="<?= URL ?>/assets/icon/facebook_icon.svg" class="icon" alt=""></a>
                </div>
            </div>
        </div>
    </header>
    <?= $content ?>
    <footer class="grid">

        <div class="footer-container info grid">
            <p>Social media</p>
            <div class="social_media-icons grid">
                <a href="<?= $info->getInstagram() ?>" target="_blank"><img src="<?= URL ?>/assets/icon/instagram_icon.svg" class="icon" alt=""></a>
                <a href="<?= $info->getFacebook() ?>" target="_blank"><img src="<?= URL ?>/assets/icon/facebook_icon.svg" class="icon" alt=""></a>
            </div>
        </div>
        <div class="line"></div>
        <div class="contact grid">
            <img src="<?= URL ?>/assets/icon/location.svg" alt="" class="icon">
            <p><?= $info->getLocation() ?></p>
        </div>
        <div class="line"></div>
        <div class="footer-container grid">
            <img src="<?= URL ?>/assets/img/logo2.svg" alt="" class="logo">
        </div>
        <div class="line"></div>
        <div class="footer-container info grid">
            <p><?= $info->getEmail() ?></p>
            <p>
                <?php
                $y = 0;
                $string = (string)$info->getNum();
                for ($i = 0; $i < strlen($string); $i++) {
                    $y += 1;
                    if ($y % 2 != 0) {
                        echo $string[$i];
                    } else {
                        echo $string[$i] . '&nbsp';
                    }
                } ?>
            </p>
        </div>
        <div class="line"></div>
        <div class="links grid">
            <a href="<?= URL ?>/contact" class="link">Contact</a>
            <div class="line"></div>
            <a href="<?= URL ?>/mentions-legales" class="link">Mentions légales</a>
        </div>
    </footer>
</body>



</html>