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
    private string $path;
    private array $segments;

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

        $this->parseURI();
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
     * Returns a specific header by name.
     *
     * @param string $name The name of the header to retrieve.
     * @return string|null The value of the header or null if not found.
     */
    public function getHeader(string $name): ?string
    {
        $name = ucwords(strtolower($name), '-');
        return $this->headers[$name] ?? null;
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
     * Returns a specific query parameter by key.
     *
     * @param string $key The key of the query parameter to retrieve.
     * @param string|null $default The default value to return if the key does not exist.
     * @return string|null The value of the query parameter or the default value if not found.
     */
    public function getQueryParam(string $key, ?string $default = null): string|null
    {
        if (array_key_exists($key, $this->query)) {
            return $this->query[$key];
        }

        return $default;
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
     * Returns a specific POST parameter by key.
     *
     * @param string $key The key of the POST parameter to retrieve.
     * @param string|null $default The default value to return if the key does not exist.
     * @return string|null The value of the POST parameter or the default value if not found.
     */
    public function getPostParam(string $key, ?string $default = null): string|null
    {
        if (array_key_exists($key, $this->post)) {
            return $this->post[$key];
        }

        return $default;
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
     * Returns the path extracted from the request URI.
     *
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * Returns the segments extracted from the request URI.
     *
     * @return array
     */
    public function getSegments(): array
    {
        return $this->segments;
    }

    /*     
     * Returns a specific segment from the request URI by index.
     *
     * @param int $index The index of the segment to retrieve.
     * @param string|null $default The default value to return if the segment does not exist.
     * @return string|null The segment value or the default value if not found.
     */
    public function getSegment(int $index, ?string $default = null): string|null
    {
        if (isset($this->segments[$index])) {
            return $this->segments[$index];
        }

        return $default;
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

    /**
     * Parses the request URI to extract the path and parameters.
     */
    private function parseURI(): void
    {
        $this->path = parse_url($this->uri, PHP_URL_PATH) ?? '/';
        
        $cleanPath = trim($this->path, '/');
        $this->segments = $cleanPath === '' ? [] : explode('/', $cleanPath);
    }
}
