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
namespace Modules\Organization;

use Model\Message\FormValidation;
use Modules\Organization\Models\Department;
use Modules\Organization\Models\DepartmentMapper;
use Modules\Organization\Models\Position;
use Modules\Organization\Models\PositionMapper;
use Modules\Organization\Models\Status;
use Modules\Organization\Models\Unit;
use Modules\Organization\Models\UnitMapper;
use phpOMS\Message\RequestAbstract;
use phpOMS\Message\ResponseAbstract;
use phpOMS\Module\ModuleAbstract;
use phpOMS\Module\WebInterface;
use phpOMS\Views\View;
use phpOMS\Message\Http\RequestStatusCode;

/**
 * Organization Controller class.
 *
 * @category   Modules
 * @package    Modules\Organization
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
    /* public */ const MODULE_NAME = 'Organization';

    /**
     * Module id.
     *
     * @var int
     * @since 1.0.0
     */
    /* public */ const MODULE_ID = 1004700000;

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
    public function viewUnitList(RequestAbstract $request, ResponseAbstract $response, $data = null) : \Serializable
    {
        $view = new View($this->app, $request, $response);
        $view->setTemplate('/Modules/Organization/Theme/Backend/unit-list');
        $view->addData('nav', $this->app->moduleManager->get('Navigation')->createNavigationMid(1004702001, $request, $response));

        $view->addData('list:elements', UnitMapper::getAll());

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
    public function viewUnitProfile(RequestAbstract $request, ResponseAbstract $response, $data = null) : \Serializable
    {
        $view = new View($this->app, $request, $response);
        $view->setTemplate('/Modules/Organization/Theme/Backend/unit-profile');
        $view->addData('nav', $this->app->moduleManager->get('Navigation')->createNavigationMid(1004702001, $request, $response));

        $view->addData('unit', UnitMapper::get((int) $request->getData('id')));

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
    public function viewUnitCreate(RequestAbstract $request, ResponseAbstract $response, $data = null) : \Serializable
    {
        $view = new View($this->app, $request, $response);
        $view->setTemplate('/Modules/Organization/Theme/Backend/unit-create');
        $view->addData('nav', $this->app->moduleManager->get('Navigation')->createNavigationMid(1004702001, $request, $response));

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
    public function viewDepartmentList(RequestAbstract $request, ResponseAbstract $response, $data = null) : \Serializable
    {
        $view = new View($this->app, $request, $response);
        $view->setTemplate('/Modules/Organization/Theme/Backend/department-list');
        $view->addData('nav', $this->app->moduleManager->get('Navigation')->createNavigationMid(1004703001, $request, $response));

        $view->addData('list:elements', DepartmentMapper::getAll());

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
    public function viewDepartmentProfile(RequestAbstract $request, ResponseAbstract $response, $data = null) : \Serializable
    {
        $view = new View($this->app, $request, $response);
        $view->setTemplate('/Modules/Organization/Theme/Backend/department-profile');
        $view->addData('nav', $this->app->moduleManager->get('Navigation')->createNavigationMid(1004703001, $request, $response));

        $view->addData('department', DepartmentMapper::get((int) $request->getData('id')));

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
    public function viewDepartmentCreate(RequestAbstract $request, ResponseAbstract $response, $data = null) : \Serializable
    {
        $view = new View($this->app, $request, $response);
        $view->setTemplate('/Modules/Organization/Theme/Backend/department-create');
        $view->addData('nav', $this->app->moduleManager->get('Navigation')->createNavigationMid(1004703001, $request, $response));

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
    public function viewPositionList(RequestAbstract $request, ResponseAbstract $response, $data = null) : \Serializable
    {
        $view = new View($this->app, $request, $response);
        $view->setTemplate('/Modules/Organization/Theme/Backend/position-list');
        $view->addData('nav', $this->app->moduleManager->get('Navigation')->createNavigationMid(1004704001, $request, $response));

        $view->addData('list:elements', PositionMapper::getAll());

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
    public function viewPositionProfile(RequestAbstract $request, ResponseAbstract $response, $data = null) : \Serializable
    {
        $view = new View($this->app, $request, $response);
        $view->setTemplate('/Modules/Organization/Theme/Backend/position-profile');
        $view->addData('nav', $this->app->moduleManager->get('Navigation')->createNavigationMid(1004704001, $request, $response));

        $view->addData('position', PositionMapper::get((int) $request->getData('id')));

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
    public function viewPositionCreate(RequestAbstract $request, ResponseAbstract $response, $data = null) : \Serializable
    {
        $view = new View($this->app, $request, $response);
        $view->setTemplate('/Modules/Organization/Theme/Backend/position-create');
        $view->addData('nav', $this->app->moduleManager->get('Navigation')->createNavigationMid(1004704001, $request, $response));

        return $view;
    }

    private function validateUnitCreate(RequestAbstract $request) : array
    {
        $val = [];
        if (
            ($val['name'] = empty($request->getData('name')))
            || ($val['parent'] = (
                !empty($request->getData('parent'))
                && !is_numeric($request->getData('parent'))
            ))
            || ($val['status'] = (
                $request->getData('status') === null
                || !Status::isValidValue((int) $request->getData('status'))
            ))
        ) {
            return $val;
        }

        return [];
    }

    public function apiUnitCreate(RequestAbstract $request, ResponseAbstract $response, $data = null)
    {
        if (!empty($val = $this->validateUnitCreate($request))) {
            $response->set('unit_create', new FormValidation($val));

            return;
        }

        $unit = new Unit();
        $unit->setName($request->getData('name'));
        $unit->setDescription($request->getData('description') ?? '');
        $unit->setStatus((int) $request->getData('status'));

        UnitMapper::create($unit);

        $response->set('unit', $unit->jsonSerialize());
    }

    private function validatePositionCreate(RequestAbstract $request) : array
    {
        $val = [];
        if (
            ($val['name'] = empty($request->getData('name')))
            || ($val['parent'] = (
                !empty($request->getData('parent'))
                && !is_numeric($request->getData('parent'))
            ))
            || ($val['status'] = (
                $request->getData('status') === null
                || !Status::isValidValue((int) $request->getData('status'))
            ))
        ) {
            return $val;
        }

        return [];
    }

    public function apiPositionCreate(RequestAbstract $request, ResponseAbstract $response, $data = null)
    {
        if (!empty($val = $this->validatePositionCreate($request))) {
            $response->set('position_create', new FormValidation($val));

            return;
        }

        $position = new Position();
        $position->setName($request->getData('name'));
        $position->setStatus((int) $request->getData('status'));
        $position->setDescription($request->getData('description') ?? '');

        PositionMapper::create($position);

        $response->set('position', $position->jsonSerialize());
    }

    private function validateDepartmentCreate(RequestAbstract $request) : array
    {
        $val = [];
        if (
            ($val['name'] = empty($request->getData('name')))
            || ($val['parent'] = (
                !empty($request->getData('parent'))
                && !is_numeric($request->getData('parent'))
            ))
            || ($val['unit'] = (
                !is_numeric((int) $request->getData('unit'))
            ))
        ) {
            return $val;
        }

        return [];
    }

    public function apiDepartmentCreate(RequestAbstract $request, ResponseAbstract $response, $data = null)
    {
        if (!empty($val = $this->validateDepartmentCreate($request))) {
            $response->set('department_create', new FormValidation($val));

            return;
        }

        $department = new Department();
        $department->setName($request->getData('name'));
        $department->setStatus((int) $request->getData('status'));
        $department->setDescription($request->getData('description') ?? '');

        DepartmentMapper::create($department);

        $response->set('department', $department->jsonSerialize());
    }
}
