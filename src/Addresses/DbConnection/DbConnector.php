<?php

/**
 * @author davidcontavalli 
 */

namespace Addresses\DbConnection;


use PDOException;

class DbConnector
{

    public static function initDb()
    {
            return new \PDO('mysql:host=localhost;dbname=address;charset=utf8mb4', 'user', '123456');
    }

    public static function destroy()
    {
        $pdo = self::initDb();

            $stmt = $pdo->prepare("TRUNCATE TABLE address");
            $stmt->execute();

    }
}