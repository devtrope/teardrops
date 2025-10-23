<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../src/helpers.php';
require __DIR__ . '/bootstrap.php';

Teardrops\Teardrops\Kernel::init(new Ludens\Http\Request());