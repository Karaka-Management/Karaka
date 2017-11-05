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
namespace Modules\RiskManagement;

use Modules\Navigation\Models\Navigation;
use Modules\Navigation\Views\NavigationView;
use phpOMS\Contract\RenderableInterface;
use phpOMS\Message\RequestAbstract;
use phpOMS\Message\ResponseAbstract;
use phpOMS\Module\ModuleAbstract;
use phpOMS\Module\WebInterface;
use phpOMS\Views\View;
use Modules\RiskManagement\Models\SolutionMapper;
use Modules\RiskManagement\Models\CauseMapper;
use Modules\RiskManagement\Models\RiskMapper;
use Modules\RiskManagement\Models\DepartmentMapper;
use Modules\RiskManagement\Models\CategoryMapper;
use Modules\RiskManagement\Models\ProjectMapper;
use Modules\RiskManagement\Models\ProcessMapper;
use Modules\Organization\Models\UnitMapper;
use Modules\Organization\Models\Unit;

/**
 * Risk Management class.
 *
 * @category   Modules
 * @package    Modules\RiskManagement
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
    /* public */ const MODULE_NAME = 'RiskManagement';

    /**
     * Module id.
     *
     * @var int
     * @since 1.0.0
     */
    /* public */ const MODULE_ID = 1003000000;

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
        'Media'
    ];

    /**
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param mixed            $data     Generic data
     *
     * @return RenderableInterface
     *
     * @since  1.0.0
     * @codeCoverageIgnore
     */
    public function viewRiskCockpit(RequestAbstract $request, ResponseAbstract $response, $data = null) : \Serializable
    {
        $view = new View($this->app, $request, $response);
        $view->setTemplate('/Modules/RiskManagement/Theme/Backend/cockpit');
        $view->addData('nav', $this->app->moduleManager->get('Navigation')->createNavigationMid(1003001001, $request, $response));

        return $view;
    }

    /**
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param mixed            $data     Generic data
     *
     * @return RenderableInterface
     *
     * @since  1.0.0
     * @codeCoverageIgnore
     */
    public function viewRiskList(RequestAbstract $request, ResponseAbstract $response, $data = null) : \Serializable
    {
        $view = new View($this->app, $request, $response);
        $view->setTemplate('/Modules/RiskManagement/Theme/Backend/risk-list');
        $view->addData('nav', $this->app->moduleManager->get('Navigation')->createNavigationMid(1003001001, $request, $response));

        $risks = RiskMapper::getAll();
        $view->addData('risks', $risks);

        return $view;
    }

    /**
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param mixed            $data     Generic data
     *
     * @return RenderableInterface
     *
     * @since  1.0.0
     * @codeCoverageIgnore
     */
    public function viewRiskSingle(RequestAbstract $request, ResponseAbstract $response, $data = null) : \Serializable
    {
        $view = new View($this->app, $request, $response);
        $view->setTemplate('/Modules/RiskManagement/Theme/Backend/risk-single');
        $view->addData('nav', $this->app->moduleManager->get('Navigation')->createNavigationMid(1003001001, $request, $response));

        $risk = RiskMapper::get((int) $request->getData('id'));
        $view->addData('risk', $risk);

        return $view;
    }

    /**
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param mixed            $data     Generic data
     *
     * @return RenderableInterface
     *
     * @since  1.0.0
     * @codeCoverageIgnore
     */
    public function viewRiskCreate(RequestAbstract $request, ResponseAbstract $response, $data = null) : \Serializable
    {
        $view = new View($this->app, $request, $response);
        $view->setTemplate('/Modules/RiskManagement/Theme/Backend/risk-create');
        $view->addData('nav', $this->app->moduleManager->get('Navigation')->createNavigationMid(1003001001, $request, $response));

        return $view;
    }

    /**
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param mixed            $data     Generic data
     *
     * @return RenderableInterface
     *
     * @since  1.0.0
     * @codeCoverageIgnore
     */
    public function viewRiskCauseList(RequestAbstract $request, ResponseAbstract $response, $data = null) : \Serializable
    {
        $view = new View($this->app, $request, $response);
        $view->setTemplate('/Modules/RiskManagement/Theme/Backend/cause-list');
        $view->addData('nav', $this->app->moduleManager->get('Navigation')->createNavigationMid(1003001001, $request, $response));

        $causes = CauseMapper::getAll();
        $view->addData('causes', $causes);

        return $view;
    }

    /**
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param mixed            $data     Generic data
     *
     * @return RenderableInterface
     *
     * @since  1.0.0
     * @codeCoverageIgnore
     */
    public function viewRiskCauseSingle(RequestAbstract $request, ResponseAbstract $response, $data = null) : \Serializable
    {
        $view = new View($this->app, $request, $response);
        $view->setTemplate('/Modules/RiskManagement/Theme/Backend/cause-single');
        $view->addData('nav', $this->app->moduleManager->get('Navigation')->createNavigationMid(1003001001, $request, $response));

        $cause = CauseMapper::get((int) $request->getData('id'));
        $view->addData('cause', $cause);

        return $view;
    }

    /**
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param mixed            $data     Generic data
     *
     * @return RenderableInterface
     *
     * @since  1.0.0
     * @codeCoverageIgnore
     */
    public function viewRiskSolutionList(RequestAbstract $request, ResponseAbstract $response, $data = null) : \Serializable
    {
        $view = new View($this->app, $request, $response);
        $view->setTemplate('/Modules/RiskManagement/Theme/Backend/solution-list');
        $view->addData('nav', $this->app->moduleManager->get('Navigation')->createNavigationMid(1003001001, $request, $response));

        $solutions = SolutionMapper::getAll();
        $view->addData('solutions', $solutions);

        return $view;
    }

    /**
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param mixed            $data     Generic data
     *
     * @return RenderableInterface
     *
     * @since  1.0.0
     * @codeCoverageIgnore
     */
    public function viewRiskSolutionSingle(RequestAbstract $request, ResponseAbstract $response, $data = null) : \Serializable
    {
        $view = new View($this->app, $request, $response);
        $view->setTemplate('/Modules/RiskManagement/Theme/Backend/solution-single');
        $view->addData('nav', $this->app->moduleManager->get('Navigation')->createNavigationMid(1003001001, $request, $response));

        $solution = SolutionMapper::get((int) $request->getData('id'));
        $view->addData('solution', $solution);

        return $view;
    }

    /**
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param mixed            $data     Generic data
     *
     * @return RenderableInterface
     *
     * @since  1.0.0
     * @codeCoverageIgnore
     */
    public function viewRiskUnitList(RequestAbstract $request, ResponseAbstract $response, $data = null) : \Serializable
    {
        $view = new View($this->app, $request, $response);
        $view->setTemplate('/Modules/RiskManagement/Theme/Backend/unit-list');
        $view->addData('nav', $this->app->moduleManager->get('Navigation')->createNavigationMid(1003001001, $request, $response));

        $units = UnitMapper::getAll();
        $view->addData('units', $units);

        return $view;
    }

    /**
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param mixed            $data     Generic data
     *
     * @return RenderableInterface
     *
     * @since  1.0.0
     * @codeCoverageIgnore
     */
    public function viewRiskUnitSingle(RequestAbstract $request, ResponseAbstract $response, $data = null) : \Serializable
    {
        $view = new View($this->app, $request, $response);
        $view->setTemplate('/Modules/RiskManagement/Theme/Backend/unit-single');
        $view->addData('nav', $this->app->moduleManager->get('Navigation')->createNavigationMid(1003001001, $request, $response));

        $unit = UnitMapper::get((int) $request->getData('id'));
        $view->addData('unit', $unit);

        return $view;
    }

    /**
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param mixed            $data     Generic data
     *
     * @return RenderableInterface
     *
     * @since  1.0.0
     * @codeCoverageIgnore
     */
    public function viewRiskDepartmentList(RequestAbstract $request, ResponseAbstract $response, $data = null) : \Serializable
    {
        $view = new View($this->app, $request, $response);
        $view->setTemplate('/Modules/RiskManagement/Theme/Backend/department-list');
        $view->addData('nav', $this->app->moduleManager->get('Navigation')->createNavigationMid(1003001001, $request, $response));

        $departments = DepartmentMapper::getAll();
        $view->addData('departments', $departments);

        return $view;
    }

    /**
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param mixed            $data     Generic data
     *
     * @return RenderableInterface
     *
     * @since  1.0.0
     * @codeCoverageIgnore
     */
    public function viewRiskDepartmentSingle(RequestAbstract $request, ResponseAbstract $response, $data = null) : \Serializable
    {
        $view = new View($this->app, $request, $response);
        $view->setTemplate('/Modules/RiskManagement/Theme/Backend/department-single');
        $view->addData('nav', $this->app->moduleManager->get('Navigation')->createNavigationMid(1003001001, $request, $response));

        $department = DepartmentMapper::get((int) $request->getData('id'));
        $view->addData('department', $department);

        return $view;
    }

    /**
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param mixed            $data     Generic data
     *
     * @return RenderableInterface
     *
     * @since  1.0.0
     * @codeCoverageIgnore
     */
    public function viewRiskCategoryList(RequestAbstract $request, ResponseAbstract $response, $data = null) : \Serializable
    {
        $view = new View($this->app, $request, $response);
        $view->setTemplate('/Modules/RiskManagement/Theme/Backend/category-list');
        $view->addData('nav', $this->app->moduleManager->get('Navigation')->createNavigationMid(1003001001, $request, $response));

        $categories = CategoryMapper::getAll();
        $view->addData('categories', $categories);

        return $view;
    }

    /**
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param mixed            $data     Generic data
     *
     * @return RenderableInterface
     *
     * @since  1.0.0
     * @codeCoverageIgnore
     */
    public function viewRiskCategorySingle(RequestAbstract $request, ResponseAbstract $response, $data = null) : \Serializable
    {
        $view = new View($this->app, $request, $response);
        $view->setTemplate('/Modules/RiskManagement/Theme/Backend/category-single');
        $view->addData('nav', $this->app->moduleManager->get('Navigation')->createNavigationMid(1003001001, $request, $response));

        $category = CategoryMapper::get((int) $request->getData('id'));
        $view->addData('category', $category);

        return $view;
    }

    /**
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param mixed            $data     Generic data
     *
     * @return RenderableInterface
     *
     * @since  1.0.0
     * @codeCoverageIgnore
     */
    public function viewRiskProjectList(RequestAbstract $request, ResponseAbstract $response, $data = null) : \Serializable
    {
        $view = new View($this->app, $request, $response);
        $view->setTemplate('/Modules/RiskManagement/Theme/Backend/project-list');
        $view->addData('nav', $this->app->moduleManager->get('Navigation')->createNavigationMid(1003001001, $request, $response));

        $projects = ProjectMapper::getAll();
        $view->addData('projects', $projects);

        return $view;
    }

    /**
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param mixed            $data     Generic data
     *
     * @return RenderableInterface
     *
     * @since  1.0.0
     * @codeCoverageIgnore
     */
    public function viewRiskProjectSingle(RequestAbstract $request, ResponseAbstract $response, $data = null) : \Serializable
    {
        $view = new View($this->app, $request, $response);
        $view->setTemplate('/Modules/RiskManagement/Theme/Backend/project-single');
        $view->addData('nav', $this->app->moduleManager->get('Navigation')->createNavigationMid(1003001001, $request, $response));

        $project = ProjectMapper::get((int) $request->getData('id'));
        $view->addData('project', $project);

        return $view;
    }

    /**
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param mixed            $data     Generic data
     *
     * @return RenderableInterface
     *
     * @since  1.0.0
     * @codeCoverageIgnore
     */
    public function viewRiskProcessList(RequestAbstract $request, ResponseAbstract $response, $data = null) : \Serializable
    {
        $view = new View($this->app, $request, $response);
        $view->setTemplate('/Modules/RiskManagement/Theme/Backend/process-list');
        $view->addData('nav', $this->app->moduleManager->get('Navigation')->createNavigationMid(1003001001, $request, $response));

        $processes = ProcessMapper::getAll();
        $view->addData('processes', $processes);

        return $view;
    }

    /**
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param mixed            $data     Generic data
     *
     * @return RenderableInterface
     *
     * @since  1.0.0
     * @codeCoverageIgnore
     */
    public function viewRiskProcessSingle(RequestAbstract $request, ResponseAbstract $response, $data = null) : \Serializable
    {
        $view = new View($this->app, $request, $response);
        $view->setTemplate('/Modules/RiskManagement/Theme/Backend/process-single');
        $view->addData('nav', $this->app->moduleManager->get('Navigation')->createNavigationMid(1003001001, $request, $response));

        $process = ProcessMapper::get((int) $request->getData('id'));
        $view->addData('process', $process);

        return $view;
    }

    /**
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param mixed            $data     Generic data
     *
     * @return RenderableInterface
     *
     * @since  1.0.0
     * @codeCoverageIgnore
     */
    public function viewRiskSettings(RequestAbstract $request, ResponseAbstract $response, $data = null) : \Serializable
    {
        $view = new View($this->app, $request, $response);
        $view->setTemplate('/Modules/RiskManagement/Theme/Backend/settings-dashboard');
        $view->addData('nav', $this->app->moduleManager->get('Navigation')->createNavigationMid(1003001001, $request, $response));

        return $view;
    }

}
