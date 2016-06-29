<?php

/**
 * @author davidcontavalli 
 */

namespace Addresses\Tests\Mock\Factory;


use Addresses\Http\Response;

class MockFactory
{
    public static function createMockResponse($data, $statusCode = 200, $type = 'json')
    {
        if (null === $data) {
            $data = ['test'];
        }
        return new Response($data, $statusCode, $type);
    }

}