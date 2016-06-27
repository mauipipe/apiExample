<?php
/**
 * Created by IntelliJ IDEA.
 * User: davidcontavalli
 * Date: 27/06/16
 * Time: 17:03
 */

namespace Addresses\Tests\Factory;


use Addresses\Factory\AddressControllerFactory;

class AddressControllerFactoryTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @test
     */
    public function createsAnAddressControllerInstance()
    {
        $addressController = AddressControllerFactory::create();
        $this->assertInstanceOf('Addresses\Controller\AddressController', $addressController);
    }

}
