<?php

namespace Addresses\Repository;

use Addresses\Manager\DbManagerInterface;
use Addresses\Model\Address;

/**
 * Created by IntelliJ IDEA.
 * User: davidcontavalli
 * Date: 27/06/16
 * Time: 16:23.
 */
class AddressRepository implements AddressDbInterface
{
    const TABLE_NAME = 'address';
    /**
     * @var DbManagerInterface
     */
    private $dbManager;

    /**
     * AddressRepository constructor.
     *
     * @param DbManagerInterface $dbManager
     */
    public function __construct(DbManagerInterface $dbManager)
    {
        $this->dbManager = $dbManager;
    }

    public function fetchAddresses()
    {
        $this->dbManager->prepareSelect(self::TABLE_NAME);

        return $this->dbManager->fetchAll();
    }

    /**
     * @param array $queryParams
     *
     * @return bool
     */
    public function fetchAddressByParams(array $queryParams)
    {
        $this->dbManager->prepareSelect(self::TABLE_NAME, $queryParams);

        return $this->dbManager->fetch();
    }

    /**
     * @param Address $address
     */
    public function addAddress(Address $address)
    {
        $addressData = $address->getData();
        $this->dbManager->executeInsert(self::TABLE_NAME, $addressData);
    }

    /**
     * @param Address $address
     *
     * @return array
     */
    public function updateAddress(Address $address)
    {
        $addressData = $address->getData();
        $this->dbManager->executeUpdate(self::TABLE_NAME, $address->getId(), $addressData);

        return $addressData;
    }

    /**
     * @param int $id
     */
    public function deleteAddress($id)
    {
        $this->dbManager->executeDelete(self::TABLE_NAME, $id);
    }

    /**
     * @param $addressData
     *
     * @return array
     */
    protected function getMappedParams($addressData)
    {
        $mappedParams = [];
        foreach (array_keys($addressData) as $key) {
            $mappedParams[':'.$key] = $addressData[$key];
        }

        return $mappedParams;
    }
}
