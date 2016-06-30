<?php

/**
 * @author davidcontavalli
 */

namespace Addresses\Model;


use Addresses\Serializer\SerializeInterface;

class Address implements SerializeInterface
{
    const NAME = 'name';
    const PHONE = 'phone';
    const STREET = 'street';
    const ID = 'id';

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
     * @var
     */
    private $id = null;

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

    /**
     * @return array
     */
    public function getData()
    {
        $addressData = [
            self::NAME => $this->name,
            self::PHONE => $this->phone,
            self::STREET => $this->street,
        ];

        return $addressData;
    }

    /**
     * @param $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return null
     */
    public function getId()
    {
        return $this->id;
    }
}