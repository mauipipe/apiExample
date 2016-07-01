<?php

namespace Addresses\Hydrator;

/**
 * @author davidcontavalli <david.contavalli@lovoo.com>
 */
interface HydratorInterface
{
    public function hydrate(array $data);
}
