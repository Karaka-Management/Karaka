<?php
/**
 * Orange Management
 *
 * PHP Version 7.1
 *
 * @package    Install
 * @copyright  Dennis Eichhorn
 * @license    OMS License 1.0
 * @version    1.0.0
 * @link       http://website.orange-management.de
 */
declare(strict_types=1);

namespace Install;

use phpOMS\ApplicationAbstract;

use phpOMS\Autoloader;
use phpOMS\Log\FileLogger;
use phpOMS\Uri\UriFactory;
use phpOMS\Message\Console\Request;
use phpOMS\Message\Console\Response;
use phpOMS\Localization\ISO639x1Enum;
use phpOMS\Localization\Localization;
use phpOMS\Localization\L11nManager;
use phpOMS\DataStorage\Database\Connection\ConnectionAbstract;
use phpOMS\DataStorage\Database\Connection\ConnectionFactory;
use phpOMS\DataStorage\Database\DatabaseStatus;
use phpOMS\DataStorage\Database\DatabaseType;
use phpOMS\DataStorage\Database\DatabasePool;
use phpOMS\DataStorage\Database\DataMapperAbstract;
use phpOMS\Router\Router;
use phpOMS\Router\RouteVerb;
use phpOMS\Dispatcher\Dispatcher;
use phpOMS\Views\View;
use phpOMS\Account\GroupStatus;
use phpOMS\Account\AccountStatus;
use phpOMS\Account\AccountType;
use phpOMS\Account\PermissionType;
use phpOMS\Module\ModuleManager;

/**
 * Application class.
 *
 * @package    Install
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
class ConsoleApplication extends ApplicationAbstract
{
    public function install(Request $request, Response $response)
    {
    }
}
