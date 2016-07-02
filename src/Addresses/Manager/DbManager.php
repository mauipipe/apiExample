<?php

/**
 * @author davidcontavalli
 */

namespace Addresses\Manager;

use Addresses\Helper\QueryHelper;
use Addresses\Model\Address;
use PDO;

class DbManager implements DbManagerInterface
{
    /**
     * @var \PDO
     */
    private $pdo;

    /**
     * @var \PDOStatement
     */
    private $statement;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * @param string $table
     * @param array  $data
     */
    public function prepareSelect($table, $data = [])
    {
        $whereQuery = QueryHelper::createWhereQuery($data);

        $dbCol = sprintf('%s,%s,%s,%s', Address::ID, Address::NAME, Address::PHONE, Address::STREET);
        $query = 'SELECT '.$dbCol.'  FROM '.$table.$whereQuery;

        $statement = $this->pdo->prepare($query);
        $mappedParams = QueryHelper::getMappedParams($data);

        $statement->execute($mappedParams);
        $this->statement = $statement;
    }

    /**
     * @param string $table
     * @param array  $data
     */
    public function executeInsert($table, $data)
    {
        $dbCols = implode(',', array_keys($data));
        $mappedParams = QueryHelper::getMappedParams($data);
        $mappedKey = implode(',', array_keys($mappedParams));

        $query = 'INSERT INTO '.$table.' ('.$dbCols.') VALUES('.$mappedKey.')';
        $result = $this->pdo->prepare($query);
        $result->execute($mappedParams);
    }

    /**
     * @param string $table
     * @param int    $id
     * @param array  $data
     */
    public function executeUpdate($table, $id, array $data)
    {
        $setQuery = QueryHelper::createSetQuery($data);
        $query = 'UPDATE '.$table.' SET '.$setQuery.' WHERE id = :id';
        $result = $this->pdo->prepare($query);
        $mappedParams = QueryHelper::getMappedParams($data, [':id' => $id]);

        $result->execute($mappedParams);
    }

    /**
     * @param string $table
     * @param int    $id
     */
    public function executeDelete($table, $id)
    {
        $query = 'DELETE FROM '.$table.' WHERE id = :id';
        $result = $this->pdo->prepare($query);

        $result->execute([':id' => $id]);
    }

    /**
     * @return array
     */
    public function fetchAll()
    {
        return $this->statement->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * @return array
     */
    public function fetch()
    {
        return $this->statement->fetch(PDO::FETCH_ASSOC);
    }
}
