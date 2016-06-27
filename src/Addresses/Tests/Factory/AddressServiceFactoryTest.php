<?php
/**
 * Created by IntelliJ IDEA.
 * User: davidcontavalli
 * Date: 27/06/16
 * Time: 16:34
 */

namespace Addresses\Tests\Factory;


use Addresses\Factory\AddressServiceFactory;

class AddressServiceFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function createsAnAddressServiceInstance()
    {
        $addressServiceFactory = new AddressServiceFactory();

        $result = $addressServiceFactory::create();
        $this->assertInstanceOf('Addresses\Service\AddressService', $result);
    }
}
