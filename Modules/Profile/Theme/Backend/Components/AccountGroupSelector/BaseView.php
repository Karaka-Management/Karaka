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

namespace Modules\Profile\Theme\Backend\Components\AccountGroupSelector;

use phpOMS\Views\View;
use phpOMS\ApplicationAbstract;
use phpOMS\Message\RequestAbstract;
use phpOMS\Message\ResponseAbstract;

class BaseView extends View
{
    private $id = '';
    private $isRequired = false;

    public function __construct(ApplicationAbstract $app, RequestAbstract $request, ResponseAbstract $response)
    {
        parent::__construct($app, $request, $response);
        $this->setTemplate('/Modules/Profile/Theme/Backend/Components/AccountGroupSelector/base');

        $view = new PopupView($app, $request, $response);
        $this->addData('popup', $view);
    }

    public function getId() : string
    {
        return $this->id;
    }

    public function isRequired() : bool
    {
        return $this->isRequired;
    }

    public function render(...$data) : string
    {
        $this->id = $data[0];
        $this->required = $data[1] ?? false;
        $this->getData('popup')->setId($this->id);
        return parent::render();
    }
}