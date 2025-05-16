<?php

namespace Teardrops\Teardrops\Http;

class Router
{
    public static function resolve(Route $route, string $httpMethod): void
    {
        $controllerClass = 'App\\Http\\Controllers\\' . ucfirst($route->controller()) . 'Controller';

        if (! class_exists($controllerClass)) {
            throw new \Exception("Controller not found: $controllerClass");
        }

        $controllerInstance = new $controllerClass();
        $methodName = $route->callable($httpMethod);

        if (! method_exists($controllerInstance, $methodName)) {
            throw new \Exception("Method not found: $methodName in $controllerClass");
        }

        call_user_func_array([$controllerInstance, $methodName], $route->parameters());
    }
}