<?php
/**
 * Jingga
 *
 * PHP Version 8.2
 *
 * @package   Jingga
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.0
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

\ob_start();

require_once __DIR__ . '/Autoloader.php';

use Modules\Helper\Models\TemplateMapper;
use Modules\Media\Models\CollectionMapper;
use phpOMS\DataStorage\Database\DatabasePool;
use phpOMS\DataStorage\Database\Mapper\DataMapperFactory;
use phpOMS\DataStorage\Session\HttpSession;

$CONFIG = [
    'db'       => [
        'core' => [
            'masters' => [
                'admin'  => [
                    'db'       => 'mysql', /* db type */
                    'host'     => '127.0.0.1', /* db host address */
                    'port'     => '3306', /* db host port */
                    'login'    => 'test', /* db login name */
                    'password' => 'orange', /* db login password */
                    'database' => 'omt', /* db name */
                    'weight'   => 1000, /* db table prefix */
                ],
                'insert'  => [
                    'db'       => 'mysql', /* db type */
                    'host'     => '127.0.0.1', /* db host address */
                    'port'     => '3306', /* db host port */
                    'login'    => 'test', /* db login name */
                    'password' => 'orange', /* db login password */
                    'database' => 'omt', /* db name */
                    'weight'   => 1000, /* db table prefix */
                ],
                'select'  => [
                    'db'       => 'mysql', /* db type */
                    'host'     => '127.0.0.1', /* db host address */
                    'port'     => '3306', /* db host port */
                    'login'    => 'test', /* db login name */
                    'password' => 'orange', /* db login password */
                    'database' => 'omt', /* db name */
                    'weight'   => 1000, /* db table prefix */
                ],
                'update'  => [
                    'db'       => 'mysql', /* db type */
                    'host'     => '127.0.0.1', /* db host address */
                    'port'     => '3306', /* db host port */
                    'login'    => 'test', /* db login name */
                    'password' => 'orange', /* db login password */
                    'database' => 'omt', /* db name */
                    'weight'   => 1000, /* db table prefix */
                ],
                'delete'  => [
                    'db'       => 'mysql', /* db type */
                    'host'     => '127.0.0.1', /* db host address */
                    'port'     => '3306', /* db host port */
                    'login'    => 'test', /* db login name */
                    'password' => 'orange', /* db login password */
                    'database' => 'omt', /* db name */
                    'weight'   => 1000, /* db table prefix */
                ],
                'schema'  => [
                    'db'       => 'mysql', /* db type */
                    'host'     => '127.0.0.1', /* db host address */
                    'port'     => '3306', /* db host port */
                    'login'    => 'test', /* db login name */
                    'password' => 'orange', /* db login password */
                    'database' => 'omt', /* db name */
                    'weight'   => 1000, /* db table prefix */
                ],
            ],
            'postgresql' => [
                'admin'  => [
                    'db'       => 'pgsql', /* db type */
                    'host'     => '127.0.0.1', /* db host address */
                    'port'     => '5432', /* db host port */
                    'login'    => 'test', /* db login name */
                    'password' => 'orange', /* db login password */
                    'database' => 'omt', /* db name */
                    'weight'   => 1000, /* db table prefix */
                ],
                'insert'  => [
                    'db'       => 'pgsql', /* db type */
                    'host'     => '127.0.0.1', /* db host address */
                    'port'     => '5432', /* db host port */
                    'login'    => 'test', /* db login name */
                    'password' => 'orange', /* db login password */
                    'database' => 'omt', /* db name */
                    'weight'   => 1000, /* db table prefix */
                ],
                'select'  => [
                    'db'       => 'pgsql', /* db type */
                    'host'     => '127.0.0.1', /* db host address */
                    'port'     => '5432', /* db host port */
                    'login'    => 'test', /* db login name */
                    'password' => 'orange', /* db login password */
                    'database' => 'omt', /* db name */
                    'weight'   => 1000, /* db table prefix */
                ],
                'update'  => [
                    'db'       => 'pgsql', /* db type */
                    'host'     => '127.0.0.1', /* db host address */
                    'port'     => '5432', /* db host port */
                    'login'    => 'test', /* db login name */
                    'password' => 'orange', /* db login password */
                    'database' => 'omt', /* db name */
                    'weight'   => 1000, /* db table prefix */
                ],
                'delete'  => [
                    'db'       => 'pgsql', /* db type */
                    'host'     => '127.0.0.1', /* db host address */
                    'port'     => '5432', /* db host port */
                    'login'    => 'test', /* db login name */
                    'password' => 'orange', /* db login password */
                    'database' => 'omt', /* db name */
                    'weight'   => 1000, /* db table prefix */
                ],
                'schema'  => [
                    'db'       => 'pgsql', /* db type */
                    'host'     => '127.0.0.1', /* db host address */
                    'port'     => '5432', /* db host port */
                    'login'    => 'test', /* db login name */
                    'password' => 'orange', /* db login password */
                    'database' => 'omt', /* db name */
                    'weight'   => 1000, /* db table prefix */
                ],
            ],
            'sqlite' => [
                'admin'  => [
                    'db'       => 'sqlite', /* db type */
                    'database' => __DIR__ . '/test.sqlite', /* db name */
                    'weight'   => 1000, /* db table prefix */
                ],
                'insert'  => [
                    'db'       => 'sqlite', /* db type */
                    'database' => __DIR__ . '/test.sqlite', /* db name */
                    'weight'   => 1000, /* db table prefix */
                ],
                'select'  => [
                    'db'       => 'sqlite', /* db type */
                    'database' => __DIR__ . '/test.sqlite', /* db name */
                    'weight'   => 1000, /* db table prefix */
                ],
                'update'  => [
                    'db'       => 'sqlite', /* db type */
                    'database' => __DIR__ . '/test.sqlite', /* db name */
                    'weight'   => 1000, /* db table prefix */
                ],
                'delete'  => [
                    'db'       => 'sqlite', /* db type */
                    'database' => __DIR__ . '/test.sqlite', /* db name */
                    'weight'   => 1000, /* db table prefix */
                ],
                'schema'  => [
                    'db'       => 'sqlite', /* db type */
                    'database' => __DIR__ . '/test.sqlite', /* db name */
                    'weight'   => 1000, /* db table prefix */
                ],
            ],
            'mssql' => [
                'admin'  => [
                    'db'       => 'mssql', /* db type */
                    'host'     => '127.0.0.1', /* db host address */
                    'port'     => '5432', /* db host port */
                    'login'    => 'test', /* db login name */
                    'password' => 'orange', /* db login password */
                    'database' => 'omt', /* db name */
                    'weight'   => 1000, /* db table prefix */
                ],
                'insert'  => [
                    'db'       => 'mssql', /* db type */
                    'host'     => '127.0.0.1', /* db host address */
                    'port'     => '5432', /* db host port */
                    'login'    => 'test', /* db login name */
                    'password' => 'orange', /* db login password */
                    'database' => 'omt', /* db name */
                    'weight'   => 1000, /* db table prefix */
                ],
                'select'  => [
                    'db'       => 'mssql', /* db type */
                    'host'     => '127.0.0.1', /* db host address */
                    'port'     => '5432', /* db host port */
                    'login'    => 'test', /* db login name */
                    'password' => 'orange', /* db login password */
                    'database' => 'omt', /* db name */
                    'weight'   => 1000, /* db table prefix */
                ],
                'update'  => [
                    'db'       => 'mssql', /* db type */
                    'host'     => '127.0.0.1', /* db host address */
                    'port'     => '5432', /* db host port */
                    'login'    => 'test', /* db login name */
                    'password' => 'orange', /* db login password */
                    'database' => 'omt', /* db name */
                    'weight'   => 1000, /* db table prefix */
                ],
                'delete'  => [
                    'db'       => 'mssql', /* db type */
                    'host'     => '127.0.0.1', /* db host address */
                    'port'     => '5432', /* db host port */
                    'login'    => 'test', /* db login name */
                    'password' => 'orange', /* db login password */
                    'database' => 'omt', /* db name */
                    'weight'   => 1000, /* db table prefix */
                ],
                'schema'  => [
                    'db'       => 'mssql', /* db type */
                    'host'     => '127.0.0.1', /* db host address */
                    'port'     => '5432', /* db host port */
                    'login'    => 'test', /* db login name */
                    'password' => 'orange', /* db login password */
                    'database' => 'omt', /* db name */
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
    'mail' => [
        'imap' => [
            'host'     => '127.0.0.1',
            'port'     => 143,
            'ssl'      => false,
            'user'     => 'test',
            'password' => '123456',
        ],
        'pop3' => [
            'host'     => '127.0.0.1',
            'port'     => 25,
            'ssl'      => false,
            'user'     => 'test',
            'password' => '123456',
        ],
    ],
    'log'      => [
        'file' => [
            'path' => __DIR__ . '/Logs',
        ],
    ],
    'page'     => [
        'root'  => '/',
        'https' => false,
    ],
    'socket'   => [
        'master' => [
            'host'  => '127.0.0.1',
            'limit' => 300,
            'port'  => 4310,
        ],
    ],
    'language' => [
        'en',
    ],
    'apis'     => [
    ],
];

$httpSession        = new HttpSession();
$GLOBALS['session'] = $httpSession;

$GLOBALS['dbpool'] = new DatabasePool();
$GLOBALS['dbpool']->create('admin', $CONFIG['db']['core']['masters']['admin']);
$GLOBALS['dbpool']->create('select', $CONFIG['db']['core']['masters']['select']);
$GLOBALS['dbpool']->create('update', $CONFIG['db']['core']['masters']['update']);
$GLOBALS['dbpool']->create('delete', $CONFIG['db']['core']['masters']['delete']);
$GLOBALS['dbpool']->create('insert', $CONFIG['db']['core']['masters']['insert']);
$GLOBALS['dbpool']->create('schema', $CONFIG['db']['core']['masters']['schema']);

DataMapperFactory::db($GLOBALS['dbpool']->get());

$template   = TemplateMapper::get()->where('id', 1)->execute();
$collection = CollectionMapper::get($template->getSource()->getId());

$end = true;
