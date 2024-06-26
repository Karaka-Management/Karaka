<?php
declare(strict_types=1);
/**
 * Jingga
 *
 * PHP Version 8.2
 *
 * @package   tests
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.0
 * @version   1.0.0
 * @link      https://jingga.app
 */
namespace Install\tests;

use Install\WebApplication;
use phpOMS\DataStorage\Database\DatabaseType;
use phpOMS\Message\Http\HttpRequest;
use phpOMS\Message\Http\HttpResponse;
use phpOMS\Message\Http\RequestMethod;
use phpOMS\Message\Http\RequestStatusCode;

/**
 * @internal
 */
#[\PHPUnit\Framework\Attributes\CoversClass(\Install\WebApplication::class)]
#[\PHPUnit\Framework\Attributes\CoversClass(\phpOMS\Application\ApplicationManager::class)]
#[\PHPUnit\Framework\Attributes\CoversClass(\phpOMS\Module\ModuleManager::class)]
#[\PHPUnit\Framework\Attributes\CoversClass(\Modules\Admin\Controller\ApiController::class)]
#[\PHPUnit\Framework\Attributes\CoversClass(\Modules\CMS\Controller\ApiController::class)]
#[\PHPUnit\Framework\Attributes\CoversClass(\Modules\Admin\Admin\Installer::class)]
#[\PHPUnit\Framework\Attributes\CoversClass(\Modules\Auditor\Admin\Installer::class)]
#[\PHPUnit\Framework\Attributes\CoversClass(\Modules\Organization\Admin\Installer::class)]
#[\PHPUnit\Framework\Attributes\CoversClass(\Modules\Help\Admin\Installer::class)]
#[\PHPUnit\Framework\Attributes\CoversClass(\Modules\Profile\Admin\Installer::class)]
#[\PHPUnit\Framework\Attributes\CoversClass(\Modules\Navigation\Admin\Installer::class)]
#[\PHPUnit\Framework\Attributes\CoversClass(\Modules\Dashboard\Admin\Installer::class)]
#[\PHPUnit\Framework\Attributes\CoversClass(\Modules\CMS\Admin\Installer::class)]
#[\PHPUnit\Framework\Attributes\CoversClass(\Modules\Tag\Admin\Installer::class)]
#[\PHPUnit\Framework\Attributes\CoversClass(\Modules\Media\Admin\Installer::class)]
class InstallTest extends \PHPUnit\Framework\TestCase
{
    public function testPermissions() : void
    {
        self::assertTrue(\is_writable(__DIR__ . '/../../Cli/Routes.php'));
        self::assertTrue(\is_writable(__DIR__ . '/../../Cli/Hooks.php'));
        self::assertTrue(\is_writable(__DIR__ . '/../../Socket/Routes.php'));
        self::assertTrue(\is_writable(__DIR__ . '/../../Socket/Hooks.php'));
        self::assertTrue(\is_writable(__DIR__ . '/../../Web'));
    }

    #[\PHPUnit\Framework\Attributes\Group('admin')]
    public function testInvalidInstallRequest() : void
    {
        $response = new HttpResponse();
        $request  = new HttpRequest();
        $request->setMethod(RequestMethod::POST);

        WebApplication::installRequest($request, $response);
        self::assertEquals(RequestStatusCode::R_400, $response->header->status);
    }

    #[\PHPUnit\Framework\Attributes\Group('admin')]
    public function testInvalidDatabaseInstallRequest() : void
    {
        $response = new HttpResponse();
        $request  = new HttpRequest();
        $request->setMethod(RequestMethod::POST);

        $request->setData('dbhost', '127.0.0.1');
        $request->setData('dbtype', DatabaseType::MYSQL);
        $request->setData('dbport', 3306);
        $request->setData('dbname', 'invalid');
        $request->setData('schemauser', 'invalid');
        $request->setData('schemapassword', 'invalid');
        $request->setData('createuser', 'invalid');
        $request->setData('createpassword', 'invalid');
        $request->setData('selectuser', 'invalid');
        $request->setData('selectpassword', 'invalid');
        $request->setData('updateuser', 'invalid');
        $request->setData('updatepassword', 'invalid');
        $request->setData('deleteuser', 'invalid');
        $request->setData('deletepassword', 'invalid');

        $request->setData('orgname', 'Karaka');
        $request->setData('adminname', 'admin');
        $request->setData('adminpassword', 'orange');
        $request->setData('adminemail', 'admin@oms.com');
        $request->setData('domain', '127.0.0.1');
        $request->setData('websubdir', '/');
        $request->setData('defaultlang', 'en');
        $request->setData('defaultcountry', 'us');

        $request->setData(
            'apps',
            'Install/Application/Api, '
            . 'Install/Application/Backend, '
            . 'Install/Application/E404, '
            . 'Install/Application/E500, '
            . 'Install/Application/E503'
        );

        WebApplication::installRequest($request, $response);
        self::assertEquals(RequestStatusCode::R_400, $response->header->status);
    }

