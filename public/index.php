<?php

use Blog\Router;
use Tracy\Debugger;

require_once ('../vendor/autoload.php');
require_once ('../src/Controllers/functions.php');

$router = new Router();

Debugger::enable();
$router->run();

