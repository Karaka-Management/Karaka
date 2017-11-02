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
 * @link       http://orange-management.com
 */
declare(strict_types = 1);
namespace Modules\Knowledgebase;

use phpOMS\Message\RequestAbstract;
use phpOMS\Message\ResponseAbstract;
use phpOMS\Module\ModuleAbstract;
use phpOMS\Module\WebInterface;
use phpOMS\Views\View;
use phpOMS\Asset\AssetType;
use phpOMS\Account\PermissionType;
use phpOMS\Message\Http\RequestStatusCode;

use Modules\Knowledgebase\Models\WikiCategoryMapper;
use Modules\Knowledgebase\Models\NullWikiCategory;
use Modules\Knowledgebase\Models\WikiDocMapper;
use Modules\Knowledgebase\Models\NullWikiDoc;
use Modules\Knowledgebase\Models\WikiStatus;
use Modules\Knowledgebase\Models\WikiStatusMapper;
use Modules\Knowledgebase\Models\WikiDoc;
use Modules\Knowledgebase\Models\WikiCategory;
use Modules\Knowledgebase\Models\WikiBadge;
use Modules\Knowledgebase\Models\PermissionState;

/**
 * Task class.
 *
 * @category   Modules
 * @package    Modules\Knowledgebase
 * @license    OMS License 1.0
 * @link       http://orange-management.com
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
    /* public */ const MODULE_NAME = 'Knowledgebase';

    /**
     * Module id.
     *
     * @var int
     * @since 1.0.0
     */
    /* public */ const MODULE_ID = 1005900000;

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
    protected static $dependencies = [
    ];

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
    public function setUpBackend(RequestAbstract $request, ResponseAbstract $response, $data = null)
    {
        $head = $response->get('Content')->getData('head');
        $head->addAsset(AssetType::CSS, $request->getUri()->getBase() . 'Modules/Knowledgebase/Theme/Backend/styles.css');
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
    public function viewKnowledgebaseDashboard(RequestAbstract $request, ResponseAbstract $response, $data = null) : \Serializable
    {
        $view = new View($this->app, $request, $response);

        if (!$this->app->accountManager->get($request->getHeader()->getAccount())->hasPermission(
            PermissionType::READ, $this->app->orgId, $this->app->appName, self::MODULE_ID, PermissionState::DASHBOARD)
        ) {
            $view->setTemplate('/Web/Backend/Error/403_inline');
            return $view;
        }

        $view->setTemplate('/Modules/Knowledgebase/Theme/Backend/wiki-dashboard');
        $view->addData('nav', $this->app->moduleManager->get('Navigation')->createNavigationMid(1005901001, $request, $response));

        $list = WikiCategoryMapper::getNewest(50);
        $view->setData('categories', $list);

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
    public function viewKnowledgebaseCategoryList(RequestAbstract $request, ResponseAbstract $response, $data = null) : \Serializable
    {
        $view = new View($this->app, $request, $response);

        if (!$this->app->accountManager->get($request->getHeader()->getAccount())->hasPermission(
            PermissionType::READ, $this->app->orgId, $this->app->appName, self::MODULE_ID, PermissionState::DASHBOARD)
        ) {
            $view->setTemplate('/Web/Backend/Error/403_inline');
            return $view;
        }

        $view->setTemplate('/Modules/Knowledgebase/Theme/Backend/wiki-category-list');
        $view->addData('nav', $this->app->moduleManager->get('Navigation')->createNavigationMid(1005901001, $request, $response));

        $list = WikiCategoryMapper::getAll();
        $view->setData('categories', $list);

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
    public function viewKnowledgebaseCategory(RequestAbstract $request, ResponseAbstract $response, $data = null) : \Serializable
    {
        $view = new View($this->app, $request, $response);

        $view->setTemplate('/Modules/Knowledgebase/Theme/Backend/wiki-category-single');
        $view->addData('nav', $this->app->moduleManager->get('Navigation')->createNavigationMid(1005901001, $request, $response));

        $category = WikiCategoryMapper::get((int) $request->getData('id'));
        $view->setData('category', $category);

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
    public function viewKnowledgebaseCategoryCreate(RequestAbstract $request, ResponseAbstract $response, $data = null) : \Serializable
    {
        $view = new View($this->app, $request, $response);
        $view->setTemplate('/Modules/Knowledgebase/Theme/Backend/wiki-category-single');
        $view->addData('nav', $this->app->moduleManager->get('Navigation')->createNavigationMid(1005901001, $request, $response));

        $view->setData('category', new NullWikiCategory());

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
    public function viewKnowledgebaseDoc(RequestAbstract $request, ResponseAbstract $response, $data = null) : \Serializable
    {
        $view = new View($this->app, $request, $response);

        $category = WikiDocMapper::get((int) $request->getData('id'));
        $accountId = $request->getHeader()->getAccount();

        if (!$this->app->accountManager->get($accountId)->hasPermission(
                PermissionType::READ, $this->app->orgId, $this->app->appName, self::MODULE_ID, PermissionState::DOC, $category->getId())
        ) {
            $view->setTemplate('/Web/Backend/Error/403_inline');
            $response->getHeader()->setStatusCode(RequestStatusCode::R_403);
            return $view;
        }
        
        $view->setTemplate('/Modules/Knowledgebase/Theme/Backend/wiki-category-single');
        $view->addData('nav', $this->app->moduleManager->get('Navigation')->createNavigationMid(1005901001, $request, $response));
        $view->setData('category', $category);

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
    public function viewKnowledgebaseDocCreate(RequestAbstract $request, ResponseAbstract $response, $data = null) : \Serializable
    {
        $view = new View($this->app, $request, $response);

        if (!$this->app->accountManager->get($request->getHeader()->getAccount())->hasPermission(
            PermissionType::CREATE, $this->app->orgId, $this->app->appName, self::MODULE_ID, PermissionState::DOC)
        ) {
            $view->setTemplate('/Web/Backend/Error/403_inline');
            $response->getHeader()->setStatusCode(RequestStatusCode::R_403);
            return $view;
        }

        $view->setTemplate('/Modules/Knowledgebase/Theme/Backend/wiki-category-single');
        $view->addData('nav', $this->app->moduleManager->get('Navigation')->createNavigationMid(1005901001, $request, $response));

        $view->setData('category', new NullWikiDoc());

        return $view;
    }

    public function apiWikiDocCreate(RequestAbstract $request, ResponseAbstract $response, $data = null)
    {
        if (!$this->app->accountManager->get($request->getHeader()->getAccount())->hasPermission(
            PermissionType::CREATE, $this->app->orgId, $this->app->appName, self::MODULE_ID, PermissionState::DOC)
        ) {
            $response->set('wiki_doc_create', null);
            $response->getHeader()->setStatusCode(RequestStatusCode::R_403);
            return;
        }

        if (!empty($val = $this->validateWikiDocCreate($request))) {
            $response->set('wiki_doc_create', new FormValidation($val));

            return;
        }

        $doc = $this->createWikiDocFromRquest($request);
        WikiDocMapper::create($doc);
        $response->set('doc', $doc->jsonSerialize());
    }

    public function createWikiDocFromRquest(RequestAbstract $request) : WikiDoc
    {
        $mardkownParser = new Markdown();
        
        $doc = new WikiDoc();
        $doc->setName($request->getData('title'));
        $doc->setDoc($request->getData('plain'));
        $doc->setCategory((int) $request->getData('category'));
        $doc->setBadges((array) $request->getData('badges'));
        $doc->setStatus((int) $request->getData('status'));

        return $doc;
    }

    private function validateWikiDocCreate(RequestAbstract $request) : array
    {
        $val = [];
        if (
            ($val['title'] = empty($request->getData('title')))
            || ($val['plain'] = empty($request->getData('plain')))
            || ($val['category'] = empty($request->getData('category')))
            || ($val['badges'] = empty($request->getData('badges')))
            || ($val['status'] = (
                $request->getData('status') !== null
                && !WikiStatus::isValidValue(strtolower($request->getData('status')))
            ))
        ) {
            return $val;
        }

        return [];
    }

    public function apiWikiCategoryCreate(RequestAbstract $request, ResponseAbstract $response, $data = null)
    {
        if (!empty($val = $this->validateWikiCategoryCreate($request))) {
            $response->set('wiki_category_create', new FormValidation($val));

            return;
        }

        $category = $this->createWikiCategoryFromRquest($request);
        WikiCategoryMapper::create($category);
        $response->set('category', $category->jsonSerialize());
    }

    public function createWikiCategoryFromRquest(RequestAbstract $request) : WikiCategory
    {
        $mardkownParser = new Markdown();
        
        $category = new WikiCategory();
        $category->setName($request->getData('title'));
        $category->setParent((int) $request->getData('parent'));

        return $category;
    }

    private function validateWikiCategoryCreate(RequestAbstract $request) : array
    {
        $val = [];
        if (
            ($val['title'] = empty($request->getData('title')))
            || ($val['parent'] = empty($request->getData('parent')))
        ) {
            return $val;
        }

        return [];
    }

    public function apiWikiBadgeCreate(RequestAbstract $request, ResponseAbstract $response, $data = null)
    {
        if (!empty($val = $this->validateWikiBadgeCreate($request))) {
            $response->set('wiki_badge_create', new FormValidation($val));

            return;
        }

        $badge = $this->createWikiBadgeFromRquest($request);
        WikiBadgeMapper::create($badge);
        $response->set('badge', $badge->jsonSerialize());
    }

    public function createWikiBadgeFromRquest(RequestAbstract $request) : WikiBadge
    {
        $mardkownParser = new Markdown();
        
        $badge = new WikiBadge();
        $badge->setName($request->getData('title'));

        return $badge;
    }

    private function validateWikiBadgeCreate(RequestAbstract $request) : array
    {
        $val = [];
        if (
            ($val['title'] = empty($request->getData('title')))
        ) {
            return $val;
        }

        return [];
    }
}
