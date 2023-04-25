<!DOCTYPE html>
<html lang="fr-FR">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="<?= $app->desc ?>" />
    <link rel="shortcut icon" href="<?= URL ?>/assets/img/logo_responsive.svg" type="image/x-icon">
    <link rel="stylesheet" href="<?= URL ?>/assets/css/reset.css">
    <link rel="stylesheet" href="<?= URL ?>/assets/css/style.css">
    <script src="<?= URL ?>/assets/js/main.js" type="module" defer></script>
    <style>
        body {
            display: grid;
            justify-content: center;
            align-content: center;
            min-height: calc(100vh - 100px);
        }
    </style>
    <title><?= $app->title ?></title>
</head>

<body>
    <?= $content ?>
</body>


</html>