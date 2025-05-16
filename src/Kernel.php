<?php

namespace Teardrops\Teardrops;

use Teardrops\Teardrops\Http\Request;
use Teardrops\Teardrops\Http\Router;

class Kernel
{
    public function handle(Request $request): void
    {
        try {
            $segments = $request->segments();
            $controller = $segments[0] ?: 'home';
            $method = $segments[1] ?? 'index';
            
            Router::resolve($controller, $method, $request->getHttpMethod(), $segments);
        } catch (\Exception $e) {
            http_response_code(404);
            echo "Error: " . $e->getMessage();
        }
    }
}