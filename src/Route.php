<?php

namespace Teardrops\Teardrops;

class Route
{
    protected static $routes = [];

    public static function get(string $path , callable $handler): void
    {
        self::$routes['GET'][$path] = $handler;
    }
    public static function post(string $path , callable $handler): void
    {
        self::$routes['POST'][$path] = $handler;
    }

    public static function getRoutes(string $requestMethod): array
    {
        if (! isset(self::$routes[$requestMethod])) {
            return [];
        }

        return self::$routes[$requestMethod];
    }
}
