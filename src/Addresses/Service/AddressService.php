<?php

namespace Addresses\Service;

use Addresses\Hydrator\HydratorInterface;
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
     * @var HydratorInterface
     */
    private $addressHydrator;

    /**
     * @param AddressDbInterface $addressesRepo
     * @param HydratorInterface  $addressHydrator
     */
    public function __construct(AddressDbInterface $addressesRepo, HydratorInterface $addressHydrator)
    {
        $this->addressesRepo = $addressesRepo;
        $this->addressHydrator = $addressHydrator;
    }

    /**
     * @return array
     */
    public function getAddresses()
    {
        $result = $this->addressesRepo->fetchAddresses();
        $addresses = [];
        foreach ($result as $addressData) {
            $address = $this->addressHydrator->hydrate($addressData);
            $addresses[] = $address;
        }

        return $addresses;
    }

    /**
     * @param array $params
     *
     * @return array
     */
    public function getAddress(array $params)
    {
        $result = $this->addressesRepo->fetchAddressByParams($params);

        return $this->addressHydrator->hydrate($result);
    }

    /**
     * @param array $params
     */
    public function addAddress(array $params)
    {
        $address = $this->addressHydrator->hydrate($params);
        $this->addressesRepo->addAddress($address);
    }

    /**
     * @param int   $id
     * @param array $addressData
     *
     * @return Address
     */
    public function updateAddress($id, array $addressData)
    {
        $addressData[Address::ID] = $id;
        $address = $this->addressHydrator->hydrate($addressData);

        $this->addressesRepo->updateAddress($address);

        return $address;
    }

    /**
     * @param $id
     */
    public function deleteAddress($id)
    {
        $this->addressesRepo->deleteAddress($id);
    }
}
