<?php

namespace Addresses\Validator\Strategy;

use Addresses\Enum\ValidationTypes;
use Addresses\Exception\ValidationException;
use Addresses\Model\Address;
use Addresses\Validator\ValidatorInterface;
use Addresses\Validator\ValidatorTypeInterface;

/**
 * @author davidcontavalli
 */
class AddressValidator implements ValidatorInterface
{
    private static $mapper = [
        Address::NAME => ValidationTypes::STRING,
        Address::PHONE => ValidationTypes::PHONE_NUMBER,
        Address::STREET => ValidationTypes::STRING,
    ];

    /**
     * @param array $data
     *
     * @return bool
     *
     * @throws ValidationException
     * @throws \Exception
     * @throws \HttpInvalidParamException
     */
    public function validate(array $data)
    {
        foreach (self::$mapper as $key => $validatorType) {
            $data = $this->checkMandatoryParams($data, $key);

            /** @var ValidatorTypeInterface $validatorTypeClass */
            $validatorTypeClass = $this->getValidator($validatorType);

            if (false === $validatorTypeClass::isValid($data[$key])) {
                throw new ValidationException(sprintf($validatorTypeClass::$message, $data[$key]));
            };
        }

        return true;
    }

    /**
     * @param $validatorType
     *
     * @return string
     *
     * @throws \Exception
     */
    protected function getValidator($validatorType)
    {
        $validatorTypeClass = 'Addresses\\Validator\\Type\\'.ucfirst($validatorType).'Validator';
        if (!class_exists($validatorTypeClass)) {
            throw new \Exception(sprintf('invalid validator type %s', $validatorTypeClass));
        }

        return $validatorTypeClass;
    }

    /**
     * @param array $data
     * @param $key
     *
     * @return array
     *
     * @throws \HttpInvalidParamException
     */
    protected function checkMandatoryParams(array $data, $key)
    {
        if (!isset($data[$key])) {
            throw new \HttpInvalidParamException(sprintf('param %s not allowed', $key));
        }

        return $data;
    }
}
