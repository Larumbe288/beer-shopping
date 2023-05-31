<?php

namespace BeerApi\Shopping\Connection;

use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Class doctrine
 */
class Doctrine
{
    /**
     * @throws \Doctrine\DBAL\Exception
     */
    public static function access(): QueryBuilder
    {
        $connectionParams = array(
            'dbname' => 'brmrawlblggmpemzkeqo',
            'user' => 'ugprwnpfk5kpdh25',
            'password' => 'xBkPe2ILVxZ1jua4uHxs',
            'host' => 'brmrawlblggmpemzkeqo-mysql.services.clever-cloud.com',
            'driver' => 'pdo_mysql',
        );
        $conn = DriverManager::getConnection($connectionParams);
        return new QueryBuilder($conn);
    }
}