<?php

namespace Teardrops\Teardrops\Http;

use Teardrops\Teardrops\Config\Database;

class Model
{
    protected static \PDO $database;

    public static function initialize(): void
    {
        self::$database = Database::getInstance();
    }

    public static function database(): \PDO
    {
        return self::$database;
    }
}
