<?php

namespace Addresses\Validator\Type;

use Addresses\Validator\ValidatorTypeInterface;

/**
 * @author davidcontavalli
 */
class PhoneValidator implements ValidatorTypeInterface
{
    public static $message = 'invalid phone number %s';

    /**
     * @param string $value
     * @return bool
     */
    public static function isValid($value)
    {
        $pattern = '/^(\+\d{1,3}[- ]?)?\d{10}$/';
        return (bool)preg_match($pattern, $value);
    }
}