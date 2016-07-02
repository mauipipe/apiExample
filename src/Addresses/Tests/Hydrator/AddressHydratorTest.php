<?php

namespace Addresses\Tests\Hydrator;

use Addresses\Hydrator\AddressHydrator;

/**
 * @author davidcontavalli
 */
class AddressHydratorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var AddressHydrator
     */
    private $addressHydrator;

    public function setUp()
    {
        $this->addressHydrator = new AddressHydrator();
    }

    /**
     * @test
     */
    public function hydratesAnAddressObjectWithConsumedData()
    {
        $data = [
            'id' => 1,
            'street' => 'test',
            'name' => 'test',
            'phone' => '123213232',
        ];

        $result = $this->addressHydrator->hydrate($data);
        foreach ($data as $key => $value) {
            $accessor = 'get'.ucfirst($key);
            $this->assertEquals($value, $result->$accessor());
        }
    }
}
