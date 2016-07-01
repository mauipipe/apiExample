<?php

/**
 * @author davidcontavalli
 */

namespace Addresses\DbConnection;

use Addresses\Config\Config;
use PDO;

class DbConnector
{
    /**
     * @return PDO
     */
    public static function initDb()
    {
        $config = new Config(__DIR__ . '/../../../config/db.json');
        $configData = $config->getConfig();
        $dsn = sprintf(
            '%s:host=%s;dbname=%s;charset=%s',
            $configData['type'], $configData['host'], $configData['database'], $configData['charset']
        );

        $pdo = new \PDO($dsn, $configData['user'], $configData['password']);
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