<?php

namespace Addresses\Service;

use Addresses\Model\Address;
use Addresses\Repository\AddressDbInterface;

/**
 * @author davidcontavalli
 */
class AddressService
{
    /**
     * @var AddressDbInterface
     */
    private $addressesRepo;

    /**
     * AddressService constructor.
     * @param AddressDbInterface $addressesRepo
     */
    public function __construct(AddressDbInterface $addressesRepo)
    {
        $this->addressesRepo = $addressesRepo;
    }

    /**
     * @return array
     */
    public function getAddresses()
    {
        $result = $this->addressesRepo->fetchAddresses();
        $addresses = [];
        foreach ($result as $addressData) {
            $address = $this->createAddress($addressData);
            $addresses[] = $address;
        }
        return $addresses;
    }

    /**
     * @param array $getQueryParams
     * @return array
     */
    public function getAddress(array $getQueryParams)
    {
        $result = $this->addressesRepo->fetchAddressByParams($getQueryParams);
        return $this->createAddress($result);
    }

    /**
     * @param array $getQueryParams
     */
    public function addAddress(array $getQueryParams)
    {
        $address = new Address($getQueryParams);
        $this->addressesRepo->addAddress($address);
    }

    /**
     * @param $id
     * @param array $addressData
     */
    public function updateAddress($id, array $addressData)
    {
        $address = new Address($addressData);
        $address->setId($id);

        $this->addressesRepo->updateAddress($address);
    }

    /**
     * @param $id
     */
    public function deleteAddress($id)
    {
        $this->addressesRepo->deleteAddress($id);
    }
    /**
     * @param $addressData
     * @return Address
     */
    protected function createAddress($addressData)
    {
        $address = new Address($addressData);
        $address->setId($addressData['id']);
        return $address;
    }
}