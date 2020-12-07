<?php

use Illuminate\Support\Str;

return [

    /*
    |--------------------------------------------------------------------------
    | Default Database Connection Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the database connections below you wish
    | to use as your default connection for all database work. Of course
    | you may use many connections at once using the Database library.
    |
    */

    'default' => env('DB_CONNECTION', 'mongodb'),

    // Additional Connection schemas
    'administration_schema' => env('DB_ADMINISTRATION_CONNECTION', 'administration_schema'),
    'beneficiary_schema' => env('DB_BENEFICIARY_CONNECTION', 'beneficiary_schema'),
    'commission_schema' => env('DB_COMMISSION_CONNECTION', 'commission_schema'),
    'funds_schema' => env('DB_FUNDS_CONNECTION', 'funds_schema'),
    'kyc_schema' => env('DB_KYC_CONNECTION', 'kyc_schema'),
    'promotion_schema' => env('DB_PROMOTION_CONNECTION', 'promotion_schema'),
    'transaction_schema' => env('DB_TRANSACTION_CONNECTION', 'transaction_schema'),

    /*
    |--------------------------------------------------------------------------
    | Database Connections
    |--------------------------------------------------------------------------
    |
    | Here are each of the database connections setup for your application.
    | Of course, examples of configuring each database platform that is
    | supported by Laravel is shown below to make development simple.
    |
    |
    | All database work in Laravel is done through the PHP PDO facilities
    | so make sure you have the driver for your particular database of
    | choice installed on your machine before you begin development.
    |
    */

    'connections' => [

        'sqlite' => [
            'driver' => 'sqlite',
            'url' => env('DATABASE_URL'),
            'database' => env('DB_DATABASE', database_path('database.sqlite')),
            'prefix' => '',
            'foreign_key_constraints' => env('DB_FOREIGN_KEYS', true),
        ],

        'mysql' => [
            'driver' => 'mysql',
            'url' => env('DATABASE_URL'),
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '3306'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],

        'pgsql' => [
            'driver' => 'pgsql',
            'url' => env('DATABASE_URL'),
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '5432'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
            'schema' => 'public',
            'sslmode' => 'prefer',
        ],

        'sqlsrv' => [
            'driver' => 'sqlsrv',
            'url' => env('DATABASE_URL'),
            'host' => env('DB_HOST', 'localhost'),
            'port' => env('DB_PORT', '1433'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
        ],

        'mongodb' => [
            'driver' => 'mongodb',
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', 27017),
            'dsn' => env('DB_DSN'),
            'database' => env('DB_DATABASE', 'administration_schema'),
            'username' => env('DB_USERNAME', 'root'),
            'password' => env('DB_PASSWORD', 'root'),
            'options' => [
                'database' => 'admin'
            ],
            'driver_options' => [
                'connectTimeoutMS' => 10000,
                'retryWrites' => 'true',
                'w' => 'majority'
            ]
        ],

        'administration_schema' => [
            'driver' => 'mongodb',
            'url' => env('DATABASE_URL'),
            'host' => env('DB_ADMINISTRATION_HOST', '127.0.0.1'),
            'port' => env('DB_ADMINISTRATION_PORT', 27017),
            'database' => env('DB_ADMINISTRATION_DATABASE', 'administration_schema'),
            'username' => env('DB_ADMINISTRATION_USERNAME', 'root'),
            'password' => env('DB_ADMINISTRATION_PASSWORD', 'root'),
            'options' => [
                'database' => 'admin'
            ]
        ],

        'beneficiary_schema' => [
            'driver' => 'mongodb',
            'url' => env('DATABASE_URL'),
            'host' => env('DB_BENEFICIARY_HOST', '127.0.0.1'),
            'port' => env('DB_BENEFICIARY_PORT', 27017),
            'database' => env('DB_BENEFICIARY_DATABASE', 'beneficiary_schema'),
            'username' => env('DB_BENEFICIARY_USERNAME', 'root'),
            'password' => env('DB_BENEFICIARY_PASSWORD', 'root'),
            'options' => [
                'database' => 'admin'
            ]
        ],

        'commission_schema' => [
            'driver' => 'mongodb',
            'url' => env('DATABASE_URL'),
            'host' => env('DB_COMMISSION_HOST', '127.0.0.1'),
            'port' => env('DB_COMMISSION_PORT', 27017),
            'database' => env('DB_COMMISSION_DATABASE', 'commission_schema'),
            'username' => env('DB_COMMISSION_USERNAME', 'root'),
            'password' => env('DB_COMMISSION_PASSWORD', 'root'),
            'options' => [
                'database' => 'admin'
            ]
        ],

        'funds_schema' => [
            'driver' => 'mongodb',
            'url' => env('DATABASE_URL'),
            'host' => env('DB_FUNDS_HOST', '127.0.0.1'),
            'port' => env('DB_FUNDS_PORT', 27017),
            'database' => env('DB_FUNDS_DATABASE', 'funds_schema'),
            'username' => env('DB_FUNDS_USERNAME', 'root'),
            'password' => env('DB_FUNDS_PASSWORD', 'root'),
            'options' => [
                'database' => 'admin'
            ]
        ],

        'kyc_schema' => [
            'driver' => 'mongodb',
            'url' => env('DATABASE_URL'),
            'host' => env('DB_KYC_HOST', '127.0.0.1'),
            'port' => env('DB_KYC_PORT', 27017),
            'database' => env('DB_KYC_DATABASE', 'kyc_schema'),
            'username' => env('DB_KYC_USERNAME', 'root'),
            'password' => env('DB_KYC_PASSWORD', 'root'),
            'options' => [
                'database' => 'admin'
            ]
        ],

        'promotion_schema' => [
            'driver' => 'mongodb',
            'url' => env('DATABASE_URL'),
            'host' => env('DB_PROMOTION_HOST', '127.0.0.1'),
            'port' => env('DB_PROMOTION_PORT', 27017),
            'database' => env('DB_PROMOTION_DATABASE', 'promotion_schema'),
            'username' => env('DB_PROMOTION_USERNAME', 'root'),
            'password' => env('DB_PROMOTION_PASSWORD', 'root'),
            'options' => [
                'database' => 'admin'
            ]
        ],

        'transaction_schema' => [
            'driver' => 'mongodb',
            'url' => env('DATABASE_URL'),
            'host' => env('DB_TRANSACTION_HOST', '127.0.0.1'),
            'port' => env('DB_TRANSACTION_PORT', 27017),
            'database' => env('DB_TRANSACTION_DATABASE', 'transaction_schema'),
            'username' => env('DB_TRANSACTION_USERNAME', 'root'),
            'password' => env('DB_TRANSACTION_PASSWORD', 'root'),
            'options' => [
                'database' => 'admin'
            ]
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Migration Repository Table
    |--------------------------------------------------------------------------
    |
    | This table keeps track of all the migrations that have already run for
    | your application. Using this information, we can determine which of
    | the migrations on disk haven't actually been run in the database.
    |
    */

    'migrations' => 'migrations',

    /*
    |--------------------------------------------------------------------------
    | Redis Databases
    |--------------------------------------------------------------------------
    |
    | Redis is an open source, fast, and advanced key-value store that also
    | provides a richer body of commands than a typical key-value system
    | such as APC or Memcached. Laravel makes it easy to dig right in.
    |
    */

    'redis' => [

        'client' => env('REDIS_CLIENT', 'phpredis'),

        'options' => [
            'cluster' => env('REDIS_CLUSTER', 'redis'),
            'prefix' => env('REDIS_PREFIX', Str::slug(env('APP_NAME', 'laravel'), '_').'_database_'),
        ],

        'default' => [
            'url' => env('REDIS_URL'),
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'password' => env('REDIS_PASSWORD', null),
            'port' => env('REDIS_PORT', '6379'),
            'database' => env('REDIS_DB', '0'),
        ],

        'cache' => [
            'url' => env('REDIS_URL'),
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'password' => env('REDIS_PASSWORD', null),
            'port' => env('REDIS_PORT', '6379'),
            'database' => env('REDIS_CACHE_DB', '1'),
        ],

    ],

];
