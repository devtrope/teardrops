<?php

require __DIR__ . '/../vendor/autoload.php';

\Teardrops\Teardrops\Http\Model::initialize();
\Teardrops\Teardrops\Config\Routing\Router::run($_SERVER['REQUEST_URI']);