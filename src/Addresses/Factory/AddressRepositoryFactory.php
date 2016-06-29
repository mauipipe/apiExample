<?php

/**
 * @author davidcontavalli 
 */

namespace Addresses\Factory;


use Addresses\DbConnection\DbConnector;
use Addresses\Repository\AddressRepository;

class AddressRepositoryFactory implements FactoryInterface
{

    /**
     * @return mixed
     */
    public static function create()
    {
        $dbConnector = DbConnector::initDb();
        
        return new AddressRepository($dbConnector);
    }
}