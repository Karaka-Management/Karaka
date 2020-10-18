<?php declare(strict_types=1);

\ini_set('memory_limit', '2048M');
\ini_set('display_errors', '1');
\ini_set('display_startup_errors', '1');
\error_reporting(\E_ALL);
\setlocale(\LC_ALL, 'en_US.UTF-8');

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/Autoloader.php';

use phpOMS\DataStorage\Database\DatabasePool;
use phpOMS\DataStorage\Database\DataMapperAbstract;
use phpOMS\DataStorage\Session\HttpSession;

$CONFIG = [
    'db'       => [
        'core' => [
            'masters' => [
                'admin'  => [
                    'db'       => 'mysql', /* db type */
                    'host'     => '127.0.0.1', /* db host address */
                    'port'     => '3306', /* db host port */
                    'login'    => 'root', /* db login name */
                    'password' => 'root', /* db login password */
                    'database' => 'oms', /* db name */
                    'weight'   => 1000, /* db table prefix */
                ],
                'insert'  => [
                    'db'       => 'mysql', /* db type */
                    'host'     => '127.0.0.1', /* db host address */
                    'port'     => '3306', /* db host port */
                    'login'    => 'root', /* db login name */
                    'password' => 'root', /* db login password */
                    'database' => 'oms', /* db name */
                    'weight'   => 1000, /* db table prefix */
                ],
                'select'  => [
                    'db'       => 'mysql', /* db type */
                    'host'     => '127.0.0.1', /* db host address */
                    'port'     => '3306', /* db host port */
                    'login'    => 'root', /* db login name */
                    'password' => 'root', /* db login password */
                    'database' => 'oms', /* db name */
                    'weight'   => 1000, /* db table prefix */
                ],
                'update'  => [
                    'db'       => 'mysql', /* db type */
                    'host'     => '127.0.0.1', /* db host address */
                    'port'     => '3306', /* db host port */
                    'login'    => 'root', /* db login name */
                    'password' => 'root', /* db login password */
                    'database' => 'oms', /* db name */
                    'weight'   => 1000, /* db table prefix */
                ],
                'delete'  => [
                    'db'       => 'mysql', /* db type */
                    'host'     => '127.0.0.1', /* db host address */
                    'port'     => '3306', /* db host port */
                    'login'    => 'root', /* db login name */
                    'password' => 'root', /* db login password */
                    'database' => 'oms', /* db name */
                    'weight'   => 1000, /* db table prefix */
                ],
                'schema'  => [
                    'db'       => 'mysql', /* db type */
                    'host'     => '127.0.0.1', /* db host address */
                    'port'     => '3306', /* db host port */
                    'login'    => 'root', /* db login name */
                    'password' => 'root', /* db login password */
                    'database' => 'oms', /* db name */
                    'weight'   => 1000, /* db table prefix */
                ],
            ],
            'postgresql' => [
                'admin'  => [
                    'db'       => 'pgsql', /* db type */
                    'host'     => '127.0.0.1', /* db host address */
                    'port'     => '5432', /* db host port */
                    'login'    => 'postgres', /* db login name */
                    'password' => 'root', /* db login password */
                    'database' => 'oms', /* db name */
                    'weight'   => 1000, /* db table prefix */
                ],
                'insert'  => [
                    'db'       => 'pgsql', /* db type */
                    'host'     => '127.0.0.1', /* db host address */
                    'port'     => '5432', /* db host port */
                    'login'    => 'postgres', /* db login name */
                    'password' => 'root', /* db login password */
                    'database' => 'oms', /* db name */
                    'weight'   => 1000, /* db table prefix */
                ],
                'select'  => [
                    'db'       => 'pgsql', /* db type */
                    'host'     => '127.0.0.1', /* db host address */
                    'port'     => '5432', /* db host port */
                    'login'    => 'postgres', /* db login name */
                    'password' => 'root', /* db login password */
                    'database' => 'oms', /* db name */
                    'weight'   => 1000, /* db table prefix */
                ],
                'update'  => [
                    'db'       => 'pgsql', /* db type */
                    'host'     => '127.0.0.1', /* db host address */
                    'port'     => '5432', /* db host port */
                    'login'    => 'postgres', /* db login name */
                    'password' => 'root', /* db login password */
                    'database' => 'oms', /* db name */
                    'weight'   => 1000, /* db table prefix */
                ],
                'delete'  => [
                    'db'       => 'pgsql', /* db type */
                    'host'     => '127.0.0.1', /* db host address */
                    'port'     => '5432', /* db host port */
                    'login'    => 'postgres', /* db login name */
                    'password' => 'root', /* db login password */
                    'database' => 'oms', /* db name */
                    'weight'   => 1000, /* db table prefix */
                ],
                'schema'  => [
                    'db'       => 'pgsql', /* db type */
                    'host'     => '127.0.0.1', /* db host address */
                    'port'     => '5432', /* db host port */
                    'login'    => 'postgres', /* db login name */
                    'password' => 'root', /* db login password */
                    'database' => 'oms', /* db name */
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
                    'port'     => '1433', /* db host port */
                    'login'    => 'sa', /* db login name */
                    'password' => 'R00troot', /* db login password */
                    'database' => 'oms', /* db name */
                    'weight'   => 1000, /* db table prefix */
                ],
                'insert'  => [
                    'db'       => 'mssql', /* db type */
                    'host'     => '127.0.0.1', /* db host address */
                    'port'     => '1433', /* db host port */
                    'login'    => 'sa', /* db login name */
                    'password' => 'R00troot', /* db login password */
                    'database' => 'oms', /* db name */
                    'weight'   => 1000, /* db table prefix */
                ],
                'select'  => [
                    'db'       => 'mssql', /* db type */
                    'host'     => '127.0.0.1', /* db host address */
                    'port'     => '1433', /* db host port */
                    'login'    => 'sa', /* db login name */
                    'password' => 'R00troot', /* db login password */
                    'database' => 'oms', /* db name */
                    'weight'   => 1000, /* db table prefix */
                ],
                'update'  => [
                    'db'       => 'mssql', /* db type */
                    'host'     => '127.0.0.1', /* db host address */
                    'port'     => '1433', /* db host port */
                    'login'    => 'sa', /* db login name */
                    'password' => 'R00troot', /* db login password */
                    'database' => 'oms', /* db name */
                    'weight'   => 1000, /* db table prefix */
                ],
                'delete'  => [
                    'db'       => 'mssql', /* db type */
                    'host'     => '127.0.0.1', /* db host address */
                    'port'     => '1433', /* db host port */
                    'login'    => 'sa', /* db login name */
                    'password' => 'R00troot', /* db login password */
                    'database' => 'oms', /* db name */
                    'weight'   => 1000, /* db table prefix */
                ],
                'schema'  => [
                    'db'       => 'mssql', /* db type */
                    'host'     => '127.0.0.1', /* db host address */
                    'port'     => '1433', /* db host port */
                    'login'    => 'sa', /* db login name */
                    'password' => 'R00troot', /* db login password */
                    'database' => 'oms', /* db name */
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

// Reset database
if (\defined('RESET') && RESET === '1') {
    try {
        $db = new \PDO($CONFIG['db']['core']['masters']['admin']['db'] . ':host=' .
            $CONFIG['db']['core']['masters']['admin']['host'],
            $CONFIG['db']['core']['masters']['admin']['login'],
            $CONFIG['db']['core']['masters']['admin']['password']
        );
        $db->exec('DROP DATABASE IF EXISTS ' . $CONFIG['db']['core']['masters']['admin']['database']);
        $db->exec('CREATE DATABASE IF NOT EXISTS ' . $CONFIG['db']['core']['masters']['admin']['database']);
        $db = null;
    } catch (\Throwable $t) {
        echo "\nCouldn't connect to MYSQL DB\n";
    }

    try {
        $db = new \PDO($CONFIG['db']['core']['postgresql']['admin']['db'] . ':host=' .
            $CONFIG['db']['core']['postgresql']['admin']['host'],
            $CONFIG['db']['core']['postgresql']['admin']['login'],
            $CONFIG['db']['core']['postgresql']['admin']['password']
        );
        $db->exec('DROP DATABASE IF EXISTS ' . $CONFIG['db']['core']['postgresql']['admin']['database']);
        $db->exec('CREATE DATABASE ' . $CONFIG['db']['core']['postgresql']['admin']['database']);
        $db = null;
    } catch (\Throwable $t) {
        echo "\nCouldn't connect to POSTGRESQL DB\n";
    }

    try {
        $db = new \PDO($CONFIG['db']['core']['mssql']['admin']['db'] . ':host=' .
            $CONFIG['db']['core']['mssql']['admin']['host'],
            $CONFIG['db']['core']['mssql']['admin']['login'],
            $CONFIG['db']['core']['mssql']['admin']['password']
        );
        $db->exec('DROP DATABASE IF EXISTS ' . $CONFIG['db']['core']['mssql']['admin']['database']);
        $db->exec('CREATE DATABASE ' . $CONFIG['db']['core']['mssql']['admin']['database']);
        $db = null;
    } catch (\Throwable $t) {
        echo "\nCouldn't connect to MSSQL DB\n";
    }
}

$httpSession        = new HttpSession();
$GLOBALS['session'] = $httpSession;

$GLOBALS['dbpool'] = new DatabasePool();
$GLOBALS['dbpool']->create('admin', $CONFIG['db']['core']['masters']['admin']);
$GLOBALS['dbpool']->create('select', $CONFIG['db']['core']['masters']['select']);
$GLOBALS['dbpool']->create('update', $CONFIG['db']['core']['masters']['update']);
$GLOBALS['dbpool']->create('delete', $CONFIG['db']['core']['masters']['delete']);
$GLOBALS['dbpool']->create('insert', $CONFIG['db']['core']['masters']['insert']);
$GLOBALS['dbpool']->create('schema', $CONFIG['db']['core']['masters']['schema']);

DataMapperAbstract::setConnection($GLOBALS['dbpool']->get());

$GLOBALS['frameworkpath'] = '/phpOMS/';

function phpServe() : void
{
    // OS detection
    $isWindows = \stristr(\php_uname('s'), 'Windows') !== false;

    // Command that starts the built-in web server
    if ($isWindows) {
        $command = \sprintf(
            'wmic process call create "php -S %s:%d -t %s" | find "ProcessId"',
            WEB_SERVER_HOST,
            WEB_SERVER_PORT,
            __DIR__ . '/../' . WEB_SERVER_DOCROOT
        );

        $killCommand = 'taskkill /f /pid ';
    } else {
        $command = \sprintf(
            'php -S %s:%d -t %s >/dev/null 2>&1 & echo $!',
            WEB_SERVER_HOST,
            WEB_SERVER_PORT,
            WEB_SERVER_DOCROOT
        );

        $killCommand = 'kill ';
    }

    // Execute the command and store the process ID
    $output = [];
    echo \sprintf('Starting server...') . \PHP_EOL;
    echo \sprintf(' Current directory: %s', \getcwd()) . \PHP_EOL;
    echo \sprintf(' %s', $command);
    \exec($command, $output);

    // Get PID
    if ($isWindows) {
        $pid = \explode('=', $output[0]);
        $pid = \str_replace(' ', '', $pid[1]);
        $pid = \str_replace(';', '', $pid);
    } else {
        $pid = (int) $output[0];
    }

    // Log
    echo \sprintf(
        ' %s - Web server started on %s:%d with PID %d',
        \date('r'),
        WEB_SERVER_HOST,
        WEB_SERVER_PORT,
        $pid
    ) . \PHP_EOL;

    // Kill the web server when the process ends
    \register_shutdown_function(function() use ($killCommand, $pid) : void {
        echo \PHP_EOL . \sprintf('Stopping server...') . \PHP_EOL;
        echo \sprintf(' %s - Killing process with ID %d', \date('r'), $pid) . \PHP_EOL;
        \exec($killCommand . $pid);
    });
}

phpServe();
