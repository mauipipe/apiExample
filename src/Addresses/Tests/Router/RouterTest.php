<?php
/**
 * Created by IntelliJ IDEA.
 * User: davidcontavalli
 * Date: 27/06/16
 * Time: 16:47
 */

namespace Addresses\Router;


class RouterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Router
     */
    private $router;

    public function setUp()
    {
        $this->router = new Router();
    }

    /**
     * @test
     */
    public function dispatchesAnActionFromControllerBasedOnConsumedUri()
    {
        $result = $this->router->dispatch();
        $this->assertInstanceOf('Addresses\Controller\AddressController', $result);
    }
}
