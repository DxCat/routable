<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Database name
    |--------------------------------------------------------------------------
    |
    | If you dont really want to use the default database name
    | which is 'routes', you can define your preferred name
    | here, just make sure you have set the database up.
    |
    */
    'database' => 'routes',

    /*
    |--------------------------------------------------------------------------
    | Multilingual Setup : Enable the local append and filter
    |--------------------------------------------------------------------------
    |
    | If you want to setup multilingual routing for your project,
    | Set this option to true. This will hide the first locale
    | that was found from the request url before passing it
    | back to the application and thing would just work!
    |
    */
    'enable_locale_append' => false,

    /*
    |--------------------------------------------------------------------------
    | Multilingual Setup : Enabled locales
    |--------------------------------------------------------------------------
    |
    | This is where the you should define the locales that your
    | application would be supporting. When any locales that
    | are defined here matches a segment of the requested
    | url, the first one would be hidden from the app.
    |
    */
    'enabled_locales' => ['en', 'fr'],
];
