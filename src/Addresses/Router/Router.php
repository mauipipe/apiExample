<?php
/**
 * Created by IntelliJ IDEA.
 * User: davidcontavalli
 * Date: 27/06/16
 * Time: 16:45
 */

namespace Addresses\Router;

use Addresses\Factory\AddressControllerFactory;

class Router
{

    /**
     * Router constructor.
     */
    public function __construct()
    {
    }

    public function dispatch()
    {
        return AddressControllerFactory::create();
    }
}