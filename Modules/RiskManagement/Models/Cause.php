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
namespace Modules\RiskManagement\Models;

/**
 * Risk Management class.
 *
 * @category   Modules
 * @package    Modules\RiskManagement
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
class Cause
{
    private $id = 0;

    private $title = '';

    private $description = '';

    private $descriptionRaw = '';

    private $probability = 0.0;

    private $department = null;

    private $risk = null;

    private $category = null;

    public function __construct()
    {
    }

    public function getId() : int
    {
        return $this->id;
    }

    public function setRisk($risk) /* : void */
    {
        $this->risk = $risk;
    }

    public function getRisk() 
    {
        return $this->risk;
    }

    public function getCategory()
    {
        return $this->category;
    }

    public function setCategory($category) /* : void */
    {
        $this->category = $category;
    }

    public function getProbability() : float
    {
        return $this->probability;
    }

    public function setProbability(float $probability) /* : void */
    {
        $this->probability = $probability;
    }

    public function getDepartment() 
    {
        return $this->department;
    }

    public function setDepartment($department) /* : void */
    {
        $this->department = $department;
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