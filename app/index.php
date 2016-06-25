<?php
/**
 * @author davidcontavalli <david.contavalli@lovoo.com>
 */

use Addresses\Controller\AddressController;

$autoLoader = require '../vendor/autoload.php';

$addressController = new AddressController();
echo $addressController->get();
