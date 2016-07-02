<?php

/**
 * @author davidcontavalli 
 */

namespace Addresses\Helper;

use Addresses\Http\Response;
use Addresses\Http\ResponseInterface;

class ResponseHelper
{
    /**
     * @param $uri
     *
     * @return ResponseInterface
     */
    public static function getInvalidRouteExceptionResponse($uri)
    {
        $errorMsg = sprintf('Invalid route provided %s', $uri);

        return new Response(['error' => $errorMsg], 404, 'json');
    }
}
