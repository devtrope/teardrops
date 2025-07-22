<?php

namespace Teardrops\Teardrops\Config;

use PDO;

class Database
{
    private static ?PDO $instance = null;

    public static function getInstance(): PDO
    {
        try {
            if (self::$instance === null) {
                return self::$instance = new PDO(
                    "mysql:host={$_ENV['DATABASE_HOST']};
                    dbname={$_ENV['DATABASE_DB']};
                    charset=utf8mb4;
                    port={$_ENV['DATABASE_PORT']}",
                    $_ENV['DATABASE_USER'],
                    $_ENV['DATABASE_PWD'],
                    [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                        PDO::ATTR_EMULATE_PREPARES => false,
                    ]
                );
            }

            return self::$instance;
        } catch (\PDOException $e) {
            throw new \RuntimeException('Database connection failed: ' . $e->getMessage());
        }
    }
}
