<?php
/**
 * Created by IntelliJ IDEA.
 * User: davidcontavalli
 * Date: 27/06/16
 * Time: 19:11.
 */

namespace Addresses\Tests\Http;

use Addresses\Http\Request;

class RequestTest extends \PHPUnit_Framework_TestCase
{
    const TEST_METHOD = 'TEST';
    /**
     * @var Request
     */
    private $request;

    private static $mockGET = ['test' => 'test'];

    public function setUp()
    {
        $this->request = new Request();
    }

    /**
     * @test
     */
    public function getQueryParams()
    {
        $_GET = self::$mockGET;
        $result = $this->request->getQueryParams();

        $this->assertEquals(self::$mockGET, $result);
    }

    /**
     * @test
     */
    public function addAndRetrieveOneCustomParam()
    {
        $expectedResult = ['test' => 'test', 'foo' => 'bar'];
        $_GET = self::$mockGET;

        $this->request->addParam('foo', 'bar');
        $result = $this->request->getQueryParams();

        $this->assertEquals($expectedResult, $result);
    }

    /**
     * @test
     */
    public function retrievesTheMethodFromRequest()
    {
        $_SERVER['REQUEST_METHOD'] = self::TEST_METHOD;

        $result = $this->request->getMethod();
        $this->assertEquals(self::TEST_METHOD, $result);
    }

    public function retrievesOneParameterbyKeyFromRequestParams()
    {
        $expectedResult = 'bar';
        $key = 'foo';
        $this->request->addParam($key, $expectedResult);
        $result = $this->request->getParam($key);

        $this->assertEquals($expectedResult, $result);
    }
}
