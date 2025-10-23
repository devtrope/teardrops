<?php

define ('TEMPLATES_PATH', dirname(__DIR__) . '/templates');
define ('ROUTES_PATH', dirname(__DIR__) . '/routes/routes.php');

if (! file_exists(ROUTES_PATH)) {
    throw new \Exception('Routes file not found at ' . ROUTES_PATH);
}

require ROUTES_PATH;