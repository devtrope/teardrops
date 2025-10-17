<?php

namespace Teardrops\Teardrops;

class Router
{
    public static function dispatch(string $uri): void
    {
        $routes = Route::getRoutes();
        if (isset($routes[$uri])) {
            call_user_func($routes[$uri]);
        } else {
            http_response_code(404);
            echo '404 Not Found';
        }
    }
}
