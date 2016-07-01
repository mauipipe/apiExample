<?php
namespace Addresses\Tests\Service;

use Addresses\Http\Request;
use Addresses\Hydrator\AddressHydrator;
use Addresses\Hydrator\HydratorInterface;
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
    const ADDRESSS_ID = 1;
    /**
     * @var AddressService
     */
    private $addressService;
    /**
     * @var HydratorInterface
     */
    private $addressHydrator;

    /**
     * @var AddressDbInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $addressRepository;

    public function setUp()
    {
        $this->addressRepository = $this->getMockBuilder('Addresses\Repository\AddressDbInterface')
            ->disableOriginalConstructor()
            ->getMock();
        $this->addressHydrator = new AddressHydrator();

        $this->addressService = new AddressService($this->addressRepository,$this->addressHydrator);
    }

    /**
     * @test
     */
    public function retrievesStoredAddressesList()
    {
        $queryResult = [['id' => self::ADDRESSS_ID, 'street' => 'test', 'name' => 'test', 'phone' => '123213232']];

        $this->addressRepository->expects($this->once())
            ->method('fetchAddresses')
            ->willReturn($queryResult);
        $address = new Address($queryResult[0]);
        $address->setId(self::ADDRESSS_ID);
        $result = $this->addressService->getAddresses();

        $expectedResult = [$this->createAddress($queryResult[0])];
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * @test
     */
    public function retrievesAddressByGivenParams()
    {
        $queryResult = ['id' => self::ADDRESSS_ID, 'street' => 'test', 'name' => 'test', 'phone' => '123213232'];
        $request = new Request();
        $request->addParam('id', self::ADDRESSS_ID);
        $queryParams = $request->getQueryParams();

        $this->addressRepository->expects($this->once())
            ->method('fetchAddressByParams')
            ->with($queryParams)
            ->willReturn($queryResult);

        $address = $this->createAddress($queryResult);
        $result = $this->addressService->getAddress($queryParams);

        $this->assertEquals($address, $result);
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
        $id = self::ADDRESSS_ID;
        foreach ($addressData as $key => $value) {
            $request->addParam($key, $value);
        }
        $address = new Address($addressData);
        $address->setId($id);

        $this->addressRepository->expects($this->once())
            ->method('updateAddress')
            ->with($address);

        $this->addressService->updateAddress($id, $request->getQueryParams());
    }

    /**
     * @test
     */
    public function deleteAnAddress()
    {
        $id = self::ADDRESSS_ID;

        $this->addressRepository->expects($this->once())
            ->method('deleteAddress')
            ->with($id);

        $this->addressService->deleteAddress($id);
    }

    /**
     * @param $queryResult
     * @return Address
     */
    protected function createAddress($queryResult)
    {
        $address = new Address($queryResult);
        $address->setId(self::ADDRESSS_ID);
        return $address;
    }
}
