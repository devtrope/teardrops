<?php

define ('TEMPLATES_PATH', dirname(__DIR__) . '/templates');
define ('ROUTES_PATH', dirname(__DIR__) . '/web/routes.php');
define ('CACHE_PATH', dirname(__DIR__) . '/web/cache');

$environmentFile = __DIR__ . '/../.env';

if (! file_exists($environmentFile)) {
    throw new Exception('.env file is missing. Please create it based on the .env.example file.');
}

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

if ($_ENV['APP_ENVIRONMENT'] !== 'production') {
    if (! file_exists(ROUTES_PATH)) {
        throw new \Exception('Routes file not found at ' . ROUTES_PATH);
    }
    
    require ROUTES_PATH;
}

$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();