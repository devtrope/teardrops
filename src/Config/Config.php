<?php

namespace Teardrops\Teardrops\Config;

class Config
{
    public const DEFAULT_CONTROLLER = 'home';
    public const DEFAULT_METHOD = 'index';

    private static function server(): ?string
    {
        if (php_sapi_name() === 'cli') {
            return null;
        }

        return $_SERVER['SERVER_NAME'];
    }

    public static function isDevelopment(): bool
    {
        return self::server() === 'localhost' || self::server() === '127.0.0.1';
    }

    public static function getBaseURL(): string
    {
        $http = empty($_SERVER['HTTPS']) ? 'http://' : 'https://';

        if (self::isDevelopment()) {
            return $http . self::server() . ':' . $_SERVER['SERVER_PORT'] . '/';
        }

        return $http . 'myapp.com/';
    }
}
