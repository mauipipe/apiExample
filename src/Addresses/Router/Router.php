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
use Addresses\Http\Request;

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
        $request = new Request();
        $method = $request->getMethod();

        foreach ($config->getConfig() as $route => $configRow) {
            if(!isset($configRow['action'])){
                throw new \RuntimeException('no action set on route');
            }
            $this->checkMethod($configRow, $method, $route);
            
            $placeHolders = [];
            if (isset($configRow[Config::PARAMS])
                && is_array($configRow[Config::PARAMS])
            ) {

                foreach ($configRow[Config::PARAMS] as $key => $value) {
                    $route = str_replace($key, $value, $route);
                    $placeHolders[] = $key;
                }

            }
            $pattern = '@^' . $route . '$@';

            $matches = [];
            if (preg_match($pattern, $uri, $matches)) {
                if (count($placeHolders) > 0) {
                    foreach ($placeHolders as $key => $placeHolder) {
                        $request->addParam($placeHolder, $matches[0 + $key]);
                    }
                }

                $controllerName = $configRow['factory'];
                /** @var FactoryInterface */
                $controller = $controllerName::create();
                return call_user_func_array([$controller,$configRow['action']],[$request]);
            }
        }
        throw new \RuntimeException(sprintf('Invalid route provided %s', $uri));
    }

    /**
     * @param $configRow
     * @param $method
     * @param $uri
     * @throws \HttpRequestException
     */
    private function checkMethod($configRow, $method, $uri)
    {
        if ($configRow['method'] !== $method) {
            throw new \HttpRequestException('wrong method %s provided for this route %s', $method, $uri);;
        }
    }
}