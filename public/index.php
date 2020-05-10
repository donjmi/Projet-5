<?php

use Blog\Router;
use Tracy\Debugger;

require_once '../vendor/autoload.php';
require_once '../src/Controllers/functions.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


$router = new Router();

Debugger::enable();
$router->run();

