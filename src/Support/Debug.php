<?php

namespace Teardrops\Teardrops\Support;

class Debug
{
    /**
     * Renders an exception message.
     *
     * @param \Throwable $exception
     * @return void
     */
    public static function renderException(\Throwable $exception): void
    {
        $code = $exception->getCode();
        $httpCode = ($code >= 100 && $code < 600) ? $code : http_response_code(); // Use valid HTTP code or fallback
        $class = (new \ReflectionClass($exception))->getShortName();

        echo "<!DOCTYPE html><html lang='en'><head><meta charset='UTF-8'>";
        echo "<title>Error {$httpCode}</title></head><body ";
        echo "style='font-family:\"Segoe UI\", sans-serif;background:#f2f2f2;padding:20px;'>";

        echo "<h1 style='color:#b30000;'>HTTP {$httpCode} - {$class}</h1>";
        echo "<h2 style='margin-top:0;color:#333;'>Message:</h2>";
        echo "<p style='background:#fff;padding:10px;border:1px solid #ccc;color:#000;'>";
        echo htmlspecialchars($exception->getMessage());
        echo "</p>";

        echo "<h2 style='margin-top:20px;color:#333;'>Trace:</h2>";
        echo "<pre style='background:#fff;padding:10px;border:1px solid #ccc;color:#000;'>";
        echo htmlspecialchars($exception->getTraceAsString());
        echo "</pre>";

        echo "</body></html>";
    }
}
