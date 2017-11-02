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
namespace Modules\RiskManagement\Models;

/**
 * Risk Management class.
 *
 * @category   Modules
 * @package    Modules\RiskManagement
 * @license    OMS License 1.0
 * @link       http://orange-management.com
 * @since      1.0.0
 */
class Category
{
    private $id = 0;

    private $title = '';

    private $description = '';

    private $descriptionRaw = '';

    private $parent = null;

    private $responsible = null;

    private $deputy = null;

    public function __construct()
    {
    }

    public function getId() : int
    {
        return $this->id;
    }

    public function getParent() 
    {
        return $this->parent;
    }

    public function setParent($parent) /* : void */
    {
        $this->parent = $parent;
    }

    public function getResponsible() 
    {
        return $this->responsible;
    }

    public function setResponsible($responsible) /* : void */
    {
        $this->responsible = $responsible;
    }

    public function setDeputy($deputy) /* : void */
    {
        $this->deputy = $deputy;
    }

    public function getDeputy() 
    {
        return $this->deputy;
    }
    
    public function getTitle() : string
    {
        return $this->title;
    }

    public function setTitle(string $title)
    {
        $this->title = $title;
    }

    public function getDescription() : string
    {
        return $this->description;
    }

    public function getDescriptionRaw() : string
    {
        return $this->descriptionRaw;
    }

    public function setDescriptionRaw(string $description) /* : void */
    {
        $this->descriptionRaw = $description;
    }
}