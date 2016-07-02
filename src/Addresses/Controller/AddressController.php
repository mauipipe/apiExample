<?php

namespace Addresses\Controller;

use Addresses\Enum\StatusCodes;
use Addresses\Exception\ValidationException;
use Addresses\Http\Factory\ResponseFactoryConsumer;
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
     * @var ResponseFactoryConsumer
     */
    private $responseFactoryConsumer;

    /**
     * @param AddressService          $addressService
     * @param ValidatorConsumer       $validatorConsumer
     * @param ResponseFactoryConsumer $responseFactoryConsumer
     */
    public function __construct(AddressService $addressService, ValidatorConsumer $validatorConsumer, ResponseFactoryConsumer $responseFactoryConsumer)
    {
        $this->addressService = $addressService;
        $this->validatorConsumer = $validatorConsumer;
        $this->responseFactoryConsumer = $responseFactoryConsumer;
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
     *
     * @return ResponseInterface
     */
    public function getAddress(Request $request)
    {
        $params = $request->getQueryParams();
        $address = $this->addressService->getAddress($params);

        return $this->responseFactoryConsumer->create('json', [$address], StatusCodes::SUCCESS_200);
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function addAddresses(Request $request)
    {
        $postBody = $request->getPost();
        $this->validatorConsumer->setStrategy('addressValidator');

        try {
            $this->validatorConsumer->validate($postBody);
            $this->addressService->addAddress($postBody);

            return $this->responseFactoryConsumer->create('json', ['status' => 'added'], StatusCodes::ADD_SUCCESS_201);
        } catch (\PDOException $e) {
            return $this->responseFactoryConsumer->create('json', ['error' => $e->getMessage()], StatusCodes::SERVER_ERROR_500);
        } catch (ValidationException $e) {
            return $this->responseFactoryConsumer->create('json', ['error' => $e->getMessage()], StatusCodes::BAD_REQUEST_400);
        } catch (\RuntimeException $e) {
            return $this->responseFactoryConsumer->create('json', ['error' => $e->getMessage()], StatusCodes::SERVER_ERROR_500);
        }
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function updateAddress(Request $request)
    {
        $body = $request->getPutBody();
        $id = $request->getParam('id');
        $this->validatorConsumer->setStrategy('addressValidator');

        try {
            $this->validatorConsumer->validate($body);
            $address = $this->addressService->updateAddress($id, $body);

            return $this->responseFactoryConsumer->create('json', ['address' => $address->getData()], StatusCodes::SUCCESS_200);
        } catch (\PDOException $e) {
            return $this->responseFactoryConsumer->create('json', ['error' => $e->getMessage()], StatusCodes::SERVER_ERROR_500);
        } catch (ValidationException $e) {
            return $this->responseFactoryConsumer->create('json', ['error' => $e->getMessage()], StatusCodes::BAD_REQUEST_400);
        } catch (\RuntimeException $e) {
            return $this->responseFactoryConsumer->create('json', ['error' => $e->getMessage()], StatusCodes::SERVER_ERROR_500);
        }
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function deleteAddress(Request $request)
    {
        $id = $request->getParam('id');

        try {
            $this->addressService->deleteAddress($id);

            return $this->responseFactoryConsumer->create('json', ['status' => 'deleted'], StatusCodes::DELETE_SUCCESS_204);
        } catch (\PDOException $e) {
            return $this->responseFactoryConsumer->create('json', ['error' => $e->getMessage()], StatusCodes::SERVER_ERROR_500);
        }
    }
}
