<?php

namespace Teardrops\Teardrops;

use Teardrops\Teardrops\Support\Config;
use Teardrops\Teardrops\Support\Events;
use Teardrops\Teardrops\Http\Request;
use Teardrops\Teardrops\Http\Router;
use Teardrops\Teardrops\Http\Route;
use Teardrops\Teardrops\Support\Debug;

class Kernel
{
    /**
     * Handles the incoming request and resolves the route.
     *
     * @param Request $request
     * @return void
     */
    public static function handle(Request $request): void
    {
        try {
            $route = new Route($request);

            Router::resolve(
                $route,
                $request->getHttpMethod(),
            );
        } catch (\Exception $e) {
            http_response_code($e->getCode());

            if (Config::get('DEBUG', false)) {
                Debug::renderException($e);
                exit;
            }

            Events::dispatch('page_not_found');
            exit;
        }
    }
}
