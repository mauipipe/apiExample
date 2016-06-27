<?php

namespace Addresses\Controller;

use Addresses\Repository\AddressRepository;
use Addresses\Service\AddressService;

/**
 * @author davidcontavalli <david.contavalli@lovoo.com>
 **/
class AddressController
{
    public function get()
    {
        $addressRepository = new AddressRepository();
        $addressService = new AddressService($addressRepository);

        return json_encode($addressService->getAddresses());
    }

}