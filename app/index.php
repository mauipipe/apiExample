<?php
/**
 * @author davidcontavalli
 */

use Addresses\Config\Config;
use Addresses\Http\Request;
use Addresses\Http\ResponseDispatcher;
use Addresses\Router\Router;

$autoLoader = require '../vendor/autoload.php';

$config = new Config(__DIR__ . '/../config/route.json');
$request = new Request();
$router = new Router($config);

$response = $router->dispatch($request);
echo ResponseDispatcher::dispatch($response);

