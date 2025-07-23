<?php

namespace Teardrops\Teardrops\Config\Routing;

use DI\Container;
use ReflectionMethod;
use DI\ContainerBuilder;
use Teardrops\Teardrops\Config\Config;

class Router
{
    private Container $container;

    public function __construct()
    {
        $containerBuilder = new ContainerBuilder();
        $this->container = $containerBuilder->build();
    }

    public function run(): void
    {
        $request = new HttpRequest();
        $controller = $this->formatController(
            $request->getSegment(0, Config::DEFAULT_CONTROLLER)
        );
        $method = $this->formatMethod(
            $request->getMethod(),
            $request->getSegment(1, Config::DEFAULT_METHOD)
        );
        $params = array_slice($request->getSegments(), 2);
        $this->match($controller, $method, $params);
    }

    private function formatController(string $controller): string
    {
        $controller = ucfirst($controller);

        if (stripos($controller, '_') !== false) {
            $controller = ucwords($controller, '_');
            $controller = str_replace('_', '', $controller);
        }

        return $controller . 'Controller';
    }

    private function formatMethod(string $requestMethod, string $method): string
    {
        if (stripos($method, '_') !== false) {
            $method = ucwords($method, '_');
            $method = str_replace('_', '', $method);
        }

        return strtolower($requestMethod) . ucfirst($method);
    }

    private function match(string $controller, string $method, array $params): mixed
    {
        $controllerFile = dirname(__DIR__) . "//..//Http//Controller//" . $controller . '.php';
        if (! file_exists($controllerFile)) {
            throw new \Exception("Controller file {$controllerFile} does not exist.");
        }

        require_once $controllerFile;
        $controller = "\\Teardrops\\Teardrops\\Http\\Controller\\" . $controller;

        if (! class_exists($controller)) {
            throw new \Exception("Controller class {$controller} does not exist.");
        }

        $controllerInstance = (object)(new self)->container->get($controller);

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
