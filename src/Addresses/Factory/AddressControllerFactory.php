<?php
/**
 * Created by IntelliJ IDEA.
 * User: davidcontavalli
 * Date: 27/06/16
 * Time: 17:02
 */

namespace Addresses\Factory;


use Addresses\Controller\AddressController;
use Addresses\Http\Factory\ResponseFactoryConsumer;
use Addresses\Validator\ValidatorConsumer;

class AddressControllerFactory implements FactoryInterface
{
    /**
     * @return mixed
     */
    public static function create()
    {
        $addressService = AddressServiceFactory::create();
        $responseConsumer = new ResponseFactoryConsumer();
        $validatorConsumer = new ValidatorConsumer();
        
        return new AddressController($addressService, $validatorConsumer, $responseConsumer);
    }
}