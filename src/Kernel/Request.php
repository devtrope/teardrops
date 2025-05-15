<?php

namespace Teardrops\Teardrops\Kernel;

class Request
{
    private string $method;
    private string $uri;

    public function __construct()
    {
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->uri = $_SERVER['REQUEST_URI'];
    }

    public function getMethod(): string
    {
        return strtolower($this->method);
    }

    public function getUri(): string
    {
        return $this->uri;
    }
}