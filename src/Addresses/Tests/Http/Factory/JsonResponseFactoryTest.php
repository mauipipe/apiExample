<?php

namespace Addresses\Tests\Http\Factory;

use Addresses\Http\Factory\JsonResponseFactory;
use Addresses\Http\Factory\ResponseFactoryInterface;
use Addresses\Http\ResponseInterface;

/**
 * @author davidcontavalli
 */
class JsonResponseFactoryTest extends \PHPUnit_Framework_TestCase
{
    const TEST_STATUS_CODE = 200;
    /**
     * @var ResponseFactoryInterface
     */
    private $jsonResponseFactory;

    public function setUp()
    {
        $this->jsonResponseFactory = new JsonResponseFactory();
    }

    /**
     * @test
     */
    public function createsResponseObjectPopulatedWithResponseData()
    {
        $expectedBody = ['test'];
        /** @var ResponseInterface $response */
        $response = $this->jsonResponseFactory->create($expectedBody, self::TEST_STATUS_CODE);

        $this->assertEquals(self::TEST_STATUS_CODE, $response->getStatusCode());
        $this->assertEquals(['Content-Type: application/json; charset=UTF-8'], $response->getHeaders());
        $this->assertEquals(json_encode($expectedBody), $response->getBody());
    }
}
