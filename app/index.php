<?php
/**
 * @author davidcontavalli <david.contavalli@lovoo.com>
 */

use Addresses\Router\Router;

$autoLoader = require '../vendor/autoload.php';

$router = new Router();

echo $router->dispatch();

