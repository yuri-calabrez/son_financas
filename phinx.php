<?php

require __DIR__.'/vendor/autoload.php';

if(file_exists('.env')) {
    $dotEnv = new \Dotenv\Dotenv(__DIR__);
    $dotEnv->overLoad();
}

$db = include __DIR__.'/config/db.php';

list(
    'driver' => $adapter,
    'host' => $host,
    'database' => $name,
    'username' => $user,
    'password' => $pass,
    'charset' => $charset,
    'collation' => $collation
    ) = $db['default_connection'];

return [
    'paths' => [
        'migrations' => [
            __DIR__.'/db/migrations',
        ],
        'seeds' => [
            __DIR__.'/db/seeds'
        ]
    ],
    'environments' => [
        'default_migration_table' => 'migrations',
        'default_database' => 'default_connection',
        'default_connection' => [
            'adapter' => $adapter,
            'host' => $host,
            'user' => $user,
            'name' => $name,
            'pass' => $pass,
            'charset' => $charset,
            'collation' => $collation
        ]
    ]
];