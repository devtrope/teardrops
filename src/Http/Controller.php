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

    protected function render(string $view): bool
    {
        if ($this->isRendered) {
            return false;
        }

        Response::setBody(
            $this->loadTwig()->render($view, $this->content)
        );
        Response::send();
        $this->isRendered = true;
        return true;
    }

    protected static function redirect(string $uri): void
    {
        header("Location:{$uri}");
        exit(301);
    }
}
