<?php

namespace Teardrops\Teardrops;

use Teardrops\Teardrops\Support\Config;
use Teardrops\Teardrops\Support\Events;
use Teardrops\Teardrops\Http\Request;
use Teardrops\Teardrops\Http\Router;
use Teardrops\Teardrops\Http\Route;

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

            if (Config::get('DEBUG', false)) {
                print_r('<pre>');
                print_r($e->getMessage());
                print_r($e->getTraceAsString());
                print_r('</pre>');
            }

            Events::dispatch('page_not_found');
            exit;
        }
    }
}
