<?php
/**
 * Jingga
 *
 * PHP Version 8.2
 *
 * @package   Jingga
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.2
 * @version   1.0.0
 * @link      https://jingga.app
 *
 * THIS FILE HAS TO BE MODIFIED BY THE ADMIN BEFORE THE INSTALLATION WHEN USING THE cli.php SCRIPT
 */
declare(strict_types=1);

return [
    'db' => [
        'core' => [
            'masters' => [
                'admin' => [
                    'db'       => 'mysql', /* db type */
                    'host'     => '127.0.0.1', /* db host address */
                    'port'     => '3306', /* db host port */
                    'login'    => 'root', /* db login name */
                    'password' => 'root', /* db login password */
                    'database' => 'omd', /* db name */
                    'weight'   => 1000, /* db table prefix */
                ],
                'insert' => [
                    'db'       => 'mysql', /* db type */
                    'host'     => '127.0.0.1', /* db host address */
                    'port'     => '3306', /* db host port */
                    'login'    => 'root', /* db login name */
                    'password' => 'root', /* db login password */
                    'database' => 'omd', /* db name */
                    'weight'   => 1000, /* db table prefix */
                ],
                'select' => [
                    'db'       => 'mysql', /* db type */
                    'host'     => '127.0.0.1', /* db host address */
                    'port'     => '3306', /* db host port */
                    'login'    => 'root', /* db login name */
                    'password' => 'root', /* db login password */
                    'database' => 'omd', /* db name */
                    'weight'   => 1000, /* db table prefix */
                ],
                'update' => [
                    'db'       => 'mysql', /* db type */
                    'host'     => '127.0.0.1', /* db host address */
                    'port'     => '3306', /* db host port */
                    'login'    => 'root', /* db login name */
                    'password' => 'root', /* db login password */
                    'database' => 'omd', /* db name */
                    'weight'   => 1000, /* db table prefix */
                ],
                'delete' => [
                    'db'       => 'mysql', /* db type */
                    'host'     => '127.0.0.1', /* db host address */
                    'port'     => '3306', /* db host port */
                    'login'    => 'root', /* db login name */
                    'password' => 'root', /* db login password */
                    'database' => 'omd', /* db name */
                    'weight'   => 1000, /* db table prefix */
                ],
                'schema' => [
                    'db'       => 'mysql', /* db type */
                    'host'     => '127.0.0.1', /* db host address */
                    'port'     => '3306', /* db host port */
                    'login'    => 'root', /* db login name */
                    'password' => 'root', /* db login password */
                    'database' => 'omd', /* db name */
                    'weight'   => 1000, /* db table prefix */
                ],
            ],
        ],
    ],
    'cache' => [
        'redis' => [
            'db'   => 1,
            'host' => '127.0.0.1',
            'port' => 6379,
        ],
        'memcached' => [
            'host' => '127.0.0.1',
            'port' => 11211,
        ],
    ],
    'log' => [
        'file' => [
            'path' => __DIR__ . '/Logs',
        ],
    ],
    'page' => [
        'root'  => '/',
        'https' => false,
    ],
    'app' => [
        'path' => __DIR__,
    ],
    'socket' => [
        'master' => [
            'host'  => '127.0.0.1',
            'limit' => 300,
            'port'  => 4310,
        ],
    ],
    'language' => [
        'en',
    ],
    'apis' => [
    ],
];
