<?php
namespace Addresses\Tests\Service;

use Addresses\Service\AddressService;

/**
 * Created by IntelliJ IDEA.
 * User: davidcontavalli
 * Date: 27/06/16
 * Time: 16:08
 */
class AddressServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var AddressService
     */
    private $addressService;

    public function setUp()
    {
        $this->addressService = new AddressService();
    }

    /**
     * @test
     */
    public function retrievesStoredAddresses()
    {
        $expectedResult = ['test'];

        $result = $this->addressService->getAddresses();
        $this->assertEquals($expectedResult, $result);
    }
}
