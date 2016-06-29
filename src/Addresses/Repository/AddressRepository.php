<?php
namespace Addresses\Repository;
/**
 * Created by IntelliJ IDEA.
 * User: davidcontavalli
 * Date: 27/06/16
 * Time: 16:23
 */
class AddressRepository implements AddressDbInterface
{

    /**
     * AddressRepository constructor.
     */
    public function __construct()
    {
    }

    public function fetchAddresses()
    {
        return [
            [
                "name" => "test",
                "address" => "mercy",
                "nr" => 23
            ],
            [
                "name" => "test2",
                "address" => "mercy2",
                "nr" => 45
            ]
        ];
    }

    public function fetchAddressByParams($getQueryParams)
    {
        return [
            [
                "name" => "test",
                "address" => "mercy",
                "nr" => 23
            ]
        ];
    }
}