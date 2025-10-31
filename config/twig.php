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
    'cache' => env('TWIG_CACHE', false),

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
    'debug' => env('APP_DEBUG', true),

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
    'auto_reload' => env('TWIG_AUTO_RELOAD', true),
    
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
    'strict_variables' => env('TWIG_STRICT_VARIABLES', true),

];