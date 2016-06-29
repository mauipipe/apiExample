<?php
namespace Addresses\Tests\Service;

use Addresses\Http\Request;
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
    public function retrievesStoredAddressesList()
    {
        $expectedResult = ['test'];

        $this->addressRepository->expects($this->once())
            ->method('fetchAddresses')
            ->willReturn($expectedResult);

        $result = $this->addressService->getAddresses();
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * @test
     */
    public function retrievesAddressByGivenParams()
    {
        $expectedResult = ['test'];

        $id = 1;
        $request = new Request();
        $request->addParam('id', $id);

        $this->addressRepository->expects($this->once())
            ->method('fetchAddress')
            ->with($id)
            ->willReturn($expectedResult);

        $result = $this->addressService->getAddress($request->getQueryParams());
        $this->assertEquals($expectedResult, $result);
    }
}
