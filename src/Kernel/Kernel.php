<?php

namespace Teardrops\Teardrops\Kernel;

class Kernel
{
    public function handle(Request $request)
    {
        $trimedURI = trim($request->getUri(), '/');
        $explodedURI = explode('/', $trimedURI);

        $controller = $explodedURI[0] ?: 'home';
        $method = $explodedURI[1] ?? 'index';

        try {
            $router = new Router();
            $router->resolve($controller, $method, $explodedURI);
        } catch (\Exception $e) {
            http_response_code(404);
            echo "Error: " . $e->getMessage();
        }
    }
}