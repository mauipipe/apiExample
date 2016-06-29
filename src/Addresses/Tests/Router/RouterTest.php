<?php
/**
 * Created by IntelliJ IDEA.
 * User: davidcontavalli
 * Date: 27/06/16
 * Time: 16:47
 */

namespace Addresses\Router;


use Addresses\Config\Config;
use Addresses\Http\Request;

class RouterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Config
     */
    private $config;
    /**
     * @var Request
     */
    private $request;


    /**
     * @var Router
     */
    private $router;

    public function setUp()
    {
        $this->config = new Config(__DIR__ .'/../Fixtures/route_test.json');
        $this->request = new Request();
        $this->router = new Router($this->config,$this->request);
    }

    /**
     * @test
     */
    public function initializesControllerWhenConfigRouteMatchUri()
    {
        $_SERVER['REQUEST_URI'] = '/address';
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $response = $this->router->dispatch();

        $expectedResponse = '[{"name":"test","address":"mercy","nr":23},{"name":"test2","address":"mercy2","nr":45}]';
        $this->assertEquals($expectedResponse, $response);
    }

    /**
     * @test
     */
    public function initializesControllerWithRouteWithParamWhenConfigRouteMatchUri()
    {
        $_SERVER['REQUEST_URI'] = '/address/1';
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $response = $this->router->dispatch();

        $expectedResponse = '[{"name":"test","address":"mercy","nr":23}]';
        $this->assertEquals($expectedResponse, $response);
    }

    /**
     * @test
     *
     * @expectedException \RuntimeException
     */
    public function throwsAnExceptionWhenNoRouteIsFound()
    {
        $_SERVER['REQUEST_URI'] = '/wrong';
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $result = $this->router->dispatch();
        $this->assertInstanceOf('Addresses\Controller\AddressController', $result);
    }
}
