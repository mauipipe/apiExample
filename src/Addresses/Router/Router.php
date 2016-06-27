<?php
/**
 * Created by IntelliJ IDEA.
 * User: davidcontavalli
 * Date: 27/06/16
 * Time: 16:45
 */

namespace Addresses\Router;

use Addresses\Config\Config;
use Addresses\Factory\FactoryInterface;

class Router
{
    const ROUTE = 'route';

    /**
     * Router constructor.
     */
    public function __construct()
    {
    }

    public function dispatch()
    {
        $uri = $_SERVER['REQUEST_URI'];
        $config = new Config(__DIR__ . '/../../../config/route.json');

        foreach ($config->getConfig() as $key => $configRow) {
            $pattern = '@^'. $uri . '$@';
            if (preg_match($pattern, $uri)) {
                $controller = $configRow['factory'];
                /** @var FactoryInterface */
                return $controller::create();
            }
        }
        throw new \RuntimeException(sprintf('Invalid route provided %s', $uri));
    }
}