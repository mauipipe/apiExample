<?php

/**
 * @author davidcontavalli <david.contavalli@lovoo.com>
 */

namespace Addresses\Http\Factory;


interface ResponseFactoryInterface
{
    public function create($data,$statusCode);
}