<?php

namespace Addresses\Hydrator;

use Addresses\Model\Address;

/**
 * @author davidcontavalli
 */
class AddressHydrator implements HydratorInterface
{
    /**
     * @param array $data
     * 
     * @return Address
     */
    public function hydrate(array $data)
    {
        $address = new Address($data);
        if (isset($data[Address::ID])) {
            $address->setId($data[Address::ID]);
        }

        return $address;
    }
}
