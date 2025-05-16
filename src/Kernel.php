<?php

namespace Teardrops\Teardrops;

use Teardrops\Teardrops\Http\Request;
use Teardrops\Teardrops\Http\Router;
use Teardrops\Teardrops\Support\Config;

class Kernel
{
    public static function handle(Request $request): void
    {
        try {
            $segments = $request->segments();
            $controller = $segments[0] ?: Config::get('DEFAULT_CONTROLLER', 'home');
            $method = $segments[1] ?? Config::get('DEFAULT_METHOD', 'index');
            
            Router::resolve($controller, $method, $request->getHttpMethod(), $segments);
        } catch (\Exception $e) {
            http_response_code(404);
            echo "Error: " . $e->getMessage();
        }
    }
}