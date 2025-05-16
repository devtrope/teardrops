<?php

namespace Teardrops\Teardrops\Http;

use DI\Container;
use DI\ContainerBuilder;
use Teardrops\Teardrops\Exceptions\BadRequestHttpException;
use Teardrops\Teardrops\Exceptions\NotFoundHttpException;

class Router
{
    private static ?Container $container = null;

    /**
     * Get the DI container instance.
     *
     * @return \DI\Container
     */
    public static function container(): Container
    {
        if (! self::$container) {
            $builder = new ContainerBuilder();
            self::$container = $builder->build();
        }

        return self::$container;
    }

    /**
     * Resolve the route and call the appropriate controller method.
     *
     * @param \Teardrops\Teardrops\Http\Route $route
     * @param string $httpMethod
     * @throws \Exception
     * @return void
     */
    public static function resolve(Route $route, string $httpMethod): void
    {
        $controllerClass = 'App\\Http\\Controllers\\' . $route->controllerName();

        if (! class_exists($controllerClass)) {
            throw new NotFoundHttpException("Controller not found: $controllerClass");
        }

        $controllerInstance = (object) self::container()->get($controllerClass);
        $methodName = $route->methodName($httpMethod);

        if (! method_exists($controllerInstance, $methodName)) {
            throw new NotFoundHttpException("Method not found: $methodName in $controllerClass");
        }

        $callable = [$controllerInstance, $methodName];

        if (! is_callable($callable)) {
            throw new NotFoundHttpException("Method not callable: $methodName in $controllerClass");
        }

        $parameters = self::resolveParameters($controllerInstance, $methodName, $route->parameters());

        $response = call_user_func_array($callable, $parameters);

        if ($response instanceof Response) {
            $response->send();
        } else {
            throw new BadRequestHttpException("Invalid response type: " . gettype($response));
        }
    }

    /**
     * Resolve the parameters for the controller method.
     *
     * @param object $controller
     * @param string $methodName
     * @param array $parameters
     * @throws NotFoundHttpException
     * @return array
     */
    public static function resolveParameters(object $controller, string $methodName, array $parameters): array
    {
        $reflection = new \ReflectionMethod($controller, $methodName);
        $expectedParameters = $reflection->getParameters();

        if (count($parameters) > count($expectedParameters)) {
            throw new BadRequestHttpException("Too many parameters provided for method: $methodName");
        }

        $resolvedParameters = [];

        foreach ($expectedParameters as $index => $parameter) {
            if (array_key_exists($index, $parameters)) {
                $resolvedParameters[] = $parameters[$index];
                continue;
            }

            if ($parameter->isDefaultValueAvailable()) {
                $resolvedParameters[] = $parameter->getDefaultValue();
                continue;
            }

            if ($parameter->allowsNull()) {
                $resolvedParameters[] = null;
                continue;
            }

            throw new BadRequestHttpException("Missing required parameter: " . $parameter->getName());
        }

        return $resolvedParameters;
    }
}
