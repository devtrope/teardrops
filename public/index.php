<?php

require __DIR__ . '/../vendor/autoload.php';

$envFile = \Teardrops\Teardrops\Config\Config::isDevelopment() ? '.env.local' : '.env';
$dotenv = \Dotenv\Dotenv::createImmutable(dirname(__DIR__), $envFile);
$dotenv->load();

$request = new \Teardrops\Teardrops\Config\Routing\HttpRequest();
var_dump($request->getServer());
var_dump($request->getHeaders());
var_dump($request->getBody());
var_dump($request->getFiles());
var_dump($request->getMethod());
var_dump($request->getQuery());
die();

\Teardrops\Teardrops\Http\Model::initialize();
\Teardrops\Teardrops\Config\Routing\Router::run($_SERVER['REQUEST_URI']);
