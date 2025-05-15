<?php

namespace Teardrops\Teardrops\Kernel;

class Router
{
    public function resolve(string $controller, ?string $method, array $explodedURI)
    {
        $controllerClass = 'App\\Http\\Controllers\\' . ucfirst($controller) . 'Controller';

        if (! class_exists($controllerClass)) {
            throw new \Exception("Controller not found: $controllerClass");
        }

        $controllerInstance = new $controllerClass();
        if (! method_exists($controllerInstance, $method)) {
            throw new \Exception("Method not found: $method in $controllerClass");
        }

        call_user_func_array([$controllerInstance, $method], array_slice($explodedURI, 2));
    }
}