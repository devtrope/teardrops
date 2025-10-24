<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require __DIR__ . '/../vendor/autoload.php';

$environmentFile = __DIR__ . '/../.env';

if (! file_exists($environmentFile)) {
    throw new Exception('.env file is missing. Please create it based on the .env.example file.');
}

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

require __DIR__ . '/../src/helpers.php';
require __DIR__ . '/bootstrap.php';

\Ludens\Core\Application::init(new Ludens\Http\Request());