<?php

namespace Addresses\Tests\Validator\Types;

use Addresses\Validator\Type\StringValidator;

/**
 * @author davidcontavalli <david.contavalli@lovoo.com>
 */
class StringValidatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     *
     * @dataProvider provider
     *
     * @param mixed $value
     * @param bool  $expectedResult
     */
    public function checksIfConsumedValueIsValidString($value, $expectedResult)
    {
        $result = StringValidator::isValid($value);
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * @return array
     */
    public function provider()
    {
        return [
            ['asdsdsdwd', true],
            [12323, false],
        ];
    }
}
