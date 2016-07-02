<?php

namespace Addresses\Tests\Validator;

use Addresses\Validator\Strategy\AddressValidator;
use Addresses\Validator\ValidatorInterface;

/**
 * @author davidcontavalli
 */
class AddressValidatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ValidatorInterface
     */
    private $addressValidator;

    public function setUp()
    {
        $this->addressValidator = new AddressValidator();
    }

    /**
     * @test
     */
    public function validatesAddress()
    {
        $requestData = ['name' => 'test', 'phone' => '+91 8087339090', 'street' => 'test'];

        $this->assertTrue($this->addressValidator->validate($requestData));
    }
}
