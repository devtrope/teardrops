<?php

namespace Teardrops\Teardrops;

use Teardrops\Teardrops\Http\Request;
use Teardrops\Teardrops\Http\Router;
use Teardrops\Teardrops\Http\Route;
use Teardrops\Teardrops\Support\Events;

class Kernel
{
    public static function handle(Request $request): void
    {
        try {
            $route = new Route($request);

            Router::resolve(
                $route,
                $request->getHttpMethod(),
            );
        } catch (\Exception $e) {
            http_response_code(404);
            Events::dispatch('page_not_found');
            exit;
        }
    }
}
