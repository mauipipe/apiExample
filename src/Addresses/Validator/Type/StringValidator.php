<?php

namespace Addresses\Validator\Type;

use Addresses\Validator\ValidatorTypeInterface;

/**
 * @author davidcontavalli
 */
class StringValidator implements ValidatorTypeInterface
{
    public static $message = 'invalid string %s';

    /**
     * @param string $value
     * @return bool
     */
    public static function isValid($value)
    {
        return is_string($value);
    }
}