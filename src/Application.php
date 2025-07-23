<?php

namespace Teardrops\Teardrops;

class Application
{
    public function setup(): void
    {
        $envFile = \Teardrops\Teardrops\Config\Config::isDevelopment() ? '.env.local' : '.env';
        $envPath = dirname(__DIR__) . '/' . $envFile;

        if (! is_file($envPath)) {
            \Teardrops\Teardrops\Config\Routing\Response::serverError("No .env file found in {$envPath}");
        }

        $dotenv = \Dotenv\Dotenv::createImmutable(dirname(__DIR__), $envFile);
        $dotenv->load();

        //\Teardrops\Teardrops\Http\Model::initialize();
        $router = new \Teardrops\Teardrops\Config\Routing\Router();
        $router->run();
    }
}
