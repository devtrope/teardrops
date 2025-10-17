<?php

namespace Teardrops\Teardrops;

class Route
{
    protected static $routes = [];

    public static function get(string $path , callable $handler): void
    {
        self::$routes[$path] = $handler;
    }
}
