<?php

namespace Teardrops\Teardrops\Config\Routing;

use ReflectionMethod;

class Router extends Routing
{
    public static function run(string $uri): void
    {
        $request = new Request($uri);
        self::match($request->controller, $request->method, $request->params);
    }

    private static function match(?string $controller, string $method, array $params): mixed
    {
        if ($controller === null) {
            $controller = ucfirst(\Teardrops\Teardrops\Config\Config::DEFAULT_CONTROLLER) . 'Controller';
        }

        $controllerFile = 'Http//Controller//' . $controller . '.php';
        if (! file_exists($controllerFile)) {
            throw new \Exception("Controller file {$controllerFile} does not exist.");
        }

        require_once $controllerFile;
        $controller = "Http\\Controller\\" . $controller;

        if (! class_exists($controller)) {
            throw new \Exception("Controller class {$controller} does not exist.");
        }

        $controllerInstance = new $controller();

        if (! method_exists($controllerInstance, $method)) {
            throw new \Exception("Method {$method} does not exist in controller {$controller}.");
        }

        $params = self::setParams($controller, $method, $params);

        return call_user_func_array([$controllerInstance, $method], $params);
    }

    private static function setParams(string $controller, string $method, array $params): array
    {
        $reflection = new ReflectionMethod($controller, $method);
        $requiredParams = $reflection->getParameters();

        if ($params === null || sizeof($requiredParams) !== sizeof($params)) {
            for ($i = 0; $i < sizeof($requiredParams); $i++) {
                if (! isset($params[$i])) {
                    $params[$i] = null;
                }
            }
        }

        return $params;
    }
}
