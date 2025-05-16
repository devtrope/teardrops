<?php

namespace Teardrops\Teardrops;

use Teardrops\Teardrops\Support\Events;
use Teardrops\Teardrops\Kernel;
use Teardrops\Teardrops\Http\Request;
use Dotenv\Dotenv;

class Application
{
    /**
     * Adds the environment variables to the application.
     *
     * @param string $baseDir
     * @return Application
     */
    public static function setup(string $baseDir): Application
    {
        $envFile = file_exists($baseDir . '/.env') ? '.env' : '.env.example';

        $dotenv = Dotenv::createImmutable($baseDir, $envFile);
        $dotenv->load();

        return new Application();
    }

    /**
     * Runs the application.
     *
     * @return void
     */
    public function run(): void
    {
        Events::register('page_not_found', function (): void {
            $controller = new \App\Http\Controllers\Controller();
            $controller->notFound();
        });

        Kernel::handle(new Request());
    }
}
