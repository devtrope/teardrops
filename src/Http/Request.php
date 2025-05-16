<?php

namespace Teardrops\Teardrops\Http;

class Request
{
    private string $httpMethod;
    private string $uri;

    public function __construct()
    {
        $this->httpMethod = $_SERVER['REQUEST_METHOD'];
        $this->uri = $_SERVER['REQUEST_URI'];
    }

    public function getHttpMethod(): string
    {
        return strtolower($this->httpMethod);
    }

    public function getUri(): string
    {
        return $this->uri;
    }

    public function segments(): array
    {
        return explode('/', trim(parse_url($this->getUri(), PHP_URL_PATH), '/'));
    }
}