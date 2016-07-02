<?php
/**
 * @author davidcontavalli
 */

namespace Addresses\Tests\Helper;

use Addresses\Helper\QueryHelper;

class QueryHelperTest extends \PHPUnit_Framework_TestCase
{
    private static $params = ['test' => 'test', 'test1' => 'test1'];

    /**
     * @test
     */
    public function getsMappedParamsFromArray()
    {
        $params = ['test' => 'test'];

        $expectedResult = [':test' => 'test'];
        $result = QueryHelper::getMappedParams($params);

        $this->assertEquals($expectedResult, $result);
    }

    /**
     * @test
     */
    public function createWhereQueryFromArray()
    {
        $expectedResult = ' WHERE test=:test AND test1=:test1';
        $result = QueryHelper::createWhereQuery(self::$params);

        $this->assertEquals($expectedResult, $result);
    }

    /**
     * @test
     */
    public function createSetQueryFromArray()
    {
        $params = ['test' => 'test', 'test1' => 'test1'];
        $expectedResult = 'test = :test, test1 = :test1';

        $result = QueryHelper::createSetQuery($params);
        $this->assertEquals($expectedResult, $result);
    }
}
