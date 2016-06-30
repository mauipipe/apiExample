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
use Addresses\Helper\ResponseHelper;
use Addresses\Http\Request;

class Router
{

    const ROUTE = 'route';
    const PLACEHOLDER_SUFFIX = ':';

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

        foreach ($this->config->getConfig() as $configRow) {
            $route = $configRow[self::ROUTE];
            $this->checkMandatoryParams($configRow);
            $placeHolders = $this->processRoute($configRow, $route);

            $pattern = sprintf('@^%s$@', $route);
            $matches = [];
            if (preg_match($pattern, $uri, $matches) && $this->hasValidMethod($configRow, $method)) {
                if (count($placeHolders) > 0) {
                    $request->addPlaceholdersFromRoute($placeHolders, $matches);
                }
                
                return $this->dispatchAction($request, $configRow);
            }
        }

        return ResponseHelper::getInvalidRouteExceptionResponse($uri);
    }

    /**
     * @param $configRow
     * @param $method
     * @return bool
     */
    protected function hasValidMethod($configRow, $method)
    {
        return ($configRow['method'] === $method);
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
                $key = str_replace(self::PLACEHOLDER_SUFFIX, '', $key);
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