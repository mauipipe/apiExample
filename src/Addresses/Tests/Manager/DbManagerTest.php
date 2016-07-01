<?php
/**
 * @author davidcontavalli
 */

namespace Addresses\Tests\Manager;

use Addresses\Helper\QueryHelper;
use Addresses\Manager\DbManager;
use Addresses\Tests\Mock\PdoMock;
use Addresses\Tests\Mock\PdoStatementMock;

class DbManagerTest extends \PHPUnit_Framework_TestCase
{
    const TEST_TABLE = 'test_table';
    /**
     * @var PdoMock|\PHPUnit_Framework_MockObject_MockObject
     */
    private $pdo;
    /**
     * @var PdoStatementMock|\PHPUnit_Framework_MockObject_MockObject
     */
    private $pdoStatement;
    /**
     * @var DbManager
     */
    private $dbManager;

    public function setUp()
    {
        $this->pdo = $this->getMock('Addresses\Tests\Mock\PdoMock', ['prepare']);
        $this->pdoStatement = $this->getMock('Addresses\Tests\Mock\PdoStatementMock', ['execute', 'fetchAll', 'fetch']);

        $this->dbManager = new DbManager($this->pdo);
    }

    /**
     * @test
     */
    public function preparesSelectStatementWithoutParams()
    {
        $this->pdo->expects($this->once())
            ->method('prepare')
            ->with('SELECT id,name,phone,street  FROM test_table')
            ->willReturn($this->pdoStatement);

        $this->pdoStatement->expects($this->once())
            ->method('execute')
            ->with([]);

        $this->dbManager->prepareSelect(self::TEST_TABLE);
    }

    /**
     * @test
     */
    public function preparesSelectStatementWithParams()
    {
        $queryParams = ['name' => 'test', 'address' => 'lane street'];

        $this->pdo->expects($this->once())
            ->method('prepare')
            ->with('SELECT id,name,phone,street  FROM test_table WHERE name=:name AND address=:address')
            ->willReturn($this->pdoStatement);

        $this->pdoStatement->expects($this->once())
            ->method('execute')
            ->with(QueryHelper::getMappedParams($queryParams));

        $this->dbManager->prepareSelect(self::TEST_TABLE, $queryParams);
    }

    /**
     * @test
     */
    public function executesInsertStatement()
    {
        $queryParams = ['name' => 'test', 'address' => 'lane street'];

        $this->pdo->expects($this->once())
            ->method('prepare')
            ->with('INSERT INTO test_table (name,address) VALUES(:name,:address)')
            ->willReturn($this->pdoStatement);

        $this->pdoStatement->expects($this->once())
            ->method('execute')
            ->with(QueryHelper::getMappedParams($queryParams));

        $this->dbManager->executeInsert(self::TEST_TABLE, $queryParams);
    }

    /**
     * @test
     */
    public function executesUpdateStatement()
    {
        $id = 1;
        $queryParams = ['name' => 'test', 'address' => 'lane street'];

        $this->pdo->expects($this->once())
            ->method('prepare')
            ->with('UPDATE test_table SET name = :name, address = :address WHERE id = :id')
            ->willReturn($this->pdoStatement);

        $mappedParams = QueryHelper::getMappedParams($queryParams, [':id' => $id]);
        $this->pdoStatement->expects($this->once())
            ->method('execute')
            ->with($mappedParams);

        $this->dbManager->executeUpdate(self::TEST_TABLE, $id, $queryParams);
    }

    /**
     * @test
     */
    public function executesDeletes()
    {
        $id = 1;

        $this->pdo->expects($this->once())
            ->method('prepare')
            ->with('DELETE FROM test_table WHERE id = :id')
            ->willReturn($this->pdoStatement);

        $mappedParams = [':id' => $id];
        $this->pdoStatement->expects($this->once())
            ->method('execute')
            ->with($mappedParams);

        $this->dbManager->executeDelete(self::TEST_TABLE, $id);
    }

}
