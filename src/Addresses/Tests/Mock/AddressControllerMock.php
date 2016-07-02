<?php

namespace Addresses\Tests\Mock;

use Addresses\Http\Request;
use Addresses\Tests\Mock\Factory\MockFactory;

/**
 * @author davidcontavalli
 **/
class AddressControllerMock
{
    /**
     * AddressController constructor.
     */
    public function __construct()
    {
    }

    public function getAddresses()
    {
        return MockFactory::createMockResponse(null);
    }

    public function getAddress(Request $request)
    {
        $data = $request->getQueryParams();

        return MockFactory::createMockResponse($data);
    }
}
