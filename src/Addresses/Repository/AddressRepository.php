<?php
namespace Addresses\Repository;

use Addresses\Model\Address;
use PDO;

/**
 * Created by IntelliJ IDEA.
 * User: davidcontavalli
 * Date: 27/06/16
 * Time: 16:23
 */
class AddressRepository implements AddressDbInterface
{
    /**
     * @var \PDO
     */
    private $pdo;

    /**
     * AddressRepository constructor.
     * @param \PDO $pdo
     */
    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function fetchAddresses()
    {
        $query = $this->pdo->prepare('SELECT * FROM address');
        $query->execute();

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * @param array $queryParams
     * @return bool
     */
    public function fetchAddressByParams(array $queryParams)
    {
        $whereQueryParts = [];
        foreach ($queryParams as $key => $value) {
            $whereQueryParts[] = sprintf('%s=:%s', $key, $key);
        }
        $whereQuery = implode(' AND ', $whereQueryParts);
        $mappedParams = $this->getMappedParams($queryParams);

        $query = 'SELECT *  FROM address WHERE ' . $whereQuery;
        $result = $this->pdo->prepare($query);
        $result->execute($mappedParams);

        return $result->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * @param Address $address
     */
    public function addAddress(Address $address)
    {
        $addressData = $address->getData();
        $result = $this->pdo->prepare(
            'INSERT INTO address (name, street, phone) VALUES(:name, :street, :phone)'
        );
        $result->execute($addressData);
    }

    /**
     * @param Address $address
     *
     * @return array
     */
    public function updateAddress(Address $address)
    {
        $addressData = $address->getData();
        $setQuery = [];
        foreach ($addressData as $key => $value) {
            $setQuery[] = sprintf('%s = :%s', $key, $key);
        }
        $query = 'UPDATE address SET ' . implode(', ', $setQuery) . ' WHERE id = :id';
        $result = $this->pdo->prepare($query);

        $mappedParams = $this->getMappedParams($addressData);
        $mappedParams[':id'] = $address->getId();

        $result->execute($mappedParams);

        return $addressData;
    }

    /**
     * @param int $id
     */
    public function deleteAddress($id)
    {
        $query = 'DELETE FROM address WHERE id = :id';
        $result = $this->pdo->prepare($query);

        $result->execute([':id' => $id]);
    }

    /**
     * @param $addressData
     * @return array
     */
    protected function getMappedParams($addressData)
    {
        $mappedParams = [];
        foreach (array_keys($addressData) as $key) {
            $mappedParams[':' . $key] = $addressData[$key];
        }
        return $mappedParams;
    }
}