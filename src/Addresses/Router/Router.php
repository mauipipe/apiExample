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
     * Router constructor.
     * @param Config $config
     */
    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    public function dispatch(Request $request)
    {
        $uri = $_SERVER['REQUEST_URI'];
        $method = $request->getMethod();

        foreach ($this->config->getConfig() as $route => $configRow) {
            $this->checkMandatoryParams($configRow);
            $this->checkMethod($configRow, $method, $route);
            $placeHolders = $this->processRoute($configRow, $route);

            $pattern = sprintf('@^%s$@', $route);
            $matches = [];
            if (preg_match($pattern, $uri, $matches)) {
                if (count($placeHolders) > 0) {
                    $request->addPlaceholdersFromRoute($placeHolders, $matches);
                }

                return $this->dispatchAction($request, $configRow);
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
        if (!(isset($configRow[Config::CONTROLLER]) || isset($configRow[Config::FACTORY]))) {
            throw new \RuntimeException('missing param controller or factory on config');
        }

        if (!isset($configRow[Config::ACTION])) {
            throw new \RuntimeException('missing param action on config');
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
     * @param Request $request
     * @param array $configRow
     * @return mixed
     */
    protected function dispatchAction(Request $request, $configRow)
    {
        if (isset($configRow[Config::FACTORY]) && class_exists($configRow[Config::FACTORY])) {
            $controllerName = $configRow[Config::FACTORY];
            /** @var FactoryInterface */
            $controller = $controllerName::create();
        } else {
            $controllerName = $configRow[Config::CONTROLLER];
            $controller = new $controllerName();
        }

        return call_user_func_array([$controller, $configRow[Config::ACTION]], [$request]);
    }
}