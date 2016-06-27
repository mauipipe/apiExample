<?php
/**
 * Created by IntelliJ IDEA.
 * User: davidcontavalli
 * Date: 27/06/16
 * Time: 16:45
 */

namespace Addresses\Router;


use Addresses\Controller\AddressController;
use Addresses\Factory\AddressServiceFactory;

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
        $addressService = AddressServiceFactory::create();
        return new AddressController($addressService);
    }
}