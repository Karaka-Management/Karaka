<?php
/**
 * Karaka
 *
 * PHP Version 8.1
 *
 * @package   Web
 * @copyright Dennis Eichhorn
 * @license   OMS License 1.0
 * @version   1.0.0
 * @link      https://karaka.app
 */
declare(strict_types=1);

namespace Console;

use Model\CoreSettings;
use Modules\Admin\Models\AccountMapper;
use Modules\Admin\Models\LocalizationMapper;
use Modules\Admin\Models\NullAccount as ModelsNullAccount;
use phpOMS\Account\Account;
use phpOMS\Account\AccountManager;
use phpOMS\Account\NullAccount;
use phpOMS\Application\ApplicationAbstract;
use phpOMS\Auth\Auth;
use phpOMS\DataStorage\Cache\CachePool;
use phpOMS\DataStorage\Cookie\CookieJar;
use phpOMS\DataStorage\Database\DatabasePool;
use phpOMS\DataStorage\Database\Mapper\DataMapperFactory;
use phpOMS\DataStorage\Session\HttpSession;
use phpOMS\Dispatcher\Dispatcher;
use phpOMS\Event\EventManager;
use phpOMS\Localization\L11nManager;
use phpOMS\Localization\Localization;
use phpOMS\Log\FileLogger;
use phpOMS\Message\Console\ConsoleRequest;
use phpOMS\Message\Console\ConsoleResponse;
use phpOMS\Module\ModuleManager;
use phpOMS\Router\SocketRouter;
use phpOMS\Uri\Argument;
use phpOMS\Uri\UriFactory;

/**
 * Application class.
 *
 * @package Console
 * @license OMS License 1.0
 * @link    https://karaka.app
 * @since   1.0.0
 *
 * @codeCoverageIgnore
 */
class ConsoleApplication extends ApplicationAbstract
{
    /**
     * @var array{log:array{file:array{path:string}}, app:array{path:string, default:array{id:string, app:string, org:int, lang:string}, domains:array}, page:array{root:string, https:bool}, language:string[]}
     */
    private array $config;

    /**
     * Constructor.
     *
     * @param array{log:array{file:array{path:string}}, app:array{path:string, default:array{id:string, app:string, org:int, lang:string}, domains:array}, page:array{root:string, https:bool}, language:string[]} $config Core config
     *
     * @since 1.0.0
     */
    public function __construct(array $config)
    {
        $this->config = $config;

        $this->appName = 'Console';
        $this->config  = $config;

        $this->logger = FileLogger::getInstance(__DIR__ . '/../Logs', false);

        UriFactory::setQuery('/app', \strtolower($this->appName));

        $this->orgId          = $this->getApplicationOrganization($this->config['app']);
        $this->l11nManager    = new L11nManager($this->appName);
        $this->dbPool         = new DatabasePool();
        $this->sessionManager = new HttpSession(0);
        $this->cookieJar      = new CookieJar();
        $this->cachePool      = new CachePool();
        $this->appSettings    = new CoreSettings();
        $this->eventManager   = new EventManager($this->dispatcher);
        $this->accountManager = new AccountManager($this->sessionManager);
        $this->l11nServer     = LocalizationMapper::get()->where('id', 1)->execute();
        $this->moduleManager  = new ModuleManager($this, __DIR__ . '/../../Modules/');
        $this->dispatcher     = new Dispatcher($this);

        $this->dbPool->create('select', $this->config['db']['core']['masters']['select']);

        /** @var \phpOMS\DataStorage\Database\Connection\ConnectionAbstract $con */
        $con = $this->dbPool->get();
        DataMapperFactory::db($con);

        $this->router = new SocketRouter();
        $this->router->importFromFile(__DIR__ . '/Routes.php');
    }

    /**
     * Run console request.
     *
     * @param array $argv Console arguments
     *
     * @return void
     *
     * @since 1.0.0
     */
    public function run(array $argv) : void
    {
        $request  = new ConsoleRequest(new Argument(\implode(' ', $argv)), new Localization());
        $response = new ConsoleResponse(new Localization());

        $aid     = Auth::authenticate($this->sessionManager);
        $account = $this->loadAccount($aid);

        $routes = $this->router->route(
            $request->uri->getRoute(),
            $request->getData('CSRF'),
            $request->getRouteVerb(),
            $this->appName,
            $this->orgId,
            $account,
            $request->getData()
        );

        $this->dispatcher->dispatch($routes, $request, $response);

        echo $response->getBody(true);
    }

    /**
     * Load permission
     *
     * @param int $uid User Id
     *
     * @return Account
     *
     * @since 1.0.0
     */
    private function loadAccount(int $uid) : Account
    {
        $account = AccountMapper::getWithPermissions($uid);

        if ($account instanceof ModelsNullAccount) {
            $account = new NullAccount();
        }

        $this->accountManager->add($account);

        return $account;
    }

    /**
     * Get application organization
     *
     * @param array $config App config
     *
     * @return int Organization id
     *
     * @since 1.0.0
     */
    private function getApplicationOrganization(array $config) : int
    {
        return $config['default']['org'];
    }
}
