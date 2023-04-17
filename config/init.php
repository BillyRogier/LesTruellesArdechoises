<?php

define('ROOT', dirname(__DIR__));
require ROOT . '/app/App.php';
App::load();
$app = App::getInstance();
$route = $app->getRoutes();
