<?php

namespace BeerApi\Shopping\Users\Infrastucture;

use PDO;
use PDOException;

class Connection
{
    const hostname = "brmrawlblggmpemzkeqo-mysql.services.clever-cloud.com";
    const dbName = "brmrawlblggmpemzkeqo";
    const user = "ugprwnpfk5kpdh25";
    const password = "xBkPe2ILVxZ1jua4uHxs";

    public static function access()
    {
        try {
            $connection = "mysql:host=" . self::hostname . "; dbname=" . self::dbName;

            return new PDO($connection, self::user, self::password);
        } catch (PDOException $e) {
            echo "Connection error: " . $e->getMessage() . "\n";
            exit();
        }

    }
}