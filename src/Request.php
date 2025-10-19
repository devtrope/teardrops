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

        if ($this->method === 'POST') {
            $_SESSION['old'] = $this->parameters;
        }
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

    public function old(?string $key): array|string|null
    {
        if (! isset($_SESSION['old'])) {
            return null;
        }

        /** @var array $_SESSION['old'] */
        $oldData = $_SESSION['old'];

        if ($key === null) {
            unset($_SESSION['old']);
            return $oldData;
        }

        $oldValue = $_SESSION['old'][$key] ?? null;
        unset($_SESSION['old'][$key]);

        return $oldValue;
    }

    public function json(?string $key): array|string|null
    {
        $body = file_get_contents('php://input');

        if (! $body) {
            return null;
        }

        $jsonData = json_decode($body, true);

        if (! $jsonData) {
            return null;
        }

        if ($key === null) {
            /** @var array $jsonData */
            return $jsonData;
        }

        /** @var array $jsonData */
        return $jsonData[$key];
    }
}
