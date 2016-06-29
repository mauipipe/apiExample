<?php

namespace Addresses\Controller;

use Addresses\Http\Request;
use Addresses\Service\AddressService;

/**
 * @author davidcontavalli 
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

    public function getAddresses()
    {
        return json_encode($this->addressService->getAddresses());
    }

    public function getAddress(Request $request)
    {
        $params = $request->getQueryParams();
        return json_encode($this->addressService->getAddress($params));
    }

}