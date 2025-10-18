<?php

namespace Teardrops\Teardrops;

class Router
{
    public static function dispatch(string $uri): void
    {
        $handler = self::match($uri, Route::getRoutes());

        if ($handler) {
            call_user_func($handler);
        } else {
            http_response_code(404);
            echo '404 Not Found';
        }
    }

    private static function match(string $uri, array $routes): callable|null
    {
        // Search for an exact match
        if (isset($routes[$uri])) {
            return $routes[$uri];
        }

        $explodedUri = explode('/', trim($uri, '/'));

        foreach ($routes as $route => $handler) {
            $explodedRoute = explode('/', trim($route, '/'));

            if (count($explodedUri) !== count($explodedRoute)) {
                continue;
            }

            if (self::segmentsMatch($explodedRoute, $explodedUri)) {
                return $handler;
            }
        }

        return null;
    }

    private static function segmentsMatch(array $routeSegments, array $uriSegments): bool
    {
        foreach ($routeSegments as $index => $segment) {
            // We don't care if it's a perfect match for dynamic segments like {slug} or {id}
            if (preg_match('/^{\w+}$/', $segment)) {
                continue;
            }

            if ($segment !== $uriSegments[$index]) {
                return false;
            }
        }

        return true;
    }
}
