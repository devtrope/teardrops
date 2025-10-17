<?php

namespace Teardrops\Teardrops;

class Route
{
    protected static $routes = [];

    public static function get(string $path , callable $handler): void
    {
        self::$routes[$path] = $handler;
    }

    public static function getRoutes(): array
    {
        return self::$routes;
    }
}
