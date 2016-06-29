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
     * @var Config
     */
    private $config;
    /**
     * @var Request
     */
    private $request;

    private static $mandatoryParams = [Config::FACTORY, Config::ACTION];

    /**
     * Router constructor.
     * @param Config $config
     * @param Request $request
     */
    public function __construct(Config $config, Request $request)
    {
        $this->config = $config;
        $this->request = $request;
    }

    public function dispatch()
    {
        $uri = $_SERVER['REQUEST_URI'];
        $method = $this->request->getMethod();

        foreach ($this->config->getConfig() as $route => $configRow) {
            $this->checkMandatoryParams($configRow);
            $this->checkMethod($configRow, $method, $route);
            $placeHolders = $this->processRoute($configRow, $route);

            $pattern = '@^' . $route . '$@';
            $matches = [];
            if (preg_match($pattern, $uri, $matches)) {
                $this->addPlaceHolderToRequest($placeHolders, $matches);

                return $this->dispatchAction($configRow);
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

    /**
     * @param $configRow
     * @return mixed
     */
    protected function checkMandatoryParams($configRow)
    {
        var_dump($configRow);
        foreach (self::$mandatoryParams as $mandatoryParam) {
            if (!isset($configRow[$mandatoryParam]) ) {
                throw new \RuntimeException(sprintf('no %s set on route',$mandatoryParam));
            }
        }
    }

    /**
     * @param string $configRow
     * @param string $route
     * @return array
     */
    protected function processRoute($configRow, &$route)
    {
        $placeHolders = [];
        if (isset($configRow[Config::PARAMS])
            && is_array($configRow[Config::PARAMS])
        ) {
            foreach ($configRow[Config::PARAMS] as $key => $value) {
                $route = str_replace($key, $value, $route);
                $placeHolders[] = $key;
            }
        }
        return $placeHolders;
    }

    /**
     * @param $placeHolders
     * @param $matches
     */
    protected function addPlaceHolderToRequest(&$placeHolders, $matches)
    {
        if (count($placeHolders) > 0) {
            foreach ($placeHolders as $key => $placeHolder) {
                $this->request->addParam($placeHolder, $matches[0 + $key]);
            }
        }
    }

    /**
     * @param $configRow
     * @return mixed
     */
    protected function dispatchAction($configRow)
    {
        if(isset($configRow[Config::FACTORY]) && class_exists($configRow[Config::FACTORY])){
            $controllerName = $configRow[Config::FACTORY];
            /** @var FactoryInterface */
            $controller = $controllerName::create();
        }else{
            $controllerName = $configRow[Config::CONTROLLER];
            $controller = new $controllerName();
        }
        
        return call_user_func_array([$controller, $configRow[Config::ACTION]], [$this->request]);
    }
}