<?php
/**
 * Created by IntelliJ IDEA.
 * User: davidcontavalli
 * Date: 27/06/16
 * Time: 16:47
 */

namespace Addresses\Router;


use Addresses\Config\Config;
use Addresses\Helper\ResponseHelper;
use Addresses\Http\Request;
use Addresses\Tests\Mock\Factory\MockFactory;

class RouterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Config
     */
    private $config;

    /**
     * @var Router
     */
    private $router;

    public function setUp()
    {
        $this->config = new Config(__DIR__ . '/../Fixtures/route_test.json');
        $this->router = new Router($this->config);
    }

    /**
     * @test
     */
    public function initializesControllerWhenConfigRouteMatchUri()
    {
        $_SERVER['REQUEST_URI'] = '/address';
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $request = new Request();

        $response = $this->router->dispatch($request);

        $expectedResponse = MockFactory::createMockResponse(null);
        $this->assertEquals($expectedResponse, $response);
    }

    /**
     * @test
     */
    public function initializesControllerWithRouteWithParamWhenConfigRouteMatchUri()
    {
        $_SERVER['REQUEST_URI'] = '/address/1';
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $request = new Request();
        $request->addParam('test', 'value');

        $response = $this->router->dispatch($request);

        $expectedResponse = MockFactory::createMockResponse($request->getQueryParams());
        $this->assertEquals($expectedResponse, $response);
    }

    /**
     * @test
     */
    public function throwsAnExceptionWhenNoRouteIsFound()
    {
        $uri = '/wrong';
        $_SERVER['REQUEST_URI'] = '/wrong';
        $_SERVER['REQUEST_METHOD'] = 'GET';

        $request = new Request();
        $result = $this->router->dispatch($request);
        $this->assertEquals(ResponseHelper::getInvalidRouteExceptionResponse($uri), $result);
    }
}
