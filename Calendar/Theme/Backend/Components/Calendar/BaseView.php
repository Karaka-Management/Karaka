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

namespace Modules\Calendar\Theme\Backend\Components\Calendar;

use phpOMS\Views\View;
use phpOMS\ApplicationAbstract;
use phpOMS\Message\RequestAbstract;
use phpOMS\Message\ResponseAbstract;

class BaseView extends View
{
    protected $calendar = [];

    public function __construct(ApplicationAbstract $app, RequestAbstract $request, ResponseAbstract $response)
    {
        parent::__construct($app, $request, $response);
        $this->setTemplate('/Modules/Calendar/Theme/Backend/Components/Calendar/mini');
    }

    public function render(...$data) : string
    {
        $this->calendar = $data[0];
        return parent::render();
    }
}