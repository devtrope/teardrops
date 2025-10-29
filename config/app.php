<?php

return [

    /*
    |--------------------------------------------------------------------------
    | The environment of the application (development or production). Set in the
    | .env file.
    |--------------------------------------------------------------------------
    */
    'environment' => $_ENV['APP_ENVIRONMENT'],

    /*
    |--------------------------------------------------------------------------
    | The 'locale' element holds the application's default locale
    | (language and regional variant).
    | This value is used by translation/ i18n systems, date/number formatting,
    | and locale-aware libraries (Intl, strftime/setlocale, Carbon, etc.).
    | Typical formats: en, en_US, fr, fr_FR.
    |--------------------------------------------------------------------------
    */
    'locale' => $_ENV['APP_LOCALE'],
    
];