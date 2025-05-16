<?php

namespace Teardrops\Teardrops;

use Teardrops\Teardrops\Support\Events;
use Teardrops\Teardrops\Kernel;
use Teardrops\Teardrops\Http\Request;
use Dotenv\Dotenv;

class Application
{
    private static string $baseDir;

    /**
     * Adds the environment variables to the application.
     *
     * @param string $baseDir
     * @return Application
     */
    public static function setup(string $baseDir): Application
    {
        self::$baseDir = $baseDir;
        $envFile = file_exists($baseDir . '/.env') ? '.env' : '.env.example';

        $dotenv = Dotenv::createImmutable($baseDir, $envFile);
        $dotenv->load();

        return new Application();
    }

    /**
     * Returns the base directory of the application.
     *
     * @return string
     */
    public static function baseDir(): string
    {
        return self::$baseDir;
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
