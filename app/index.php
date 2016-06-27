<?php
/**
 * @author davidcontavalli <david.contavalli@lovoo.com>
 */

use Addresses\Controller\AddressController;

$autoLoader = require '../vendor/autoload.php';

$addressService = \Addresses\Factory\AddressServiceFactory::create();
$addressController = new AddressController($addressService);
echo $addressController->get();
