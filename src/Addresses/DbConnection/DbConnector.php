<?php

/**
 * @author davidcontavalli
 */

namespace Addresses\DbConnection;

use PDO;

class DbConnector
{
    /**
     * @return PDO
     */
    public static function initDb()
    {
        $pdo = new \PDO('mysql:host=localhost;dbname=address;charset=utf8mb4', 'user', '123456');
        $pdo->exec("SET CHARACTER SET utf8");      // Sets encoding UTF-8
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $pdo;
    }

    public static function destroy()
    {
        $pdo = self::initDb();

        $stmt = $pdo->prepare("TRUNCATE TABLE address");
        $stmt->execute();

    }
}