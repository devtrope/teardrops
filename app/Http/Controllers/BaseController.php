<?php

namespace App\Http\Controllers;

use Teardrops\Teardrops\Http\Response;
use Teardrops\Teardrops\View\ViewRenderer;

abstract class BaseController
{
    protected ViewRenderer $view;

    public function __construct(ViewRenderer $view)
    {
        $this->view = $view;
    }

    /**
     * Renders a view template with the given data and returns a Response object.
     *
     * @param string $template
     * @param array $data
     * @return Response
     */
    protected function render(string $template, array $data = []): Response
    {
        $html = $this->view->render($template, $data);
        return new Response($html);
    }

    /**
     * Returns a JSON response with the given data and status code.
     *
     * @param array $data
     * @param int $statusCode
     * @return Response
     */
    protected function json(array $data, int $statusCode = 200): Response
    {
        $json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

        return (new Response($json, $statusCode))
            ->withHeader('Content-Type', 'application/json');
    }
}
