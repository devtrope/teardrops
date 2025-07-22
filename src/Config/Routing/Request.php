<?php

namespace Teardrops\Teardrops\Config\Routing;

class Request extends Routing
{
    private array $uri;

    public function __construct(string $uri)
    {
        $this->parseURI($uri);
    }

    private function parseURI(string $uri): void
    {
        $cleanedURI = trim($uri, '/');
        $this->uri = explode('/', $cleanedURI);
        $this->controller = ! empty($this->uri[0]) ? $this->uri[0] : null;

        if (isset($this->uri[1]) && ! empty($this->uri[1])) {
            $this->method = $this->uri[1];
        }

        $i = 2;
        if (isset($this->uri[$i]) && ! empty($this->uri[$i])) {
            for ($i; $i < sizeof($this->uri); $i++) {
                $this->params[] = $this->uri[$i];
            }
        }

        $this->controller = $this->controller !== null ? $this->formatController($this->controller) : $this->controller;
        $this->method = $this->formatMethod($_SERVER['REQUEST_METHOD'], $this->method);
    }

    private function formatController(string $controller): string
    {
        $controller = ucfirst($controller);

        if (stripos($controller, '_') !== false) {
            $controller = ucwords($controller, '_');
            $controller = str_replace('_', '', $controller);
        }

        return $controller . 'Controller';
    }

    private function formatMethod(string $requestMethod, string $method): string
    {
        if (stripos($method, '_') !== false) {
            $method = ucwords($method, '_');
            $method = str_replace('_', '', $method);
        }

        return strtolower($requestMethod) . ucfirst($method);
    }
}
