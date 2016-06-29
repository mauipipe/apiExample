<?php
/**
 * Created by IntelliJ IDEA.
 * User: davidcontavalli
 * Date: 27/06/16
 * Time: 17:51
 */

namespace Addresses\Tests\Config;


use Addresses\Config\Config;

class ConfigTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Config
     */
    private $config;

    public function setUp()
    {
        $this->config = new Config(__DIR__ . '/../Fixtures/route_test.json');
    }

    /**
     * @test
     */
    public function retrieveConfigAsAnIterator()
    {
        $result = $this->config->getConfig();

        $this->assertInstanceOf('\Iterator', $result);
    }

    /**
     * @test
     *
     * @expectedException \RuntimeException
     */
    public function throwsAnExceptionWhenTheConsumedFilePathIsNotValid()
    {
        $config = new Config('wrong configuration');
    }

}
