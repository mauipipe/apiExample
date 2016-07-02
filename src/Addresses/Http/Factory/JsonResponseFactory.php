<?php

/**
 * @author davidcontavalli <david.contavalli@lovoo.com>
 */

namespace Addresses\Http\Factory;

use Addresses\Http\Response;

class JsonResponseFactory
{
    public function create($data, $statusCode)
    {
        $response = new Response($data, $statusCode, 'json');
        $response->setHeader('Content-Type: application/json; charset=UTF-8');

        return $response;
    }
}
