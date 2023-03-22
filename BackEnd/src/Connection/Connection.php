<?php

namespace BeerApi\Shopping\Connection;

use PDO;
use PDOException;

/**
 *
 */
class Connection
{
    const DB_CADENA = "mysql:host=brmrawlblggmpemzkeqo-mysql.services.clever-cloud.com;dbname=brmrawlblggmpemzkeqo";
    const DB_USER = "ugprwnpfk5kpdh25";
    const DB_PASSWORD = "xBkPe2ILVxZ1jua4uHxs";

    public static function access()
    {
        try {
            return new PDO(self::DB_CADENA, self::DB_USER, self::DB_PASSWORD);
        } catch (PDOException $e) {
            throw $e;
        }
    }
}