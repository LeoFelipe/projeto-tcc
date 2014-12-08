<?php
// Habilitando erros
ini_set('display_errors', 'on');

// Setando Charset utf-8 para o PHP
header('Content-type: text/html; charset=utf-8');

define('DS', DIRECTORY_SEPARATOR);
define('PS', PATH_SEPARATOR);
define('PATH_ROOT', dirname(htmlspecialchars($_SERVER['SCRIPT_NAME'], ENT_QUOTES, "utf-8")) . DS);

/* Autoload Composer */
require_once('vendor/autoload.php');

// Bootstrap Doctrine 2
require_once('bootstrap.php');

//var_dump($entityManager);

use App\Controllers\FrontController as FrontController;


$url = !empty($_GET['url']) ? filter_input(INPUT_GET, 'url', FILTER_SANITIZE_STRING) : 'index/index';
//die($url);
FrontController::run($url);