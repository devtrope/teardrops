<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../src/helpers.php';
require __DIR__ . '/bootstrap.php';

$app = new \Ludens\Core\Application();

$app->withPaths(
        templates: dirname(__DIR__) . '/templates',
        routes: dirname(__DIR__) . '/web/routes.php',
        cache: dirname(__DIR__) . '/web/cache'
    )
    ->init(new Ludens\Http\Request());