<?php

namespace Addresses\Tests\Validator\Type;

use Addresses\Validator\Type\PhoneValidator;

/**
 * @author davidcontavalli
 */
class PhoneValidatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     *
     * @dataProvider provider
     * 
     * @param string $mobileNumber
     * @param bool   $expectedResult
     */
    public function checksWhenMobilePhoneNumberIsValid($mobileNumber, $expectedResult)
    {
        $result = PhoneValidator::isValid($mobileNumber);
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * @return array
     */
    public function provider()
    {
        return [
            ['+91 8087339090', true],
            ['918087339090', false],
            ['91808733909034', false],
            ['+4912322137333434', false],
        ];
    }
}
