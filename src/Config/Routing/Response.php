<?php

namespace Teardrops\Teardrops\Config\Routing;

class Response extends Routing
{
    private static string $body;
    private static array $headers = [];
    private static bool $sent = false;

    public static function setBody(string $body): void
    {
        self::$body = $body;
    }

    public static function getBody(): string
    {
        return self::$body;
    }

    public static function setHeader(string $key, string $value): void
    {
        self::$headers[$key] = $value;
    }

    public static function getHeader(string $key): ?string
    {
        return self::$headers[$key] ?? null;
    }

    public static function send(): void
    {
        if (self::$sent) {
            return;
        }

        foreach (self::$headers as $key => $value) {
            header("{$key}: {$value}");
        }

        echo self::getBody();
        self::$sent = true;
    }
}
