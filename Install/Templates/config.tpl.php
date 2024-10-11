<?php
/**
 * Jingga
 *
 * PHP Version 8.2
 *
 * @package   Template
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.2
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

/**
 * @var string                               $db     Database
 * @var string                               $host   Host
 * @var int                                  $port   Port
 * @var array{login:string, password:string} $admin  Admin login data
 * @var array{login:string, password:string} $insert Insert login data
 * @var array{login:string, password:string} $select Select login data
 * @var array{login:string, password:string} $update Update login data
 * @var array{login:string, password:string} $delete Delete login data
 * @var array{login:string, password:string} $schema Schema login data
 * @var string                               $dbname Database name
 * @var string                               $subdir Subdirectory path
 * @var string                               $tld    Top level domain
 */
return <<<EOT
<?php
/**
 * Jingga
 *
 * PHP Version 8.2
 *
 * @package   Install
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.2
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

return [
    'db'       => [
        'core' => [
            'masters' => [
                'admin'  => [
                    'db'       => '{$db}', /* db type */
                    'host'     => '{$host}', /* db host address */
                    'port'     => '{$port}', /* db host port */
                    'login'    => '{$admin['login']}', /* db login name */
                    'password' => '{$admin['password']}', /* db login password */
                    'database' => '{$dbname}', /* db name */
                ],
                'insert'  => [
                    'db'       => '{$db}', /* db type */
                    'host'     => '{$host}', /* db host address */
                    'port'     => '{$port}', /* db host port */
                    'login'    => '{$insert['login']}', /* db login name */
                    'password' => '{$insert['password']}', /* db login password */
                    'database' => '{$dbname}', /* db name */
                ],
                'select'  => [
                    'db'       => '{$db}', /* db type */
                    'host'     => '{$host}', /* db host address */
                    'port'     => '{$port}', /* db host port */
                    'login'    => '{$select['login']}', /* db login name */
                    'password' => '{$select['password']}', /* db login password */
                    'database' => '{$dbname}', /* db name */
                ],
                'update'  => [
                    'db'       => '{$db}', /* db type */
                    'host'     => '{$host}', /* db host address */
                    'port'     => '{$port}', /* db host port */
                    'login'    => '{$update['login']}', /* db login name */
                    'password' => '{$update['password']}', /* db login password */
                    'database' => '{$dbname}', /* db name */
                ],
                'delete'  => [
                    'db'       => '{$db}', /* db type */
                    'host'     => '{$host}', /* db host address */
                    'port'     => '{$port}', /* db host port */
                    'login'    => '{$delete['login']}', /* db login name */
                    'password' => '{$delete['password']}', /* db login password */
                    'database' => '{$dbname}', /* db name */
                ],
                'schema'  => [
                    'db'       => '{$db}', /* db type */
                    'host'     => '{$host}', /* db host address */
                    'port'     => '{$port}', /* db host port */
                    'login'    => '{$schema['login']}', /* db login name */
                    'password' => '{$schema['password']}', /* db login password */
                    'database' => '{$dbname}', /* db name */
                ],
            ],
        ],
    ],
    'cache' => [
    ],
    'log'      => [
        'file' => [
            'path' => __DIR__ . '/Logs',
        ],
    ],
    'page'     => [
        'root'  => '{$subdir}',
        'https' => false,
    ],
    'app'      => [
        'path'    => __DIR__,
        'default' => [
            'app'   => 'Backend',
            'id'    => 'backend',
            'lang'  => 'en',
            'theme' => 'Backend',
            'org'   => {$defaultOrg},
        ],
        'domains' => [
            '{$tld}' => [
                'app'   => 'Backend',
                'id'    => 'backend',
                'lang'  => 'en',
                'theme' => 'Backend',
                'org'   => {$tldOrg},
            ],
        ],
    ],
    'socket'   => [
        'master' => [
            'host'  => '{$tld}',
            'limit' => 300,
            'port'  => 4310,
        ],
    ],
    'language' => [
        'en', 'de',
    ],
];

EOT;
