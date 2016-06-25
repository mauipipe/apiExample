<?php

namespace Addresses\Controller;

/**
 * @author davidcontavalli <david.contavalli@lovoo.com>
 **/
class AddressController
{
    public function get()
    {
        $response = [
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

        return json_encode($response);
    }

}