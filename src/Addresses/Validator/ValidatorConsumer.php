<?php

namespace Addresses\Validator;

/**
 * @author davidcontavalli
 **/
class ValidatorConsumer implements ValidatorInterface
{
    /**
     * @var string
     */
    private $strategy;
    /**
     * @var string
     */
    private $errorMessage;
    public function __construct()
    {
    }

    /**
     * @param string $strategy
     */
    public function setStrategy($strategy)
    {
        $this->strategy = $strategy;
    }

    public function getErrorMessage()
    {
        
        return 'generic validation error';
    }

    /**
     * @param array $data
     *
     * @return bool
     */
    public function validate(array $data)
    {
        $strategyClassName = __NAMESPACE__ . '\\Strategy\\' . ucfirst($this->strategy);
        if (null === $this->strategy || !class_exists($strategyClassName)) {
            throw new \RuntimeException(sprintf('No valid strategy set %s', $strategyClassName));
        }

        /** @var ValidatorInterface $strategyClass */
        $strategyClass = new $strategyClassName();
        return $strategyClass->validate($data);
    }
}