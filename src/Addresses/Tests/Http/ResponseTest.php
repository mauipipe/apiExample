<?php
/**david contavalli*/

namespace Addresses\Tests\Http;

use Addresses\Http\Response;

class ResponseTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {

    }

    /**
     * @test
     */
    public function returnsCorrectJsonResponse()
    {
        $responseData = ['test'];
        $statusCode = '200';
        $httpHeader = 'Content-Type: application/json';
        $response = new Response($responseData, $statusCode, 'json');

        $response->setHeader($httpHeader);
        $this->assertEquals($statusCode, $response->getStatusCode());
        $this->assertEquals($httpHeader, $response->getHeader());
    }

}
