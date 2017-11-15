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
    'enable_locale_append' => true,

    /*
    |--------------------------------------------------------------------------
    | Multilingual Setup : Define the default locale
    |--------------------------------------------------------------------------
    |
    | This is where you would define your default locale.
    | By default, all laravel app will use 'en' as the
    | default value but you can override that here.
    |
    */
    'default_locale' => 'en',

    /*
    |--------------------------------------------------------------------------
    | Multilingual Setup : Hiding the default locale
    |--------------------------------------------------------------------------
    |
    | When the routable middleware is used, all generated
    | urls will have the locale appended to them. When
    | this is set to true, the default locale will
    | be kept hidden from the generated urls.
    |
    */
    'hide_default_locale' => true,

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
