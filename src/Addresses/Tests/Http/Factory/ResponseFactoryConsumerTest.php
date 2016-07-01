<?php

namespace Addresses\Tests\Http\Factory;

use Addresses\Enum\ResponseTypes;
use Addresses\Http\Factory\ResponseFactoryConsumer;

/**
 * @author davidcontavalli
 */
class ResponseFactoryConsumerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ResponseFactoryConsumer
     */
    private $responseFactoryConsumer;

    public function setUp()
    {
        $this->responseFactoryConsumer = new ResponseFactoryConsumer();
    }

    /**
     * @test
     */
    public function createsResponseBasedOnStrategy()
    {
        $response = $this->responseFactoryConsumer->create(ResponseTypes::JSON, [], 200);

        $this->assertInstanceOf('Addresses\Http\ResponseInterface', $response);
    }
}
