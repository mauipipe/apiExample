<?php
/**
 * Created by IntelliJ IDEA.
 * User: davidcontavalli
 * Date: 27/06/16
 * Time: 16:24
 */

namespace Addresses\Repository;

use Addresses\Model\Address;

interface AddressDbInterface
{
    /**
     * @return mixed
     */
    public function fetchAddresses();

    /**
     * @param array $getQueryParams
     * @return mixed
     */
    public function fetchAddressByParams(array $getQueryParams);

    /**
     * @param Address $address
     */
    public function addAddress(Address $address);
}