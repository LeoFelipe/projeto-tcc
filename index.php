<?php
// Habilitando erros
ini_set('display_errors', 'on');

// Setando Charset utf-8 para o PHP
header('Content-type: text/html; charset=utf-8');

define('DS', DIRECTORY_SEPARATOR);
define('PS', PATH_SEPARATOR);

/* Autoload Composer */
require_once('vendor/autoload.php');

// Bootstrap Doctrine 2
require_once('bootstrap.php');

//var_dump($entityManager);

use App\Controllers\FrontController as FrontController;

$url = !empty($_GET['url']) ? $_GET['url'] : 'index/index';
FrontController::run($url);