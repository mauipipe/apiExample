<?php

namespace Addresses\Validator;

/**
 * @author davidcontavalli
 */
interface ValidatorInterface
{
    /**
     * @param array $data
     * 
     * @return bool
     */
    public function validate(array $data);
}
