<?php

return [

    /*
    |--------------------------------------------------------------------------
    | The environment of the application (development or production). Set in the
    | .env file.
    |--------------------------------------------------------------------------
    */
    'environment' => env('APP_ENVIRONMENT', 'production'),

    /*
    |--------------------------------------------------------------------------
    | The 'locale' element holds the application's default locale
    | (language and regional variant).
    | This value is used by translation/ i18n systems, date/number formatting,
    | and locale-aware libraries (Intl, strftime/setlocale, Carbon, etc.).
    | Typical formats: en, en_US, fr, fr_FR.
    |--------------------------------------------------------------------------
    */
    'locale' => env('APP_LOCALE', 'en'),
    
    /*
    |--------------------------------------------------------------------------
    | The base URL of the application.
    |--------------------------------------------------------------------------
    */
    'url' => env('APP_URL', 'http://localhost'),
    
    /*
    |--------------------------------------------------------------------------
    | The name of the application.
    |--------------------------------------------------------------------------
    */
    'name' => env('APP_NAME', 'Ludens'),

];