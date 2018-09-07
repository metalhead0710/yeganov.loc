<?php



// FRONT CONTROLLER



// помилки

INI_SET('DISPLAY_ERRORS', 0);

error_reporting(0);



session_start();



// підключення файликів програми



define('ROOT', dirname(__FILE__));
define ('DS', DIRECTORY_SEPARATOR);
require_once(ROOT.'/components/Autoload.php');

// стартим Router

$router = new Router();

$router->run();
