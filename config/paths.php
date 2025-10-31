<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Base Path
    |--------------------------------------------------------------------------
    |
    | The root directory of your application. All other paths are relative
    | to this base path. This is typically the parent directory of the
    | 'public' folder.
    |
    */
    'base'      => dirname(__DIR__),

    /*
    |--------------------------------------------------------------------------
    | Public Path
    |--------------------------------------------------------------------------
    |
    | The publicly accessible directory containing the index.php entry point
    | and static assets (CSS, JavaScript, images). This is the web server's
    | document root.
    |
    */
    'public'    => dirname(__DIR__) . '/public',

    /*
    |--------------------------------------------------------------------------
    | Cache Path
    |--------------------------------------------------------------------------
    |
    | Directory where the framework stores compiled views, cached routes,
    | and other temporary cached data. This directory should be writable
    | by the web server.
    |
    */
    'cache'     => dirname(__DIR__) . '/var/cache',

    /*
    |--------------------------------------------------------------------------
    | Configuration Path
    |--------------------------------------------------------------------------
    |
    | Directory containing all application configuration files. The framework
    | automatically loads all PHP files from this directory during bootstrap.
    |
    */
    'config'    => dirname(__DIR__) . '/config',

    /*
    |--------------------------------------------------------------------------
    | Routes Path
    |--------------------------------------------------------------------------
    |
    | Path to the main routes definition file where you register all
    | application routes and their corresponding controllers.
    |
    */
    'routes'    => dirname(__DIR__) . '/routes/web.php',

    /*
    |--------------------------------------------------------------------------
    | Templates Path
    |--------------------------------------------------------------------------
    |
    | Directory containing Twig template files. This is where you store
    | all your view files (.twig) for rendering HTML responses.
    |
    */
    'templates' => dirname(__DIR__) . '/templates',

];