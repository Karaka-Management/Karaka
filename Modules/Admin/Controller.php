<?php
/**
 * Orange Management
 *
 * PHP Version 7.1
 *
 * @category   TBD
 * @package    TBD
 * @copyright  Dennis Eichhorn
 * @license    OMS License 1.0
 * @version    1.0.0
 * @link       http://website.orange-management.de
 */
declare(strict_types = 1);
namespace Modules\Admin;

use Model\Message\FormValidation;
use Modules\Admin\Models\Account;
use phpOMS\Account\AccountStatus;
use phpOMS\Account\AccountType;
use Modules\Admin\Models\AccountMapper;
use Modules\Admin\Models\AccountPermissionMapper;
use Modules\Admin\Models\NullAccountPermission;
use Modules\Admin\Models\Group;
use Modules\Admin\Models\GroupMapper;
use Modules\Admin\Models\GroupPermissionMapper;
use Modules\Admin\Models\NullGroupPermission;
use phpOMS\Account\GroupStatus;
use phpOMS\Message\RequestAbstract;
use phpOMS\Message\ResponseAbstract;
use phpOMS\Module\ModuleAbstract;
use phpOMS\Module\WebInterface;
use phpOMS\System\MimeType;
use phpOMS\Views\View;
use phpOMS\Message\Http\RequestStatusCode;

