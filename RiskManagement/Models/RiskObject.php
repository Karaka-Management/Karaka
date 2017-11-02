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
class RiskObject
{
    private $id = 0;

    private $title = '';

    private $description = '';

    private $descriptionRaw = '';
    
    private $risk = null;

    public function __construct()
    {
    }

    public function getId() : int
    {
        return $this->id;
    }

    public function getRisk() 
    {
        return $this->risk;
    }

    public function setRisk($risk) /* : void */
    {
        $this->risk = $risk;
    }

    public function getTitle() : string
    {
        return $this->title;
    }

    public function setTitle(string $title) /* : void */
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