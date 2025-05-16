<?php

namespace Teardrops\Teardrops\Http;

class Request
{
    private string $httpMethod;
    private string $uri;

    public function __construct()
    {
        $this->httpMethod = strval($_SERVER['REQUEST_METHOD']);
        $this->uri = strval($_SERVER['REQUEST_URI']);
    }

    public function getHttpMethod(): string
    {
        return $this->httpMethod;
    }

    public function getUri(): string
    {
        return $this->uri;
    }

    public function segments(): array
    {
        $parseUrl = parse_url($this->getUri(), PHP_URL_PATH);

        if (! is_string($parseUrl)) {
            return [];
        }

        return explode('/', trim($parseUrl, '/'));
    }
}