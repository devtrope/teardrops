<?php

namespace Teardrops\Teardrops;

use Teardrops\Teardrops\Kernel;
use Teardrops\Teardrops\Http\Request;
use Dotenv\Dotenv;
use Teardrops\Teardrops\Support\Config;

class Application
{
    public static function setup(string $baseDir): static
    {
        $envFile = file_exists($baseDir . '/.env') ? '.env' :'.env.example';

        $dotenv = Dotenv::createImmutable($baseDir, $envFile);
        $dotenv->load();

        return new static();
    }

    public function run()
    {
        $kernel = new Kernel();
        $kernel->handle(new Request());
    }
}