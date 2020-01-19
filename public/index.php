<?php

use Blog\Router;

require_once(dirname(__DIR__).'./vendor/autoload.php');
require_once(dirname(__DIR__).'/config/functions.php');


/**
 * @var \Blog\Router $router
 */
$router = new Router();
/**
 * @return void
 */
$router->run();
