<?php

return [

    'supportedLocales' => [
        'id'          => ['name' => 'Indonesian',             'script' => 'Latn', 'native' => 'Bahasa Indonesia', 'regional' => 'id_ID'],
        'en'          => ['name' => 'English',                'script' => 'Latn', 'native' => 'English', 'regional' => 'en_GB'],
    ],

    'useAcceptLanguageHeader' => true,

    'hideDefaultLocaleInURL' => false,

    'localesOrder' => [],

    'localesMapping' => [],

    'utf8suffix' => env('LARAVELLOCALIZATION_UTF8SUFFIX', '.UTF-8'),

    'urlsIgnored' => [
        '/auth/*',  
    ],
    'httpMethodsIgnored' => ['POST', 'PUT', 'PATCH', 'DELETE'],
];
