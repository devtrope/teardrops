<?php

namespace Teardrops\Teardrops\Config\Routing;

use DI\Container;
use ReflectionMethod;
use DI\ContainerBuilder;
use Teardrops\Teardrops\Config\Config;

/**
 * Router class that handles routing requests to the appropriate controller and method.
 *
 * @package Teardrops\Teardrops\Config\Routing
 * @version 1.0
 * @author Quentin SCHIFFERLE <dev.trope@gmail.com>
 */
class Router
{
    private Container $container;

    public function __construct()
    {
        $containerBuilder = new ContainerBuilder();
        $this->container = $containerBuilder->build();
    }

    /**
     * Runs the router, matching the request to a controller and method.
     *
     * @throws \Exception
     */
    public function run(): void
    {
        try {
            $request = new HttpRequest();

            $controller = $this->formatController(
                $request->getSegment(0, Config::DEFAULT_CONTROLLER)
            );

            $method = $this->formatMethod(
                $request->getMethod(),
                $request->getSegment(1, Config::DEFAULT_METHOD)
            );

            $parameters = array_slice($request->getSegments(), 2);

            $this->dispatch($controller, $method, $parameters);
        } catch (\Exception $e) {
            $this->handleGeneralError($e);
        }
    }

    /**
     * Formats the controller name by capitalizing it and removing underscores.
     *
     * @param string $controller
     * @return string
     */
    private function formatController(string $controller): string
    {
        $controller = ucfirst($controller);

        if (stripos($controller, '_') !== false) {
            $controller = ucwords($controller, '_');
            $controller = str_replace('_', '', $controller);
        }

        return $controller . 'Controller';
    }

    /**
     * Formats the method name by converting it to camel case.
     *
     * @param string $requestMethod
     * @param string $method
     * @return string
     */
    private function formatMethod(string $requestMethod, string $method): string
    {
        if (stripos($method, '_') !== false) {
            $method = ucwords($method, '_');
            $method = str_replace('_', '', $method);
        }

        return strtolower($requestMethod) . ucfirst($method);
    }

    /**
     * Dispatches the request to the appropriate controller and method.
     *
     * @param string $controller
     * @param string $method
     * @param array $parameters
     * @throws \Exception
     */
    private function dispatch(string $controller, string $method, array $parameters): void
    {
        $controllerClass = $this->resolveController($controller);
        $controllerInstance = $this->container->get($controllerClass);
        $this->validateMethod($controllerClass, $method);
        $resolvedParameters = $this->resolveParameters($controllerClass, $method, $parameters);
        call_user_func_array([$controllerInstance, $method], $resolvedParameters);
    }

    /**
     * Resolves the controller class and ensures it exists.
     *
     * @param string $controller
     * @return string
     * @throws \Exception
     */
    private function resolveController(string $controller): string
    {
        $controllerFile = $this->getControllerFilePath($controller);

        if (! file_exists($controllerFile)) {
            throw new \Exception("Controller file {$controllerFile} does not exist.");
        }

        require_once $controllerFile;

        $controllerClass = $this->getControllerClass($controller);

        if (! class_exists($controllerClass)) {
            throw new \Exception("Controller class {$controllerClass} does not exist.");
        }

        return $controllerClass;
    }

    /**
     * Validates that the method exists in the controller class.
     *
     * @param string $controllerClass
     * @param string $method
     * @throws \Exception
     */
    private function validateMethod(string $controllerClass, string $method): void
    {
        if (! method_exists($controllerClass, $method)) {
            throw new \Exception("Method {$method} does not exist in controller {$controllerClass}.");
        }
    }

    /**
     * Resolves the parameters for the method, providing default values if necessary.
     *
     * @param string $controllerClass
     * @param string $method
     * @param array $parameters
     * @return array
     */
    private function resolveParameters(string $controllerClass, string $method, array $parameters): array
    {
        $reflection = new ReflectionMethod($controllerClass, $method);
        $requiredParameters = $reflection->getParameters();
        $resolvedParameters = [];

        foreach ($requiredParameters as $index => $param) {
            if (isset($parameters[$index])) {
                $resolvedParameters[] = $parameters[$index];
            } elseif ($param->isDefaultValueAvailable()) {
                $resolvedParameters[] = $param->getDefaultValue();
            } else {
                $resolvedParameters[] = null;
            }
        }

        return $resolvedParameters;
    }

    /**
     * Returns the file path for the controller.
     *
     * @param string $controller
     * @return string
     */
    private function getControllerFilePath(string $controller): string
    {
        return dirname(__DIR__) . "/../Http/Controller/" . $controller . ".php";
    }

    /**
     * Returns the fully qualified class name for the controller.
     *
     * @param string $controller
     * @return string
     */
    private function getControllerClass(string $controller): string
    {
        return "\\Teardrops\\Teardrops\\Http\\Controller\\" . $controller;
    }

    /**
     * Handles general errors by sending an appropriate response.
     *
     * @param \Exception $e
     */
    private function handleGeneralError(\Exception $e): void
    {
        http_response_code(500);

        if (Config::isDevelopment()) {
            echo "Error: " . $e->getMessage() . "\n" . $e->getTraceAsString();
        } else {
            echo "An error occurred. Please try again later.";
        }
    }
}
