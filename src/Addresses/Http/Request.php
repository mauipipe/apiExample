<?php
/**
 * Created by IntelliJ IDEA.
 * User: davidcontavalli
 * Date: 27/06/16
 * Time: 19:09
 */

namespace Addresses\Http;


class Request
{

    /**
     * @var array
     */
    private $queryParams;

    public function __construct()
    {
        $this->queryParams = [];
    }

    /**
     * @return array
     */
    public function getQueryParams()
    {
        $queryParams = array_merge($_GET, $this->queryParams);
        return $queryParams;
    }

    /**
     * @param string $key
     * @param mixed $value
     */
    public function addParam($key, $value)
    {
        $this->queryParams[$key] = $value;
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    /**
     * @param array $placeHolders
     * @param $routeMatches
     */
    public function addPlaceholdersFromRoute(array $placeHolders, $routeMatches)
    {
        foreach ($placeHolders as $key => $placeHolder) {
            $this->addParam($placeHolder, $routeMatches[++$key]);
        }
    }

}