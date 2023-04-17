<?php

require_once '../config/init.php';

$app->xmlRequest($route);

$_SESSION['message'] = "";
