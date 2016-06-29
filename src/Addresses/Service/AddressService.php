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
        return $this->addressesRepo->fetchAddresses();
    }

    /**
     * @param array $getQueryParams
     * @return array
     */
    public function getAddress(array $getQueryParams)
    {
        return $this->addressesRepo->fetchAddressByParams($getQueryParams);
    }

    /**
     * @param array $getQueryParams
     */
    public function addAddress(array $getQueryParams)
    {
        $address = new Address($getQueryParams);
        $this->addressesRepo->addAddress($address);
    }
}