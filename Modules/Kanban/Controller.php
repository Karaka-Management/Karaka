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
namespace Modules\Kanban;

use phpOMS\Message\RequestAbstract;
use phpOMS\Message\ResponseAbstract;
use phpOMS\Module\ModuleAbstract;
use phpOMS\Module\WebInterface;
use phpOMS\Views\View;
use phpOMS\Asset\AssetType;
use phpOMS\Account\PermissionType;
use phpOMS\Message\Http\RequestStatusCode;

use Modules\Kanban\Models\PermissionState;
use Modules\Kanban\Models\KanbanBoard;
use Modules\Kanban\Models\KanbanBoardMapper;
use Modules\Kanban\Models\KanbanLabel;
use Modules\Kanban\Models\KanbanLabelMapper;
use Modules\Kanban\Models\KanbanColumn;
use Modules\Kanban\Models\KanbanColumnMapper;
use Modules\Kanban\Models\KanbanCard;
use Modules\Kanban\Models\KanbanCardMapper;
use Modules\Kanban\Models\KanbanCardComment;
use Modules\Kanban\Models\KanbanCardCommentMapper;
use Modules\Kanban\Models\CardStatus;
use Modules\Kanban\Models\CardType;
use Modules\Kanban\Models\BoardStatus;

/**
 * Task class.
 *
 * @category   Modules
 * @package    Modules\Kanban
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
    /* public */ const MODULE_NAME = 'Kanban';

    /**
     * Module id.
     *
     * @var int
     * @since 1.0.0
     */
    /* public */ const MODULE_ID = 1005800000;

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
    public function setupStyles(RequestAbstract $request, ResponseAbstract $response, $data = null)
    {
        /** @var Head $head */
        $head = $response->get('Content')->getData('head');
        $head->addAsset(AssetType::CSS, '/Modules/Kanban/Theme/Backend/css/styles.css');
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
    public function viewKanbanDashboard(RequestAbstract $request, ResponseAbstract $response, $data = null) : \Serializable
    {
        $view = new View($this->app, $request, $response);

        if (!$this->app->accountManager->get($request->getHeader()->getAccount())->hasPermission(
            PermissionType::READ, $this->app->orgId, $this->app->appName, self::MODULE_ID, PermissionState::DASHBOARD)
        ) {
            $view->setTemplate('/Web/Backend/Error/403_inline');
            $response->getHeader()->setStatusCode(RequestStatusCode::R_403);
            return $view;
        }

        $view->setTemplate('/Modules/Kanban/Theme/Backend/kanban-dashboard');
        $view->addData('nav', $this->app->moduleManager->get('Navigation')->createNavigationMid(1005801001, $request, $response));

        $list = KanbanBoardMapper::getNewest(50);
        $view->setData('boards', $list);

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
    public function viewKanbanBoard(RequestAbstract $request, ResponseAbstract $response, $data = null) : \Serializable
    {
        $view = new View($this->app, $request, $response);

        $board = KanbanBoardMapper::get((int) $request->getData('id'));
        $accountId = $request->getHeader()->getAccount();
        
        if ($board->getCreatedBy()->getId() !== $accountId
            && !$this->app->accountManager->get($accountId)->hasPermission(
                PermissionType::READ, $this->app->orgId, $this->app->appName, self::MODULE_ID, PermissionState::BOARD, $board->getId())
        ) {
            $view->setTemplate('/Web/Backend/Error/403_inline');
            $response->getHeader()->setStatusCode(RequestStatusCode::R_403);
            return $view;
        }

        $view->setTemplate('/Modules/Kanban/Theme/Backend/kanban-board');
        $view->addData('nav', $this->app->moduleManager->get('Navigation')->createNavigationMid(1005801001, $request, $response));

        $view->setData('board', $board);

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
    public function viewKanbanBoardCreate(RequestAbstract $request, ResponseAbstract $response, $data = null) : \Serializable
    {
        $view = new View($this->app, $request, $response);

        $accountId = $request->getHeader()->getAccount();

        if (!$this->app->accountManager->get($accountId)->hasPermission(
                PermissionType::CREATE, $this->app->orgId, $this->app->appName, self::MODULE_ID, PermissionState::BOARD)
        ) {
            $view->setTemplate('/Web/Backend/Error/403_inline');
            $response->getHeader()->setStatusCode(RequestStatusCode::R_403);
            return $view;
        }

        $view->setTemplate('/Modules/Kanban/Theme/Backend/kanban-board-create');
        $view->addData('nav', $this->app->moduleManager->get('Navigation')->createNavigationMid(1005801001, $request, $response));

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
    public function viewKanbanCard(RequestAbstract $request, ResponseAbstract $response, $data = null) : \Serializable
    {
        $view = new View($this->app, $request, $response);

        $card = KanbanCardMapper::get((int) $request->getData('id'));
        $accountId = $request->getHeader()->getAccount();

        if ($card->getCreatedBy()->getId() !== $accountId
            && !$this->app->accountManager->get($accountId)->hasPermission(
                PermissionType::READ, $this->app->orgId, $this->app->appName, self::MODULE_ID, PermissionState::CARD, $card->getId())
        ) {
            $view->setTemplate('/Web/Backend/Error/403_inline');
            $response->getHeader()->setStatusCode(RequestStatusCode::R_403);
            return $view;
        }

        $view->setTemplate('/Modules/Kanban/Theme/Backend/kanban-card');
        $view->addData('nav', $this->app->moduleManager->get('Navigation')->createNavigationMid(1005801001, $request, $response));
        $view->setData('card', $card);

        return $view;
    }

    public function apiKanbanCardCreate(RequestAbstract $request, ResponseAbstract $response, $data = null)
    {
        if (!$this->app->accountManager->get($request->getHeader()->getAccount())->hasPermission(
            PermissionType::CREATE, $this->app->orgId, $this->app->appName, self::MODULE_ID, PermissionState::CARD)
        ) {
            $response->set('kanban_card_create', null);
            $response->getHeader()->setStatusCode(RequestStatusCode::R_403);
            return;
        }

        if (!empty($val = $this->validateKanbanCardCreate($request))) {
            $response->set('kanban_card_create', new FormValidation($val));

            return;
        }

        $card = $this->createKanbanCardFromRquest($request);
        KanbanCardMapper::create($card);
        $response->set('card', $card->jsonSerialize());
    }

    public function createKanbanCardFromRquest(RequestAbstract $request) : KanbanCard
    {
        $mardkownParser = new Markdown();
        
        $card = new KanbanCard();
        $card->setName((string) ($request->getData('title')));
        $card->setDescription((string) ($request->getData('plain')));
        $card->setColumn((int) $request->getData('column'));
        $card->setOrder((int) $request->getData('order'));
        $card->setRef((int) $request->getData('ref'));
        $card->setLabels((array) $request->getData('labels'));
        $card->setStatus((int) $request->getData('status'));
        $card->setType((int) $request->getData('type'));

        return $card;
    }

    private function validateKanbanCardCreate(RequestAbstract $request) : array
    {
        $val = [];
        if (
            ($val['title'] = empty($request->getData('title')))
            || ($val['plain'] = empty($request->getData('plain')))
            || ($val['column'] = empty($request->getData('column')))
            || ($val['order'] = empty($request->getData('order')))
            || ($val['ref'] = empty($request->getData('ref')))
            || ($val['labels'] = empty($request->getData('labels')))
            || ($val['status'] = (
                $request->getData('status') !== null
                && !CardStatus::isValidValue((int) $request->getData('status'))
            ))
            || ($val['type'] = (
                $request->getData('type') === null
                || !CardType::isValidValue((int) $request->getData('type'))
            ))
        ) {
            return $val;
        }

        return [];
    }

    public function apiKanbanBoardCreate(RequestAbstract $request, ResponseAbstract $response, $data = null)
    {
        if (!$this->app->accountManager->get($request->getHeader()->getAccount())->hasPermission(
            PermissionType::CREATE, $this->app->orgId, $this->app->appName, self::MODULE_ID, PermissionState::BOARD)
        ) {
            $response->set('kanban_board_create', null);
            $response->getHeader()->setStatusCode(RequestStatusCode::R_403);
            return;
        }

        if (!empty($val = $this->validateKanbanBoardCreate($request))) {
            $response->set('kanban_board_create', new FormValidation($val));

            return;
        }

        $board = $this->createKanbanBoardFromRquest($request);
        KanbanBoardMapper::create($board);
        $response->set('board', $board->jsonSerialize());
    }

    public function createKanbanBoardFromRquest(RequestAbstract $request) : KanbanBoard
    {
        $mardkownParser = new Markdown();
        
        $board = new KanbanBoard();
        $board->setName((string) $request->getData('title'));
        $board->setDescription((string) $request->getData('plain'));
        $board->setOrder((int) $request->getData('order'));
        $board->setStatus((int) $request->getData('status'));

        return $board;
    }

    private function validateKanbanBoardCreate(RequestAbstract $request) : array
    {
        $val = [];
        if (
            ($val['title'] = empty($request->getData('title')))
            || ($val['plain'] = empty($request->getData('plain')))
            || ($val['order'] = empty($request->getData('order')))
            || ($val['status'] = (
                $request->getData('status') !== null
                && !CardStatus::isValidValue((int) $request->getData('status'))
            ))
        ) {
            return $val;
        }

        return [];
    }

    public function apiKanbanColumnCreate(RequestAbstract $request, ResponseAbstract $response, $data = null)
    {
        if (!$this->app->accountManager->get($request->getHeader()->getAccount())->hasPermission(
            PermissionType::CREATE, $this->app->orgId, $this->app->appName, self::MODULE_ID, PermissionState::COLUMN)
        ) {
            $response->set('kanban_column_create', null);
            $response->getHeader()->setStatusCode(RequestStatusCode::R_403);
            return;
        }

        if (!empty($val = $this->validateKanbanColumnCreate($request))) {
            $response->set('kanban_column_create', new FormValidation($val));

            return;
        }

        $column = $this->createKanbanColumnFromRquest($request);
        KanbanColumnMapper::create($column);
        $response->set('column', $column->jsonSerialize());
    }

    public function createKanbanColumnFromRquest(RequestAbstract $request) : KanbanColumn
    {
        $mardkownParser = new Markdown();
        
        $column = new KanbanColumn();
        $column->setName((string) $request->getData('title'));
        $column->setOrder((int) $request->getData('order'));

        return $column;
    }

    private function validateKanbanColumnCreate(RequestAbstract $request) : array
    {
        $val = [];
        if (
            ($val['title'] = empty($request->getData('title')))
            || ($val['order'] = empty($request->getData('order')))
        ) {
            return $val;
        }

        return [];
    }

    public function apiKanbanLabelCreate(RequestAbstract $request, ResponseAbstract $response, $data = null)
    {
        $account = $this->app->accountManager->get($request->getHeader()->getAccount());

        if (!$account->hasPermission(PermissionType::CREATE, $this->app->orgId, $this->app->appName, self::MODULE_ID, PermissionState::BOARD)
            && !$account->hasPermission(PermissionType::CREATE, $this->app->orgId, $this->app->appName, self::MODULE_ID, PermissionState::LABEL)
        ) {
            $response->set('kanban_label_create', null);
            $response->getHeader()->setStatusCode(RequestStatusCode::R_403);
            return;
        }

        if (!empty($val = $this->validateKanbanLabelCreate($request))) {
            $response->set('kanban_label_create', new FormValidation($val));

            return;
        }

        $label = $this->createKanbanLabelFromRquest($request);
        KanbanLabelMapper::create($label);
        $response->set('label', $label->jsonSerialize());
    }

    public function createKanbanLabelFromRquest(RequestAbstract $request) : KanbanLabel
    {
        $label = new KanbanLabel();
        $label->setName($request->getData('title'));
        $label->setBoard((int) $request->getData('board'));
        $label->setcolor((int) $request->getData('color'));

        return $label;
    }

    private function validateKanbanLabelCreate(RequestAbstract $request) : array
    {
        $val = [];
        if (
            ($val['title'] = empty($request->getData('title')))
            || ($val['board'] = empty($request->getData('board')))
            || ($val['color'] = empty($request->getData('color')))
        ) {
            return $val;
        }

        return [];
    }
}
