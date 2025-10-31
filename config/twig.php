<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Template Caching
    |--------------------------------------------------------------------------
    |
    | When enabled, Twig compiles templates into PHP code and caches them
    | for better performance. Disable in development to see template changes
    | immediately without clearing cache.
    |
    | Recommended: false in development, true in production
    |
    */
    'cache' => $_ENV['TWIG_CACHE'],

    /*
    |--------------------------------------------------------------------------
    | Debug Mode
    |--------------------------------------------------------------------------
    |
    | When enabled, provides detailed error messages and enables the dump()
    | function in templates. Should always be disabled in production for
    | security and performance reasons.
    |
    | Recommended: true in development, false in production
    |
    */
    'debug' => $_ENV['APP_DEBUG'],

    /*
    |--------------------------------------------------------------------------
    | Auto Reload
    |--------------------------------------------------------------------------
    |
    | When enabled, Twig automatically recompiles templates when they are
    | modified. Useful in development but adds overhead in production.
    | If cache is disabled, this setting has no effect.
    |
    | Recommended: true in development, false in production
    |
    */
    'auto_reload' => $_ENV['TWIG_AUTO_RELOAD'],
    
    /*
    |--------------------------------------------------------------------------
    | Strict Variables
    |--------------------------------------------------------------------------
    |
    | When enabled, Twig throws an exception when accessing undefined variables
    | or attributes. Helps catch typos and missing data during development.
    | In production, it's safer to return null for undefined variables.
    |
    | Recommended: true in development, false in production
    |
    */
    'strict_variables' => $_ENV['TWIG_STRICT_VARIABLES'],

];