<?php

namespace Teardrops\Teardrops;

class Request
{
    private string $uri;
    private string $method;
    private array $parameters = [];

    public function __construct()
    {
        $this->uri = strval($_SERVER['REQUEST_URI']);
        $this->method = strval($_SERVER['REQUEST_METHOD']);
        $this->parameters = $_REQUEST;
    }

    public function uri(): string
    {
        return $this->uri;
    }

    public function method(): string
    {
        return $this->method;
    }

    public function parameter(?string $key): array|string|null
    {
        if ($key === null) {
            return $this->parameters;
        }

        return $this->parameters[$key] ?? [];
    }

    public function json(): array
    {
        $body = file_get_contents('php://input');
        return json_decode($body, true) ?? [];
    }
}
