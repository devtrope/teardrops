<?php

namespace Teardrops\Teardrops;

class Kernel
{
    public static function init(\Ludens\Http\Request $request)
    {
        \Ludens\Routing\Router::dispatch($request);
    }
}