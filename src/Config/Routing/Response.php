<?php

namespace Teardrops\Teardrops\Config\Routing;

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

    public static function setBody(string $body): void
    {
        if (self::$sent) {
            throw new \RuntimeException('Response already sent, cannot modify body');
        }
        self::$body = $body;
    }

    public static function getBody(): string
    {
        return self::$body;
    }

    public static function setHeader(string $key, string $value): void
    {
        if (self::$sent) {
            throw new \RuntimeException('Response already sent, cannot modify headers');
        }
        self::$headers[strtolower($key)] = $value;
    }

    public static function getHeader(string $key): ?string
    {
        return self::$headers[strtolower($key)] ?? null;
    }

    public static function hasHeader(string $key): bool
    {
        return isset(self::$headers[strtolower($key)]);
    }

    public static function removeHeader(string $key): void
    {
        if (self::$sent) {
            throw new \RuntimeException('Response already sent, cannot modify headers');
        }
        unset(self::$headers[strtolower($key)]);
    }

    public function getHeaders(): array
    {
        return self::$headers;
    }

    public static function setStatusCode(int $code): void
    {
        if (self::$sent) {
            throw new \RuntimeException('Response already sent, cannot modify status code');
        }
        self::$statusCode = $code;
    }

    public static function getStatusCode(): int
    {
        return self::$statusCode;
    }

    public static function setContentType(string $contentType): void
    {
        self::setHeader('Content-Type', $contentType);
    }

    public static function json(array|object $data, int $statusCode = 200): void
    {
        self::setContentType('application/json; charset=UTF-8');
        self::setStatusCode($statusCode);
        self::setBody(json_encode($data, JSON_THROW_ON_ERROR));
    }

    public static function redirect(string $url, int $statusCode = 302): void
    {
        self::setStatusCode($statusCode);
        self::setHeader('Location', $url);
        self::send();
        exit();
    }

    public static function notFound(string $message = 'Not Found'): void
    {
        self::setStatusCode(404);
        self::setBody($message);
        self::send();
    }

    public static function serverError(string $message = 'Internal Server Error'): void
    {
        self::setStatusCode(500);
        self::setBody($message);
        self::send();
        exit();
    }

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

    public static function isSent(): bool
    {
        return self::$sent;
    }

    public static function reset(): void
    {
        self::$body = '';
        self::$headers = [];
        self::$statusCode = 200;
        self::$sent = false;
    }

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
