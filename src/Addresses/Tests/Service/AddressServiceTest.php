<?php
namespace Addresses\Tests\Service;

use Addresses\Http\Request;
use Addresses\Model\Address;
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
        $queryParams = $request->getQueryParams();

        $this->addressRepository->expects($this->once())
            ->method('fetchAddressByParams')
            ->with($queryParams)
            ->willReturn($expectedResult);

        $result = $this->addressService->getAddress($queryParams);
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * @test
     */
    public function addAnAddress()
    {
        $request = new Request();
        $addressData = [
            'name' => 'test',
            'street' => 'conny street',
            'phone' => '1232132'
        ];
        foreach ($addressData as $key => $value) {
            $request->addParam($key, $value);
        }

        $this->addressRepository->expects($this->once())
            ->method('addAddress')
            ->with(new Address($addressData));

        $this->addressService->addAddress($request->getQueryParams());
    }

    /**
     * @test
     */
    public function updateAnAddress()
    {
        $request = new Request();
        $addressData = [
            'name' => 'test',
            'street' => 'conny street',
            'phone' => '1232132'
        ];
        $id = 1;
        foreach ($addressData as $key => $value) {
            $request->addParam($key, $value);
        }
        $address = new Address($addressData);
        $address->setId($id);

        $this->addressRepository->expects($this->once())
            ->method('updateAddress')
            ->with($address);

        $this->addressService->updateAddress($id,$request->getQueryParams());
    }
}
