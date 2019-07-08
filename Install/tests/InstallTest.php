<?php
/**
 * Orange Management
 *
 * PHP Version 7.2
 *
 * @package    tests
 * @copyright  Dennis Eichhorn
 * @license    OMS License 1.0
 * @version    1.0.0
 * @link       https://orange-management.org
 */

namespace Install\tests;

use Install\WebApplication;
use phpOMS\Message\Http\Request;
use phpOMS\Message\Http\RequestMethod;
use phpOMS\Message\Http\Response;
use phpOMS\Uri\Http;

class InstallTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @group admin
     */
    public function testInstall() : void
    {
        $config   = [
            'db'       => [
                'core' => [
                    'masters' => [
                        'admin'  => [
                            'db'       => 'mysql', /* db type */
                            'host'     => '127.0.0.1', /* db host address */
                            'port'     => '3306', /* db host port */
                            'login'    => 'root', /* db login name */
                            'password' => '', /* db login password */
                            'database' => 'oms', /* db name */
                            'prefix'   => 'oms_', /* db table prefix */
                            'weight'   => 1000, /* db table prefix */
                        ],
                        'insert'  => [
                            'db'       => 'mysql', /* db type */
                            'host'     => '127.0.0.1', /* db host address */
                            'port'     => '3306', /* db host port */
                            'login'    => 'root', /* db login name */
                            'password' => '', /* db login password */
                            'database' => 'oms', /* db name */
                            'prefix'   => 'oms_', /* db table prefix */
                            'weight'   => 1000, /* db table prefix */
                        ],
                        'select'  => [
                            'db'       => 'mysql', /* db type */
                            'host'     => '127.0.0.1', /* db host address */
                            'port'     => '3306', /* db host port */
                            'login'    => 'root', /* db login name */
                            'password' => '', /* db login password */
                            'database' => 'oms', /* db name */
                            'prefix'   => 'oms_', /* db table prefix */
                            'weight'   => 1000, /* db table prefix */
                        ],
                        'update'  => [
                            'db'       => 'mysql', /* db type */
                            'host'     => '127.0.0.1', /* db host address */
                            'port'     => '3306', /* db host port */
                            'login'    => 'root', /* db login name */
                            'password' => '', /* db login password */
                            'database' => 'oms', /* db name */
                            'prefix'   => 'oms_', /* db table prefix */
                            'weight'   => 1000, /* db table prefix */
                        ],
                        'delete'  => [
                            'db'       => 'mysql', /* db type */
                            'host'     => '127.0.0.1', /* db host address */
                            'port'     => '3306', /* db host port */
                            'login'    => 'root', /* db login name */
                            'password' => '', /* db login password */
                            'database' => 'oms', /* db name */
                            'prefix'   => 'oms_', /* db table prefix */
                            'weight'   => 1000, /* db table prefix */
                        ],
                        'schema'  => [
                            'db'       => 'mysql', /* db type */
                            'host'     => '127.0.0.1', /* db host address */
                            'port'     => '3306', /* db host port */
                            'login'    => 'root', /* db login name */
                            'password' => '', /* db login password */
                            'database' => 'oms', /* db name */
                            'prefix'   => 'oms_', /* db table prefix */
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
                'root'  => '/',
                'https' => false,
            ],
            'app'      => [
                'path' => __DIR__,
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
            ]
        ];
        $response = new Response();
        $request  = new Request(new Http(''));
        $request->setMethod(RequestMethod::POST);

        $request->setData('dbhost', $config['db']['core']['masters']['admin']['host']);
        $request->setData('dbtype', $config['db']['core']['masters']['admin']['db']);
        $request->setData('dbport', $config['db']['core']['masters']['admin']['port']);
        $request->setData('dbprefix', $config['db']['core']['masters']['admin']['prefix']);
        $request->setData('dbname', $config['db']['core']['masters']['admin']['database']);
        $request->setData('schemauser', $config['db']['core']['masters']['admin']['login']);
        $request->setData('schemapassword', $config['db']['core']['masters']['admin']['password']);
        $request->setData('createuser', $config['db']['core']['masters']['admin']['login']);
        $request->setData('createpassword', $config['db']['core']['masters']['admin']['password']);
        $request->setData('selectuser', $config['db']['core']['masters']['admin']['login']);
        $request->setData('selectpassword', $config['db']['core']['masters']['admin']['password']);
        $request->setData('updateuser', $config['db']['core']['masters']['admin']['login']);
        $request->setData('updatepassword', $config['db']['core']['masters']['admin']['password']);
        $request->setData('deleteuser', $config['db']['core']['masters']['admin']['login']);
        $request->setData('deletepassword', $config['db']['core']['masters']['admin']['password']);

        $request->setData('orgname', 'Orange-Management');
        $request->setData('adminname', 'admin');
        $request->setData('adminpassword', 'orange');
        $request->setData('adminemail', 'admin@oms.com');
        $request->setData('domain', '127.0.0.1');
        $request->setData('websubdir', '/');
        $request->setData('defaultlang', 'en');

        WebApplication::installRequest($request, $response);
    }
}
