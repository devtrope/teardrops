<?php

namespace Teardrops\Teardrops\View;

use Teardrops\Teardrops\Application;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class ViewRenderer
{
    private Environment $twig;

    public function __construct()
    {
        $loader = new FilesystemLoader(Application::baseDir() . '/resources/views');
        $this->twig = new Environment($loader, [
            'cache' => Application::baseDir() . '/storage/cache',
            'debug' => true,
        ]);
    }

    /**
     * Renders a view template with the given data.
     *
     * @param string $template
     * @param array $data
     * @return string
     */
    public function render(string $template, array $data = []): string
    {
        return $this->twig->render($template, $data);
    }
}
