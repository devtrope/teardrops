<?php

namespace Teardrops\Teardrops\Http;

use Teardrops\Teardrops\Support\Config;

class Route
{
    private string $controller;
    private string $method;
    protected array $parameters = [];

    public function __construct(Request $request)
    {
        $segments = $request->segments();

        $this->controller = $segments[0] ?: Config::get('DEFAULT_CONTROLLER', 'home');
        $this->method = $segments[1] ?? Config::get('DEFAULT_METHOD', 'index');
        $this->parameters = array_slice($segments, 2);
    }

    /**
     * Get the parameters.
     *
     * @return array
     */
    public function parameters(): array
    {
        return $this->parameters;
    }

    /**
     * Get the controller name.
     *
     * @return string
     */
    public function controllerName(): string
    {
        $controller = ucfirst($this->controller);

        // Ensure the controller name can be used even if it contains underscores
        if (stripos($controller, '_') !== false) {
            $controller = ucwords($controller, '_');
            $controller = str_replace('_', '', $controller);
        }

        return $controller . 'Controller';
    }

    /**
     * Get the method name based on the HTTP method.
     *
     * @param string $httpMethod
     * @return string
     */
    public function methodName(string $httpMethod): string
    {
        $method = $this->method;

        // Ensure the method name can be used even if it contains underscores
        if (stripos($this->method, '_') !== false) {
            $method = ucwords($this->method, '_');
            $method = str_replace('_', '', $method);
        }
        
        return strtolower($httpMethod) . ucfirst($method);
    }
}
