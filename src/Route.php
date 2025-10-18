<?php

namespace Teardrops\Teardrops;

class Route
{
    protected static $routes = [];

    public static function get(string $path , callable $handler): void
    {
        self::assignRoute('GET', $path, $handler);
    }
    
    public static function post(string $path , callable $handler): void
    {
        self::assignRoute('POST', $path, $handler);
    }

    private static function assignRoute(string $method, string $path, callable $handler): void
    {
        self::$routes[$method][$path] = $handler;
    }

    public static function getRoutes(string $requestMethod): array
    {
        if (! isset(self::$routes[$requestMethod])) {
            return [];
        }

        return self::$routes[$requestMethod];
    }
}
