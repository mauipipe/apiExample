<?php

/**
 * @author davidcontavalli
 */

namespace Addresses\Validator;

interface ValidatorTypeInterface
{
    /**
     * @param string $value
     *
     * @return bool
     */
    public static function isValid($value);
}
