<?php

namespace Teardrops\Teardrops\Kernel;

class Kernel
{
    public function handle(Request $request): void
    {
        $segments = $request->segments();
        $controller = $segments[0] ?: 'home';
        $method = $segments[1] ?? 'index';

        try {
            Router::resolve($controller, $method, $request->getHttpMethod(), $segments);
        } catch (\Exception $e) {
            http_response_code(404);
            echo "Error: " . $e->getMessage();
        }
    }
}