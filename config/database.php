<?php


$database = [
    'fetch' => PDO::FETCH_ASSOC,
    'default' => 'mysql',
    'migrations' => 'migrations',


    'connections' => [
        'default' => [
            'driver' => 'mysql',
            'host' => env('DB_HOST'),
            'port' => env('DB_PORT', 3306),
            'database' => env('DB_DATABASE'),
            'username' => env('DB_USERNAME'),
            'password' => env('DB_PASSWORD'),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => env('APP_NAME') . '_',
            'strict' => false,
        ],

        'mysql' => [
            'read' => [
                'host' => env('DB_HOST', '127.0.0.1'),
            ],
            'write' => [
                'host' => env('DB_HOST', '127.0.0.1')
            ],
            'sticky' => true,
            'driver' => 'mysql',
            'database' => env('DB_DATABASE'),
            'username' => env('DB_USERNAME'),
            'password' => env('DB_PASSWORD'),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => env('APP_NAME') . '_',
        ],
    ],

    'mysql' => [
        'read' => [
            'host' => env('DB_HOST', '127.0.0.1'),
        ],
        'write' => [
            'host' => env('DB_HOST', '127.0.0.1')
        ],
        'sticky' => true,
        'driver' => 'mysql',
        'database' => env('DB_DATABASE'),
        'username' => env('DB_USERNAME'),
        'password' => env('DB_PASSWORD'),
        'charset' => 'utf8mb4',
        'collation' => 'utf8mb4_unicode_ci',
        'prefix' => env('APP_NAME'),
    ],

    'redis' => [

        'client' => 'predis',

        'default' => [
            'host' => env('REDIS_HOST', 'localhost'),
            'password' => env('REDIS_PASSWORD', null),
            'port' => env('REDIS_PORT', 6379),
            'database' => 0,
        ],
        'ishare_cache' => [
            'host' => env('REDIS_HOST', 'localhost'),
            'password' => env('REDIS_PASSWORD', null),
            'port' => env('REDIS_PORT', 6379),
            'database' => 0,
        ],

    ],

    'mongodb' => [
        'log' => [
            'host' => env('MONGODB_HOST', 'mongodb://user:password@host/datebase'),
            'port' => env('MONGODB_PORT', 27017),
            'database' => env('MONGODB_DATABASE'),
        ],
    ],
];


return $database;