/**
 * Admin controller class.
 *
 * @category   Modules
 * @package    Modules\Admin
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
class Controller extends ModuleAbstract implements WebInterface
{

    /**
     * Module path.
     *
     * @var string
     * @since 1.0.0
     */
    /* public */ const MODULE_PATH = __DIR__;

    /**
     * Module version.
     *
     * @var string
     * @since 1.0.0
     */
    /* public */ const MODULE_VERSION = '1.0.0';

    /**
     * Module name.
     *
     * @var string
     * @since 1.0.0
     */
    /* public */ const MODULE_NAME = 'Admin';

    /**
     * Module id.
     *
     * @var int
     * @since 1.0.0
     */
    /* public */ const MODULE_ID = 1000100000;

    /**
     * Providing.
     *
     * @var string
     * @since 1.0.0
     */
    protected static $providing = [];

    /**
     * Dependencies.
     *
     * @var string
     * @since 1.0.0
     */
    protected static $dependencies = [];

    /**
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param mixed            $data     Generic data
     *
     * @return \Serializable
     *
     * @since  1.0.0
     * @codeCoverageIgnore
     */
    public function viewSettingsGeneral(RequestAbstract $request, ResponseAbstract $response, $data = null) : \Serializable
    {
        $settings = $this->app->appSettings->get([
            1000000009,
            1000000019,
            1000000020,
            1000000021,
            1000000022,
            1000000023,
            1000000027,
            1000000028,
        ]);

        $view = new View($this->app, $request, $response);
        $view->setTemplate('/Modules/Admin/Theme/Backend/settings-general');
        $view->addData('nav', $this->app->moduleManager->get('Navigation')->createNavigationMid(1000104001, $request, $response));

        $view->setData('oname', $settings[1000000009]);
        $view->setData('country', $settings[1000000019]);
        $view->setData('timezone', $settings[1000000021]);
        $view->setData('timeformat', $settings[1000000022]);
        $view->setData('language', $settings[1000000020]);
        $view->setData('currency', $settings[1000000023]);
        $view->setData('decimal_point', $settings[1000000027]);
        $view->setData('thousands_sep', $settings[1000000028]);
        $view->setData('countries', $settings[1000000028]);

        return $view;
    }

    /**
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param mixed            $data     Generic data
     *
     * @return \Serializable
     *
     * @since  1.0.0
     * @codeCoverageIgnore
     */
    public function viewAccountList(RequestAbstract $request, ResponseAbstract $response, $data = null) : \Serializable
    {
        $view = new View($this->app, $request, $response);
        $view->setTemplate('/Modules/Admin/Theme/Backend/accounts-list');
        $view->addData('nav', $this->app->moduleManager->get('Navigation')->createNavigationMid(1000104001, $request, $response));

        $view->setData('list:elements', AccountMapper::getAll());
        $view->setData('list:count', 1);

        return $view;
    }

    /**
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param mixed            $data     Generic data
     *
     * @return \Serializable
     *
     * @since  1.0.0
     * @codeCoverageIgnore
     */
    public function viewAccountSettings(RequestAbstract $request, ResponseAbstract $response, $data = null) : \Serializable
    {
        $view = new View($this->app, $request, $response);
        $view->setTemplate('/Modules/Admin/Theme/Backend/accounts-single');
        $view->addData('nav', $this->app->moduleManager->get('Navigation')->createNavigationMid(1000104001, $request, $response));

        $view->addData('account', AccountMapper::get((int) $request->getData('id')));

        $permissions = AccountPermissionMapper::getFor((int) $request->getData('id'), 'account');

        if (!isset($permissions) || $permissions instanceof NullAccountPermission) {
            $permissions = [];
        } elseif (!is_array($permissions)) {
            $permissions = [$permissions];
        }

        $view->addData('permissions', $permissions);

        return $view;
    }

    /**
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param mixed            $data     Generic data
     *
     * @return \Serializable
     *
     * @since  1.0.0
     * @codeCoverageIgnore
     */
    public function viewAccountCreate(RequestAbstract $request, ResponseAbstract $response, $data = null) : \Serializable
    {
        $view = new View($this->app, $request, $response);
        $view->setTemplate('/Modules/Admin/Theme/Backend/accounts-create');
        $view->addData('nav', $this->app->moduleManager->get('Navigation')->createNavigationMid(1000104001, $request, $response));

        return $view;
    }

    /**
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param mixed            $data     Generic data
     *
     * @return \Serializable
     *
     * @since  1.0.0
     * @codeCoverageIgnore
     */
    public function viewGroupList(RequestAbstract $request, ResponseAbstract $response, $data = null) : \Serializable
    {
        $view = new View($this->app, $request, $response);
        $view->setTemplate('/Modules/Admin/Theme/Backend/groups-list');
        $view->addData('nav', $this->app->moduleManager->get('Navigation')->createNavigationMid(1000103001, $request, $response));

        $view->setData('list:elements', GroupMapper::getAll());

        return $view;
    }

    /**
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param mixed            $data     Generic data
     *
     * @return \Serializable
     *
     * @since  1.0.0
     * @codeCoverageIgnore
     */
    public function viewGroupSettings(RequestAbstract $request, ResponseAbstract $response, $data = null) : \Serializable
    {
        $view = new View($this->app, $request, $response);
        $view->setTemplate('/Modules/Admin/Theme/Backend/groups-single');
        $view->addData('nav', $this->app->moduleManager->get('Navigation')->createNavigationMid(1000103001, $request, $response));

        $view->addData('group', GroupMapper::get((int) $request->getData('id')));

        $permissions = GroupPermissionMapper::getFor((int) $request->getData('id'), 'group');
        
        if (!isset($permissions) || $permissions instanceof NullGroupPermission) {
            $permissions = [];
        } elseif (!is_array($permissions)) {
            $permissions = [$permissions];
        }

        $view->addData('permissions', $permissions);

        return $view;
    }

    /**
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param mixed            $data     Generic data
     *
     * @return \Serializable
     *
     * @since  1.0.0
     * @codeCoverageIgnore
     */
    public function viewGroupCreate(RequestAbstract $request, ResponseAbstract $response, $data = null) : \Serializable
    {
        $view = new View($this->app, $request, $response);
        $view->setTemplate('/Modules/Admin/Theme/Backend/groups-create');
        $view->addData('nav', $this->app->moduleManager->get('Navigation')->createNavigationMid(1000103001, $request, $response));

        return $view;
    }

    /**
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param mixed            $data     Generic data
     *
     * @return \Serializable
     *
     * @since  1.0.0
     * @codeCoverageIgnore
     */
    public function viewModuleList(RequestAbstract $request, ResponseAbstract $response, $data = null) : \Serializable
    {
        $view = new View($this->app, $request, $response);
        $view->setTemplate('/Modules/Admin/Theme/Backend/modules-list');

        return $view;
    }

    /**
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param mixed            $data     Generic data
     *
     * @return \Serializable
     *
     * @since  1.0.0
     * @codeCoverageIgnore
     */
    public function viewModuleProfile(RequestAbstract $request, ResponseAbstract $response, $data = null) : \Serializable
    {
        $view = new View($this->app, $request, $response);
        $view->setTemplate('/Modules/Admin/Theme/Backend/modules-single');

        return $view;
    }

    public function apiSettingsGet(RequestAbstract $request, ResponseAbstract $response, $data = null)
    {
        $response->set('settings', $this->app->appSettings->get($request->getData('id')));
    }

    public function apiSettingsSet(RequestAbstract $request, ResponseAbstract $response, $data = null)
    {
        $success = $this->app->appSettings->set((array) $request->getData('settings'), true);

        $response->set('settings', $success);
    }

    public function apiGroupGet(RequestAbstract $request, ResponseAbstract $response, $data = null)
    {
        $response->set('group', GroupMapper::getByRequest($request));
    }

    private function validateGroupCreate(RequestAbstract $request) : array
    {
        $val = [];
        if (
            ($val['name'] = empty($request->getData('name')))
            || ($val['status'] = (
                $request->getData('status') === null
                || !GroupStatus::isValidValue((int) $request->getData('status'))
            ))
        ) {
            return $val;
        }

        return [];
    }

    public function apiGroupCreate(RequestAbstract $request, ResponseAbstract $response, $data = null)
    {
        if (!empty($val = $this->validateGroupCreate($request))) {
            $response->set('group_create', new FormValidation($val));

            return;
        }

        $group = $this->createGroupFromRequest($request);

        GroupMapper::create($group);
        $response->set('group', $group->__toString());
    }

    private function createGroupFromRequest(RequestAbstract $request) : Group
    {
        $group = new Group();
        $group->setName($request->getData('name') ?? '');
        $group->setStatus((int) $request->getData('status'));
        $group->setDescription($request->getData('description') ?? '');

        return $group;
    }

    public function apiGroupDelete(RequestAbstract $request, ResponseAbstract $response, $data = null)
    {
        $status = GroupMapper::delete($request->getData('id'));

        $response->set('group', $status);
    }

    public function apiGroupUpdate(RequestAbstract $request, ResponseAbstract $response, $data = null)
    {
        $group = GroupMapper::get($request->getData('id'));
        $group->setName($request->getData('name'));
        $group->setDescription($request->getData('desc'));

        $status = GroupMapper::update($group);

        $response->set('group', ['status' => $status, 'group' => $group->__toString()]);
    }

    public function apiAccountGet(RequestAbstract $request, ResponseAbstract $response, $data = null)
    {
        $response->getHeader()->set('Content-Type', MimeType::M_JSON . '; charset=utf-8', true);
        $response->set('account', AccountMapper::getByRequest($request));
    }

    public function apiAccountFind(RequestAbstract $request, ResponseAbstract $response, $data = null)
    {
        $response->getHeader()->set('Content-Type', MimeType::M_JSON . '; charset=utf-8', true);
        $response->set('account', array_values(AccountMapper::find($request->getData('search') ?? '')));
    }

    private function validateAccountCreate(RequestAbstract $request) : array
    {
        $val = [];
        if (
            ($val['name'] = empty($request->getData('name')))
            || ($val['name1'] = empty($request->getData('name1')))
            || ($val['type'] = !AccountType::isValidValue((int) $request->getData('type')))
            || ($val['status'] = !AccountStatus::isValidValue((int) $request->getData('status')))
        ) {
            return $val;
        }

        return [];
    }

    public function apiAccountCreate(RequestAbstract $request, ResponseAbstract $response, $data = null)
    {
        if (!empty($val = $this->validateAccountCreate($request))) {
            $response->set('account_create', new FormValidation($val));

            return;
        }

        $account = $this->createAccountFromRequest($request);

        AccountMapper::create($account);
        $response->set('account', $account->jsonSerialize());
    }

    private function createAccountFromRequest(RequestAbstract $request) : Account
    {
        $account = new Account();
        $account->setStatus($request->getData('status'));
        $account->setType($request->getData('type'));
        $account->setName($request->getData('name'));
        $account->setName1($request->getData('name1'));
        $account->setName2($request->getData('name2'));
        $account->setName3($request->getData('name3'));
        $account->setEmail($request->getData('email'));
        $account->generatePassword($request->getData('password'));

        return $account;
    }

    public function apiAccountDelete(RequestAbstract $request, ResponseAbstract $response, $data = null)
    {
        $status = AccountMapper::delete($request->getData('id'));

        $response->set('account', $status);
    }

    public function apiAccountUpdate(RequestAbstract $request, ResponseAbstract $response, $data = null)
    {
        $account = AccountMapper::get($request->getData('id'));
        $account->setName($request->getData('name'));

        $status = AccountMapper::update($account);

        $response->set('account', ['status' => $status, 'account' => $account->jsonSerialize()]);
    }

    public function apiModuleStatusUpdate(RequestAbstract $request, ResponseAbstract $response, $data = null)
    {
        $module = $request->getData('module');
        $status = $request->getData('status');

        if (!$module || !$status) {
            // todo: create failure response
        }

        switch ($status) {
            case 'activate':
                $done = $this->app->moduleManager->activate($module);
                break;
            case 'deactivate':
                $done = $this->app->moduleManager->deactivate($module);
                break;
            case 'install':
                $done = $this->app->moduleManager->install($module);
                break;
            case 'uninstall':
                //$done = $this->app->moduleManager->uninstall($module);
                $done = true;
                break;
            default:
                $done = false;
        }

        $response->set('module', [$status => $done, 'module' => $module]);
    }
}
