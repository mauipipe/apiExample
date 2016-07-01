<?php

namespace Addresses\Http\Factory;

use Addresses\Enum\ResponseTypes;
use Addresses\Http\ResponseInterface;
use Addresses\Strategy\StrategyInitializableTrait;

/**
 * @author davidcontavalli <david.contavalli@lovoo.com>
 */
class ResponseFactoryConsumer
{
    use StrategyInitializableTrait;

    private static $factoryMapper = [ResponseTypes::JSON => 'jsonResponseFactory'];

    /**
     * @param $responseType
     * @param $data
     * @param $statusCode
     *
     * @return ResponseInterface
     */
    public function create($responseType, $data, $statusCode)
    {
        if (!isset(self::$factoryMapper[$responseType])) {
            throw new \OutOfBoundsException(sprintf('invalid response type %s provided', $responseType));
        }

        $this->setStrategy(self::$factoryMapper[$responseType]);
        /** @var ResponseFactoryInterface $strategy */
        $strategy = $this->createStrategy(__NAMESPACE__);

        return $strategy->create($data, $statusCode);
    }
}
