<?php
namespace Addresses\Tests\Service;

use Addresses\Repository\AddressDbInterface;
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
    /**
     * @var AddressDbInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $addressRepository;

    public function setUp()
    {
        $this->addressRepository = $this->getMockBuilder('Addresses\Repository\AddressDbInterface')
            ->disableOriginalConstructor()
            ->getMock();

        $this->addressService = new AddressService($this->addressRepository);
    }

    /**
     * @test
     */
    public function retrievesStoredAddresses()
    {
        $expectedResult = ['test'];

        $this->addressRepository->expects($this->once())
            ->method('fetchAddresses')
            ->willReturn($expectedResult);

        $result = $this->addressService->getAddresses();
        $this->assertEquals($expectedResult, $result);
    }
}