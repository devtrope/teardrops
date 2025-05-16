<?php

namespace Teardrops\Teardrops\Kernel;

class Router
{
    public static function resolve(string $controller, ?string $method, string $httpMethod, array $explodedURI): void
    {
        $controllerClass = 'App\\Http\\Controllers\\' . ucfirst($controller) . 'Controller';

        if (! class_exists($controllerClass)) {
            throw new \Exception("Controller not found: $controllerClass");
        }

        $controllerInstance = new $controllerClass();
        
        $methodName = $httpMethod . ucfirst($method);

        if (! method_exists($controllerInstance, $methodName)) {
            throw new \Exception("Method not found: $methodName in $controllerClass");
        }

        call_user_func_array([$controllerInstance, $methodName], array_slice($explodedURI, 2));
    }
}