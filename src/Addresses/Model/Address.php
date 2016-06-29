<?php

/**
 * @author davidcontavalli 
 */

namespace Addresses\Model;


class Address
{
    const NAME = 'name';
    const PHONE = 'phone';
    const STREET = 'street';
    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $street;
    /**
     * @var string
     */
    private $phone;

    /**
     * @param array $addressData
     */
    public function __construct(array $addressData)
    {
        $this->name = $addressData[self::NAME];
        $this->street = $addressData[self::STREET];
        $this->phone = $addressData[self::PHONE];
    }

    /**
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * @param string $street
     */
    public function setStreet($street)
    {
        $this->street = $street;
    }

    public function getData()
    {
        return [
            self::NAME => $this->name,
            self::PHONE => $this->phone,
            self::STREET => $this->street,
        ];
    }
}