<?php

namespace Teardrops\Teardrops\Config\Routing;

/**
 * This class captures and provides access to various superglobal arrays
 * such as $_SERVER, $_REQUEST, $_GET, $_POST, and $_FILES.
 * 
 * @package Teardrops\Teardrops\Config\Routing
 * @version 1.0
 * @author Quentin SCHIFFERLE <dev.trope@gmail.com>
 */
class HttpRequest
{
    private array $server;
    private array $headers;
    private string $body;
    private array $files;
    private string $method;
    private array $query;
    private array $post;
    private string $uri;

    public function __construct()
    {
        $this->server = $_SERVER ?? [];
        $this->headers = $this->extractHeaders();
        $this->body = $this->extractBody();
        $this->files = $_FILES ?? [];
        $this->method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        $this->query = $_GET ?? $_REQUEST ?? [];
        $this->post = $_POST ?? [];
        $this->uri = $_SERVER['REQUEST_URI'] ?? '';
    }

    /**
     * Returns the $_SERVER superglobal array.
     *
     * @return array
     */
    public function getServer(): array
    {
        return $this->server;
    }

    /**
     * Returns the headers extracted from the $_SERVER superglobal.
     *
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * Returns the body content of the request.
     *
     * @return string
     */
    public function getBody(): string
    {
        return $this->body;
    }

    /**
     * Returns the $_FILES superglobal array.
     *
     * @return array
     */
    public function getFiles(): array
    {
        return $this->files;
    }

    /**
     * Returns the HTTP method of the request.
     *
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * Returns the $_GET superglobal array.
     *
     * @return array
     */
    public function getQuery(): array
    {
        return $this->query;
    }

    /**
     * Returns the $_POST superglobal array.
     *
     * @return array
     */
    public function getPost(): array
    {
        return $this->post;
    }

    /**
     * Returns the request URI.
     *
     * @return string
     */
    public function getUri(): string
    {
        return $this->uri;
    }

    /**
     * Extracts headers from the $_SERVER superglobal.
     *
     * @return array
     */
    private function extractHeaders(): array
    {
        $headers = [];

        foreach ($this->server as $key => $value) {
            if (str_starts_with($key, 'HTTP_')) {
                $headerName = str_replace('_', '-', strtolower(substr($key, 5)));
                $headerName = ucwords(strtolower($headerName), '-');
                $headers[$headerName] = $value;
            }
        }

        // Handle content-type and content-length specifically
        if (isset($this->server['CONTENT_TYPE'])) {
            $headers['Content-Type'] = $this->server['CONTENT_TYPE'];
        }

        if (isset($this->server['CONTENT_LENGTH'])) {
            $headers['Content-Length'] = $this->server['CONTENT_LENGTH'];
        }

        return $headers;
    }

    /**
     * Extracts the body content from the request.
     *
     * @return string
     */
    private function extractBody(): string
    {
        return file_get_contents('php://input') ?: '';
    }
}
