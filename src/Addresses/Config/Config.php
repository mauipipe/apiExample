<?php
/**
 * Created by IntelliJ IDEA.
 * User: davidcontavalli
 * Date: 27/06/16
 * Time: 17:49.
 */

namespace Addresses\Config;

class Config
{
    const PARAMS = 'params';
    const FACTORY = 'factory';
    const ACTION = 'action';
    const CONTROLLER = 'controller';

    private $configIterator;

    /**
     * @param string $configFilePath
     */
    public function __construct($configFilePath)
    {
        if (!is_file($configFilePath)) {
            throw new \RuntimeException(sprintf('Not valid config path %s', $configFilePath));
        }
        $fileContent = @file_get_contents($configFilePath);
        $this->configIterator = new \ArrayIterator(json_decode($fileContent, true));
    }

    /**
     * @return \ArrayIterator
     */
    public function getConfig()
    {
        return $this->configIterator;
    }
}