    #[\PHPUnit\Framework\Attributes\Group('admin')]
    public function testInstall() : void
    {
        $config = [
            'db' => [
                'core' => [
                    'masters' => [
                        'admin' => [
                            'db'       => 'mysql', /* db type */
                            'host'     => '127.0.0.1', /* db host address */
                            'port'     => '3306', /* db host port */
                            'login'    => 'test', /* db login name */
                            'password' => 'orange', /* db login password */
                            'database' => 'omt', /* db name */
                            'weight'   => 1000, /* db table weight */
                        ],
                        'insert' => [
                            'db'       => 'mysql', /* db type */
                            'host'     => '127.0.0.1', /* db host address */
                            'port'     => '3306', /* db host port */
                            'login'    => 'test', /* db login name */
                            'password' => 'orange', /* db login password */
                            'database' => 'omt', /* db name */
                            'weight'   => 1000, /* db table weight */
                        ],
                        'select' => [
                            'db'       => 'mysql', /* db type */
                            'host'     => '127.0.0.1', /* db host address */
                            'port'     => '3306', /* db host port */
                            'login'    => 'test', /* db login name */
                            'password' => 'orange', /* db login password */
                            'database' => 'omt', /* db name */
                            'weight'   => 1000, /* db table weight */
                        ],
                        'update' => [
                            'db'       => 'mysql', /* db type */
                            'host'     => '127.0.0.1', /* db host address */
                            'port'     => '3306', /* db host port */
                            'login'    => 'test', /* db login name */
                            'password' => 'orange', /* db login password */
                            'database' => 'omt', /* db name */
                            'weight'   => 1000, /* db table weight */
                        ],
                        'delete' => [
                            'db'       => 'mysql', /* db type */
                            'host'     => '127.0.0.1', /* db host address */
                            'port'     => '3306', /* db host port */
                            'login'    => 'test', /* db login name */
                            'password' => 'orange', /* db login password */
                            'database' => 'omt', /* db name */
                            'weight'   => 1000, /* db table weight */
                        ],
                        'schema' => [
                            'db'       => 'mysql', /* db type */
                            'host'     => '127.0.0.1', /* db host address */
                            'port'     => '3306', /* db host port */
                            'login'    => 'test', /* db login name */
                            'password' => 'orange', /* db login password */
                            'database' => 'omt', /* db name */
                            'weight'   => 1000, /* db table weight */
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
        $response = new HttpResponse();
        $request  = new HttpRequest();
        $request->setMethod(RequestMethod::POST);

        $request->setData('dbhost', $config['db']['core']['masters']['admin']['host']);
        $request->setData('dbtype', $config['db']['core']['masters']['admin']['db']);
        $request->setData('dbport', $config['db']['core']['masters']['admin']['port']);
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

        $request->setData('orgname', 'Karaka');
        $request->setData('adminname', 'admin');
        $request->setData('adminpassword', 'orange');
        $request->setData('adminemail', 'admin@oms.com');
        $request->setData('domain', '127.0.0.1');
        $request->setData('websubdir', '/');
        $request->setData('defaultlang', 'en');
        $request->setData('defaultcountry', 'us');

        $request->setData(
            'apps',
            'Install/Application/Api, '
            . 'Install/Application/Backend, '
            . 'Install/Application/E404, '
            . 'Install/Application/E500, '
            . 'Install/Application/E503'
        );

        WebApplication::installRequest($request, $response);
        self::assertEquals(RequestStatusCode::R_200, $response->header->status);
    }
}
