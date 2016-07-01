<?php

namespace Addresses\Controller;

use Addresses\Enum\StatusCodes;
use Addresses\Exception\ValidationException;
use Addresses\Http\Request;
use Addresses\Http\Response;
use Addresses\Http\ResponseInterface;
use Addresses\Service\AddressService;
use Addresses\Validator\ValidatorConsumer;

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
     * @var ValidatorConsumer
     */
    private $validatorConsumer;

    /**
     * @param AddressService $addressService
     * @param ValidatorConsumer $validatorConsumer
     */
    public function __construct(AddressService $addressService, ValidatorConsumer $validatorConsumer)
    {
        $this->addressService = $addressService;
        $this->validatorConsumer = $validatorConsumer;
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
        $address = $this->addressService->getAddress($params);
        return new Response([$address], StatusCodes::SUCCESS_200, 'json');
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function addAddresses(Request $request)
    {
        $postBody = $request->getPost();
        $this->validatorConsumer->setStrategy('addressValidator');

        try {
            $this->validatorConsumer->validate($postBody);
            $this->addressService->addAddress($postBody);
            return new Response(['status' => 'added'], StatusCodes::ADD_SUCCESS_201, 'json');
        } catch (\PDOException $e) {
            return new Response(['error' => $e->getMessage()], StatusCodes::SERVER_ERROR_500, 'json');
        } catch (ValidationException $e) {
            return new Response(['error' => $e->getMessage()], StatusCodes::BAD_REQUEST_400, 'json');
        } catch (\RuntimeException $e) {
            return new Response(['error' => $e->getMessage()], StatusCodes::SERVER_ERROR_500, 'json');
        }
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function updateAddress(Request $request)
    {
        $body = $request->getPutBody();
        $id = $request->getParam("id");
        $this->validatorConsumer->setStrategy('addressValidator');

        try {
            $this->validatorConsumer->validate($body);
            $this->addressService->updateAddress($id, $body);
            return new Response(['status' => 'updated'], StatusCodes::SUCCESS_200, 'json');
        } catch (\PDOException $e) {
            return new Response(['error' => $e->getMessage()], StatusCodes::SERVER_ERROR_500, 'json');
        } catch (ValidationException $e) {
            return new Response(['error' => $e->getMessage()], StatusCodes::BAD_REQUEST_400, 'json');
        } catch (\RuntimeException $e) {
            return new Response(['error' => $e->getMessage()], StatusCodes::SERVER_ERROR_500, 'json');
        }
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function deleteAddress(Request $request)
    {
        $id = $request->getParam("id");

        try {
            $this->addressService->deleteAddress($id);
            return new Response(['status' => 'deleted'], StatusCodes::DELETE_SUCCESS_204, 'json');
        } catch (\PDOException $e) {
            return new Response(['error' => $e->getMessage()], StatusCodes::SERVER_ERROR_500, 'json');
        }
    }
}