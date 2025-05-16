<?php

namespace Teardrops\Teardrops;

use Teardrops\Teardrops\Kernel;
use Teardrops\Teardrops\Http\Request;
use Dotenv\Dotenv;

class Application
{
    public static function setup(string $baseDir): Application
    {
        $envFile = file_exists($baseDir . '/.env') ? '.env' :'.env.example';

        $dotenv = Dotenv::createImmutable($baseDir, $envFile);
        $dotenv->load();

        return new Application();
    }

    public function run(): void
    {
        Kernel::handle(new Request());
    }
}