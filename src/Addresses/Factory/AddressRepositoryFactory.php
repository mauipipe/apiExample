<?php

namespace Addresses\Factory;

use Addresses\DbConnection\DbConnector;
use Addresses\Manager\DbManager;
use Addresses\Repository\AddressRepository;

/**
 * @author davidcontavalli
 */
class AddressRepositoryFactory implements FactoryInterface
{
    /**
     * @return mixed
     */
    public static function create()
    {
        $dbConnector = DbConnector::initDb();
        $dbManager = new DbManager($dbConnector);

        return new AddressRepository($dbManager);
    }
}
