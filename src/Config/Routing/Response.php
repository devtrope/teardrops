<?php

namespace Teardrops\Teardrops\Config\Routing;

/**
 * Handles the HTTP response sent to the client.
 * 
 * @package Teardrops\Teardrops\Config\Routing
 * @version 1.0
 * @author Quentin SCHIFFERLE <dev.trope@gmail.com>
 */
class Response
{
    private static string $body;
    private static array $headers = [];
    private static bool $sent = false;
    private static int $statusCode = 200;
    private static array $statusText = [
        200 => 'OK',
        201 => 'Created',
        204 => 'No Content',
        301 => 'Moved Permanently',
        302 => 'Found',
        400 => 'Bad Request',
        401 => 'Unauthorized',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        500 => 'Internal Server Error',
        502 => 'Bad Gateway',
        503 => 'Service Unavailable'
    ];

    /**
     * Sets the response body content.
     *
     * @param string $body
     * @throws \RuntimeException
     * @return void
     */
    public static function setBody(string $body): void
    {
        if (self::$sent) {
            throw new \RuntimeException('Response already sent, cannot modify body');
        }
        self::$body = $body;
    }

    /**
     * Gets the current response body content.
     *
     * @return string
     */
    public static function getBody(): string
    {
        return self::$body;
    }

    /**
     * Sets a specific HTTP header for the response.
     *
     * @param string $key
     * @param string $value
     * @throws \RuntimeException
     * @return void
     */
    public static function setHeader(string $key, string $value): void
    {
        if (self::$sent) {
            throw new \RuntimeException('Response already sent, cannot modify headers');
        }
        self::$headers[strtolower($key)] = $value;
    }

    /**
     * Returns a specific response header by name.
     *
     * @param string $key
     */
    public static function getHeader(string $key): ?string
    {
        return self::$headers[strtolower($key)] ?? null;
    }

    /**
     * Checks if a specific header is set.
     *
     * @param string $key
     * @return bool
     */
    public static function hasHeader(string $key): bool
    {
        return isset(self::$headers[strtolower($key)]);
    }

    /**
     * Removes a specific header from the response.
     *
     * @param string $key
     * @throws \RuntimeException
     * @return void
     */
    public static function removeHeader(string $key): void
    {
        if (self::$sent) {
            throw new \RuntimeException('Response already sent, cannot modify headers');
        }
        unset(self::$headers[strtolower($key)]);
    }

    /**
     * Gets all headers currently set for the response.
     *
     * @return array
     */
    public function getHeaders(): array
    {
        return self::$headers;
    }

    /**
     * Sets the HTTP status code for the response.
     *
     * @param int $code
     * @throws \RuntimeException
     * @return void
     */
    public static function setStatusCode(int $code): void
    {
        if (self::$sent) {
            throw new \RuntimeException('Response already sent, cannot modify status code');
        }
        self::$statusCode = $code;
    }

    /**
     * Gets the current HTTP status code.
     *
     * @return int
     */
    public static function getStatusCode(): int
    {
        return self::$statusCode;
    }

    /**
     * Sets the Content-Type header of the response.
     *
     * @param string $contentType
     * @return void
     */
    public static function setContentType(string $contentType): void
    {
        self::setHeader('Content-Type', $contentType);
    }

    /**
     * Sends a JSON response to the client.
     *
     * @param array|object $data
     * @param int $statusCode
     * @return void
     */
    public static function json(array|object $data, int $statusCode = 200): void
    {
        self::setContentType('application/json; charset=UTF-8');
        self::setStatusCode($statusCode);
        self::setBody(json_encode($data, JSON_THROW_ON_ERROR));
    }

    /**
     * Redirects the client to a specified URL
     *
     * @param string $url
     * @param int $statusCode
     * @return never
     */
    public static function redirect(string $url, int $statusCode = 302): void
    {
        self::setStatusCode($statusCode);
        self::setHeader('Location', $url);
        self::send();
        exit();
    }

    /**
     * Sends a 404 Not Found response with a custom message.
     *
     * @param string $message
     * @return void
     */
    public static function notFound(string $message = 'Not Found'): void
    {
        self::setStatusCode(404);
        self::setBody($message);
        self::send();
    }

    /**
     * Sends a 500 Internal Server Error response and exits.
     *
     * @param string $message
     * @return never
     */
    public static function serverError(string $message = 'Internal Server Error'): void
    {
        self::setStatusCode(500);
        self::setBody($message);
        self::send();
        exit();
    }

    /**
     * Sends the response headers and body to the client.
     *
     * @throws \RuntimeException
     * @return void
     */
    public static function send(): void
    {
        if (self::$sent) {
            return;
        }

        if (headers_sent()) {
            throw new \RuntimeException('Headers already sent');
        }

        $statusText = self::$statusText[self::$statusCode] ?? 'Unknown Status';
        http_response_code(self::$statusCode);

        foreach (self::$headers as $key => $value) {
            header("{$key}: {$value}");
        }

        echo self::getBody();

        self::$sent = true;
    }

    /**
     * Indicates whether the response has already been sent.
     *
     * @return bool
     */
    public static function isSent(): bool
    {
        return self::$sent;
    }

    /**
     * Resets the response state to default values.
     *
     * @return void
     */
    public static function reset(): void
    {
        self::$body = '';
        self::$headers = [];
        self::$statusCode = 200;
        self::$sent = false;
    }

    /**
     * Forces a file download by sending appropriate headers.
     *
     * @param string $filePath
     * @param mixed $filename
     * @return void
     */
    public static function download(string $filePath, ?string $filename = null): void
    {
        if (! file_exists($filePath)) {
            self::notFound('File not found');
            return;
        }

        $filename = $filename ?? basename($filePath);
        $mimeType = mime_content_type($filePath) ?? 'application/octet-stream';

        self::setHeader('content-type', $mimeType);
        self::setHeader('content-disposition', 'attachment; filename="' . $filename . '"');
        self::setHeader('content-length', (string)filesize($filePath));

        self::send();

        readfile($filePath);
        exit();
    }
}
