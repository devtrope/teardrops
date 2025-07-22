<?php

require __DIR__ . '/../vendor/autoload.php';

$envFile = \Teardrops\Teardrops\Config\Config::isDevelopment() ? '.env.local' : '.env';
$dotenv = \Dotenv\Dotenv::createImmutable(dirname(__DIR__), $envFile);
$dotenv->load();

\Teardrops\Teardrops\Http\Model::initialize();
\Teardrops\Teardrops\Config\Routing\Router::run($_SERVER['REQUEST_URI']);
