<?php

use Blog\Router;
use Tracy\Debugger;

require_once ('../vendor/autoload.php');
require_once ('../config/functions.php');

$router = new Router();

Debugger::enable();
$router->run();

