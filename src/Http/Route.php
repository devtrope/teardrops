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

    public function controller(): string
    {
        return $this->controller;
    }

    public function method(): string
    {
        return $this->method;
    }

    public function parameters(): array
    {
        return $this->parameters;
    }

    public function methodName(string $httpMethod): string
    {
        return strtolower($httpMethod) . ucfirst(string: $this->method);
    }
}
