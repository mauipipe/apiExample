<?php

namespace Addresses\Tests\Validator;

use Addresses\Validator\ValidatorConsumer;

/**
 * @author davidcontavalli <david.contavalli@lovoo.com>
 */
class ValidatorConsumerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ValidatorConsumer
     */
    private $validatorConsumer;

    public function setUp()
    {
        $this->validatorConsumer = new ValidatorConsumer();
    }

    /**
     * @test
     */
    public function validatesDataLoadingValidationStrategy()
    {
        $data = ['name' => 'test', 'phone' => '+91 8087339090', 'street' => 'test'];

        $validatorStrategy = 'addressValidator';
        $this->validatorConsumer->setStrategy($validatorStrategy);
        $this->assertTrue($this->validatorConsumer->validate($data));
    }

    /**
     * @test
     * @dataProvider provider
     * @expectedException \RuntimeException
     *
     * @param string|null $validatorStrategy
     */
    public function throwsExceptionWhenStrategyIsNotSetOrClassNotFound($validatorStrategy)
    {
        $this->validatorConsumer->setStrategy($validatorStrategy);
        $this->validatorConsumer->validate([]);
    }

    /**
     * @return array
     */
    public function provider()
    {
        return [
            [null],
            ['invalidStrategy']
        ];
    }

}
