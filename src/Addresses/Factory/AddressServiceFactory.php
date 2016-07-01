<?php

namespace Addresses\Factory;

use Addresses\Hydrator\AddressHydrator;
use Addresses\Service\AddressService;

/**
 * Created by IntelliJ IDEA.
 * User: davidcontavalli
 * Date: 27/06/16
 * Time: 16:32.
 */
class AddressServiceFactory implements FactoryInterface
{
    public static function create()
    {
        $addressRepository = AddressRepositoryFactory::create();

        return new AddressService($addressRepository, new AddressHydrator());
    }
}
