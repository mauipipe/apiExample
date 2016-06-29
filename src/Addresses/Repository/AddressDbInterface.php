<?php
/**
 * Created by IntelliJ IDEA.
 * User: davidcontavalli
 * Date: 27/06/16
 * Time: 16:24
 */

namespace Addresses\Repository;

interface AddressDbInterface
{
    public function fetchAddresses();

    public function fetchAddressByParams($getQueryParams);
}