<?php
/**
 * @author davidcontavalli
 */

namespace Addresses\Http;

class ResponseDispatcher
{
    public static function dispatch(ResponseInterface $response)
    {
        header($response->getHeader());
        http_response_code($response->getStatusCode());

        return $response->getBody();
    }
}