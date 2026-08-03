<?php

namespace App\Core;

use PDO;
use PDOException;

class Database
{
    private static ?PDO $instance = null;

    /**
     * Get Singleton PDO Instance
     *
     * @return PDO
     */
    public static function getConnection(): PDO
    {
        if (self::$instance === null) {
            $configPath = __DIR__ . '/../../config/database.php';
            if (!file_exists($configPath)) {
                throw new PDOException("Database configuration file not found at: {$configPath}");
            }

            $config = require $configPath;

            $dsn = sprintf(
                "mysql:host=%s;port=%s;dbname=%s;charset=%s",
                $config['host'],
                $config['port'],
                $config['dbname'],
                $config['charset']
            );

            self::$instance = new PDO(
                $dsn,
                $config['username'],
                $config['password'],
                $config['options'] ?? []
            );
        }

        return self::$instance;
    }
}
