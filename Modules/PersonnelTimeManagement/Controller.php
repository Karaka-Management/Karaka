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
namespace Modules\PersonnelTimeManagement;

use Modules\Navigation\Models\Navigation;
use phpOMS\Message\RequestAbstract;
use phpOMS\Message\ResponseAbstract;
use phpOMS\Module\ModuleAbstract;
use phpOMS\Module\WebInterface;
use phpOMS\Views\View;

/**
 * Support controller class.
 *
 * @category   Modules
 * @package    Modules\Support
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
    /* public */ const MODULE_NAME = 'PersonnelTimeManagement';

    /**
     * Module id.
     *
     * @var int
     * @since 1.0.0
     */
    /* public */ const MODULE_ID = 1003500000;

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
     * {@inheritdoc}
     */
    public function call(RequestAbstract $request, ResponseAbstract $response, $data = null)
    {
        switch ($request->getPath(1)) {
            case RequestDestination::BACKEND:
                $this->showContentBackend($request, $response);
                break;
        }
    }

    /**
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function showContentBackend($request, $response)
    {
        // TODO: pull abstract view creation and output out. let error be a view as well -> less code writing
        switch ($request->getPath(2)) {
            case 'hr':
                $this->showContentTimemgmtBackend($request, $response);
                break;
            case 'private':
                $this->showContentBackendPrivate($request, $response);
                break;
        }
    }

    /**
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function showContentTimemgmtBackend($request, $response)
    {
        if ($request->getPath(3) === 'timemgmt') {
            switch ($request->getPath(4)) {
                case 'dashboard':
                    $timemgmtDashboardView = new View($this->app, $request, $response);
                    $timemgmtDashboardView->setTemplate('/Modules/PersonnelTimeManagement/Theme/Backend/timemanagement-list');

                    $navigation = Navigation::getInstance($request, $this->app->dbPool);
                    $timemgmtDashboardView->addData('nav', $navigation->getNav());
                    echo $timemgmtDashboardView->render();
                    break;
                case 'single':
                    $timemgmtSingleView = new View($this->app, $request, $response);
                    $timemgmtSingleView->setTemplate('/Modules/PersonnelTimeManagement/Theme/Backend/timemanagement-single');

                    $navigation = Navigation::getInstance($request, $this->app->dbPool);
                    $timemgmtSingleView->addData('nav', $navigation->getNav());
                    echo $timemgmtSingleView->render();
                    break;
            }
        }
    }

    /**
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function showContentBackendPrivate($request, $response)
    {
        switch ($request->getPath(4)) {
            case 'dashboard':
                $timemgmtDashboardView = new View($this->app, $request, $response);
                $timemgmtDashboardView->setTemplate('/Modules/PersonnelTimeManagement/Theme/Backend/user-timemanagement-dashboard');

                $navigation = Navigation::getInstance($request, $this->app->dbPool);
                $timemgmtDashboardView->addData('nav', $navigation->getNav());
                echo $timemgmtDashboardView->render();
                break;
        }
    }
}
