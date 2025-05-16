<?php

namespace Teardrops\Teardrops;

use Teardrops\Teardrops\Kernel;
use Teardrops\Teardrops\Http\Request;

class Application
{
    public static function setup(): static
    {
        // TODO: Load environment variables
        return new static();
    }

    public function run()
    {
        $kernel = new Kernel();
        $kernel->handle(new Request());
    }
}