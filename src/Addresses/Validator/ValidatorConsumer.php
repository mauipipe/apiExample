<?php

namespace Addresses\Validator;

use Addresses\Strategy\StrategyInitializableTrait;

/**
 * @author davidcontavalli
 **/
class ValidatorConsumer implements ValidatorInterface
{
    use StrategyInitializableTrait;

    /**
     * @param array $data
     *
     * @return bool
     */
    public function validate(array $data)
    {
        $strategyClass = $this->createStrategy(__NAMESPACE__.'\\Strategy');

        return $strategyClass->validate($data);
    }
}
