<!DOCTYPE html>
<html lang="fr-FR">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Description" />
    <link rel="shortcut icon" href="<?= URL ?>/assets/img/logo_responsive.svg" type="image/x-icon">
    <link rel="stylesheet" href="<?= URL ?>/assets/css/reset.css">
    <link rel="stylesheet" href="<?= URL ?>/assets/css/admin.css">
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
            <a href="<?= URL ?>/admin/logout" class="icon"><img src="<?= URL ?>/assets/icon/logout.svg" alt="logout"></a>
        </nav>
        <div class="menu grid">
            <ul class="nav_links grid">
                <li><a href="<?= URL ?>/admin/home" class="link">Accueil</a></li>
                <li><a href="<?= URL ?>/admin/about" class="link">À propos</a></li>
                <li><a href="<?= URL ?>/admin/projects-categorie" class="link">Projets</a></li>
                <li><a href="<?= URL ?>/admin/info" class="link">Info</a></li>
                <li><a href="<?= URL ?>/admin/register" class="link">Créer un compte</a></li>
            </ul>
        </div>
    </header>
    <?= $content ?>
</body>


</html>