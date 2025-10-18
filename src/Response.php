<?php

namespace Teardrops\Teardrops;

class Response
{
    private string $body;

    public function __construct(string $body)
    {
        $this->body = $body;
    }

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

        return new self($content);
    }

    public function send(): void
    {
        echo $this->body;
    }
}
