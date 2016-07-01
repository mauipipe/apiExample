<?php

namespace Addresses\Strategy;

use Addresses\Validator\ValidatorInterface;

/**
 * @author davidcontavalli
 */
trait StrategyInitializableTrait
{
    /**
     * @var string
     */
    protected $strategy;

    /**
     * @param string $strategy
     */
    public function setStrategy($strategy)
    {
        $this->strategy = $strategy;
    }

    /**
     * @param $namespace
     *
     * @return ValidatorInterface
     */
    protected function createStrategy($namespace)
    {
        $strategyClassName = $namespace . '\\' . ucfirst($this->strategy);
        if (null === $this->strategy || !class_exists($strategyClassName)) {
            throw new \RuntimeException(sprintf('No valid strategy set %s', $strategyClassName));
        }

        /** @var ValidatorInterface $strategyClass */
        $strategyClass = new $strategyClassName();
        return $strategyClass;
    }
}