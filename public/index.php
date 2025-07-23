<?php

use Teardrops\Teardrops\Config\Routing\Response;

require __DIR__ . '/../vendor/autoload.php';

$envFile = \Teardrops\Teardrops\Config\Config::isDevelopment() ? '.env.local' : '.env';
$envPath = dirname(__DIR__) . '/' . $envFile;

if (! is_file($envPath)) {
    Response::serverError("No .env file found in {$envPath}");
}

$dotenv = \Dotenv\Dotenv::createImmutable(dirname(__DIR__), $envFile);
$dotenv->load();

//\Teardrops\Teardrops\Http\Model::initialize();
$router = new \Teardrops\Teardrops\Config\Routing\Router();
$router->run();
