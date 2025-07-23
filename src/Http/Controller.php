<?php

namespace Teardrops\Teardrops\Http;

use Teardrops\Teardrops\Config\Routing\Response;

class Controller
{
    private array $content = [];
    private bool $isRendered = false;
    private ?\Twig\Environment $twig = null;

    protected function loadTwig(): \Twig\Environment
    {
        if ($this->twig === null) {
            $loader = new \Twig\Loader\FilesystemLoader(dirname(__DIR__, 2) . '/templates');
            $this->twig = new \Twig\Environment($loader, [
                'cache' => false,
                'debug' => \Teardrops\Teardrops\Config\Config::isDevelopment(),
            ]);
        }

        return $this->twig;
    }

    protected function set(string $key, mixed $value): void
    {
        $this->content[$key] = $value;
    }

    protected function render(string $view, int $statusCode = 200): bool
    {
        if ($this->isRendered) {
            return false;
        }

        try {
            Response::setStatusCode($statusCode);
            Response::setContentType('text/html; charset=UTF-8');
            Response::setBody(
                $this->loadTwig()->render($view, $this->content)
            );
            Response::send();
            $this->isRendered = true;
            return true;
        } catch (\Exception $e) {
            Response::serverError('Template rendering error: ' . $e->getMessage());
            return false;
        }
    }

    protected function renderJson(array|object $data, int $statusCode = 200): bool
    {
        if ($this->isRendered) {
            return false;
        }

        try {
            Response::json($data, $statusCode);
            $this->isRendered = true;
            return true;
        } catch (\Exception $e) {
            Response::serverError('JSON encoding error: ' . $e->getMessage());
            return false;
        }
    }

    protected static function redirect(string $uri, int $statusCode = 302): void
    {
        Response::redirect($uri, $statusCode);
    }

    protected function notFound(string $message = 'Page not found'): void
    {
        if (! $this->isRendered) {
            Response::notFound($message);
            $this->isRendered = true;
        }
    }
}
