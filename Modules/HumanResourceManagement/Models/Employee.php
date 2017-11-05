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
namespace Modules\HumanResourceManagement\Models;

use Modules\Admin\Models\Account;

/**
 * Employee class.
 *
 * @category   HumanResources
 * @package    Framework
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
class Employee {

    /**
     * Employee ID.
     *
     * @var int
     * @since 1.0.0
     */
    private $id = 0;

    private $account = null;

    private $unit = null;

    private $department = null;

    private $position = null;

    private $isActive = true;

    private $history = [];

    private $status = [];

    public function setAccount(Account $account) 
    {
        $this->account = $account;
    }

    public function getAccount() : Account {
        return $this->account;
    }

    public function setActivity(bool $active) 
    {
        $this->isActive = $active;
    }

    public function isActive() : bool
    {
        return $this->isActive;
    }

    public function setUnit($unit) 
    {
        $this->unit = $unit;
    }

    public function getUnit() 
    {
        return $this->unit;
    }

    public function setDepartment($department) 
    {
        $this->department = $department;
    }

    public function getDepartment() 
    {
        return $this->department;
    }

    public function setPosition($position) 
    {
        $this->position = $position;
    }

    public function getPosition() 
    {
        return $this->position;
    }

    public function getId() : int
    {
        return $this->id;
    }

    public function getHistory() : array
    {
        return [];
    }

    public function getNewestHistory() 
    {
        
    }
}
