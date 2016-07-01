<?php
/**
 * @author davidcontavalli
 */

namespace Addresses\Http;

class ResponseDispatcher
{
    public static function dispatch(ResponseInterface $response)
    {
        foreach ($response->getHeaders() as $header){
            header($header);
        }

        http_response_code($response->getStatusCode());

        return $response->getBody();
    }
}