<?php

namespace Addresses\Controller;

use Addresses\Enum\StatusCodes;
use Addresses\Http\Request;
use Addresses\Http\Response;
use Addresses\Http\ResponseInterface;
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

    /**
     * @return ResponseInterface
     */
    public function getAddresses()
    {
        return new Response($this->addressService->getAddresses(), StatusCodes::SUCCESS_200, 'json');
    }

    /**
     * @param Request $request
     * @return ResponseInterface
     */
    public function getAddress(Request $request)
    {
        $params = $request->getQueryParams();
        return new Response($this->addressService->getAddress($params), StatusCodes::SUCCESS_200, 'json');
    }

    public function addAddresses(Request $request)
    {
        $postBody = $request->getPost();

        try {
            $this->addressService->addAddress($postBody);
            return new Response(['status' => 'added'], StatusCodes::ADD_SUCCESS_201, 'json');
        } catch (\PDOException $e) {
            return new Response(['error' => $e->getMessage()], StatusCodes::SERVER_ERROR_500, 'json');
        }
    }

}