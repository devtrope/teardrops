<?php

namespace Teardrops\Teardrops;

use Teardrops\Teardrops\Http\Request;
use Teardrops\Teardrops\Http\Router;
use Teardrops\Teardrops\Http\Route;
use Teardrops\Teardrops\Support\Config;

class Kernel
{
    public static function handle(Request $request): void
    {
        try {
            $route = new Route($request);
            
            Router::resolve(
                $route->controller(),
                $route->method(),
                $request->getHttpMethod(),
                $route->parameters()
            );
        } catch (\Exception $e) {
            http_response_code(404);
            echo "Error: " . $e->getMessage();
        }
    }
}