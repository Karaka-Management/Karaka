<?php
/**
 * @var string $db     Database
 * @var string $host   Host
 * @var int    $port   Port
 * @var array  $admin  Admin login data
 * @var array  $insert Insert login data
 * @var array  $select Select login data
 * @var array  $update Update login data
 * @var array  $delete Delete login data
 * @var array  $schema Schema login data
 * @var string $dbname Database name
 * @var string $prefix Table prefix
 * @var string $subdir Subdirectory path
 * @var string $tld    Top level domain
 */
return <<<EOT
<?php
/**
 * Orange Management
 *
 * PHP Version 7.2
 *
 * @package    Install
 * @copyright  Dennis Eichhorn
 * @license    OMS License 1.0
 * @version    1.0.0
 * @link       http://website.orange-management.de
 */
return [
    'db'       => [
        'core' => [
            'masters' => [
                'admin'  => [
                    'db'       => '$db', /* db type */
                    'host'     => '$host', /* db host address */
                    'port'     => '$port', /* db host port */
                    'login'    => '{$admin['login']}', /* db login name */
                    'password' => '{$admin['password']}', /* db login password */
                    'database' => '$dbname', /* db name */
                    'prefix'   => '$prefix', /* db table prefix */
                    'weight'   => 1000, /* db table prefix */
                ],
                'insert'  => [
                    'db'       => '$db', /* db type */
                    'host'     => '$host', /* db host address */
                    'port'     => '$port', /* db host port */
                    'login'    => '{$insert['login']}', /* db login name */
                    'password' => '{$insert['password']}', /* db login password */
                    'database' => '$dbname', /* db name */
                    'prefix'   => '$prefix', /* db table prefix */
                    'weight'   => 1000, /* db table prefix */
                ],
                'select'  => [
                    'db'       => '$db', /* db type */
                    'host'     => '$host', /* db host address */
                    'port'     => '$port', /* db host port */
                    'login'    => '{$select['login']}', /* db login name */
                    'password' => '{$select['password']}', /* db login password */
                    'database' => '$dbname', /* db name */
                    'prefix'   => '$prefix', /* db table prefix */
                    'weight'   => 1000, /* db table prefix */
                ],
                'update'  => [
                    'db'       => '$db', /* db type */
                    'host'     => '$host', /* db host address */
                    'port'     => '$port', /* db host port */
                    'login'    => '{$update['login']}', /* db login name */
                    'password' => '{$update['password']}', /* db login password */
                    'database' => '$dbname', /* db name */
                    'prefix'   => '$prefix', /* db table prefix */
                    'weight'   => 1000, /* db table prefix */
                ],
                'delete'  => [
                    'db'       => '$db', /* db type */
                    'host'     => '$host', /* db host address */
                    'port'     => '$port', /* db host port */
                    'login'    => '{$delete['login']}', /* db login name */
                    'password' => '{$delete['password']}', /* db login password */
                    'database' => '$dbname', /* db name */
                    'prefix'   => '$prefix', /* db table prefix */
                    'weight'   => 1000, /* db table prefix */
                ],
                'schema'  => [
                    'db'       => '$db', /* db type */
                    'host'     => '$host', /* db host address */
                    'port'     => '$port', /* db host port */
                    'login'    => '{$schema['login']}', /* db login name */
                    'password' => '{$schema['password']}', /* db login password */
                    'database' => '$dbname', /* db name */
                    'prefix'   => '$prefix', /* db table prefix */
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
    'log'      => [
        'file' => [
            'path' => __DIR__ . '/Logs',
        ],
    ],
    'page'     => [
        'root'  => '$subdir',
        'https' => false,
    ],
    'app'      => [
        'path'    => __DIR__,
        'name'    => 'domain',
        'default' => 'backend',
        'domains' => [
            '$tld' => 'backend'
        ],
    ],
    'socket'   => [
        'master' => [
            'host'  => '$tld',
            'limit' => 300,
            'port'  => 4310,
        ],
    ],
    'language' => [
        'en',
    ],
    'apis'     => [
    ]
];

EOT;
