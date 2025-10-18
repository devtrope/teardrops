<?php

namespace Teardrops\Teardrops;

class Response
{
    private string $body;
    private array $headers = [];

    public static function render(string $viewName, array $data = []): self
    {
        $filePath = __DIR__ . '/../templates/' . $viewName . '.php';

        if (! file_exists($filePath)) {
            throw new \Exception("View file $viewName does not exist");
        }

        ob_start();
        extract($data, EXTR_SKIP);
        include $filePath;
        $content = ob_get_clean();

        if (! $content) {
            $content = '';
        }

        $response = new self();
        $response->setBody($content);
        $response->setHeader('Content-Type', 'text/html; charset=UTF-8');
        
        return $response;
    }

    public function send(): void
    {
        echo $this->body;
    }

    private function setBody(string $content): void
    {
        $this->body = $content;
    }

    public function body(): string
    {
        return $this->body;
    }

    private function setHeader(string $name, string $value): void
    {
        $this->headers[$name] = $value;
    }

    public function header(?string $key): string|array|null
    {
        if ($key === null) {
            return $this->headers;
        }

        return $this->headers[$key] ?? null;
    }
}
