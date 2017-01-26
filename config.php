<?php
/**
 * Orange Management
 *
 * PHP Version 7.1
 *
 * @category   TBD
 * @package    TBD
 * @author     OMS Development Team <dev@oms.com>
 * @author     Dennis Eichhorn <d.eichhorn@oms.com>
 * @copyright  Dennis Eichhorn
 * @license    OMS License 1.0
 * @version    1.0.0
 * @link       http://orange-management.com
 */
/**
 * Global config file.
 *
 * @category   Framework
 * @package    phpOMS\Config
 * @since      1.0.0
 */
define('ROOT_PATH', __DIR__);

$CONFIG = [
    'db'       => [
        'core' => [
            'masters' => [
                [
                    'db'       => 'mysql', /* db type */
                    'host'     => '127.0.0.1', /* db host address */
                    'port'     => '3306', /* db host port */
                    'login'    => 'root', /* db login name */
                    'password' => '123456', /* db login password */
                    'database' => 'oms', /* db name */
                    'prefix'   => 'oms_', /* db table prefix */
                    'weight'   => 1000, /* db table prefix */
                ],
            ],
            'slaves'  => [

            ],
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
        'en', 'de',
    ],
    'apis'     => [
        'google' => [
            'key' => 'AIzaSyCtO4kWuXsqFZgDKBKhmqlQTiDhA1qupCk',
        ],
    ],
    'jobs' => [
        'path' => 'c:/WINDOWS/system32/schtasks.exe'
    ]
];
