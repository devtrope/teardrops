<?php

namespace Teardrops\Teardrops\Http;

use Teardrops\Teardrops\Support\Config;

class Route
{
    protected string $controller;
    protected string $method;
    protected array $parameters = [];

    public function __construct(Request $request)
    {
        $segments = $request->segments();

        $this->controller = $segments[0] ?: Config::get('DEFAULT_CONTROLLER', 'home');
        $this->method = $segments[1] ?? Config::get('DEFAULT_METHOD', 'index');
        $this->parameters = array_slice($segments, 2);
    }

    /**
     * Get the controller name.
     *
     * @return string
     */
    public function controller(): string
    {
        return $this->controller;
    }

    /**
     * Get the method name.
     *
     * @return string
     */
    public function method(): string
    {
        return $this->method;
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
     * Get the method name based on the HTTP method.
     *
     * @param string $httpMethod
     * @return string
     */
    public function methodName(string $httpMethod): string
    {
        return strtolower($httpMethod) . ucfirst(string: $this->method);
    }
}
