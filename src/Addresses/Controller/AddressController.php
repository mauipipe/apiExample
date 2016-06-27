<?php

namespace Addresses\Controller;

use Addresses\Service\AddressService;

/**
 * @author davidcontavalli <david.contavalli@lovoo.com>
 **/
class AddressController
{
    /**
     * @var AddressService
     */
    private $addressService;

    /**
     * AddressController constructor.
     * @param AddressService $addressService
     */
    public function __construct(AddressService $addressService)
    {
        $this->addressService = $addressService;
    }

    public function get()
    {
        return json_encode($this->addressService->getAddresses());
    }

}