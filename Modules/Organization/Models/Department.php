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
namespace Modules\Organization\Models;

class Department
{
    protected $id = 0;

    protected $name = '';

    protected $parent = null;

    protected $status = Status::INACTIVE;

    protected $unit = 1;

    protected $description = '';

    public function getId() : int
    {
        return $this->id;
    }

    public function getName() : string
    {
        return $this->name;
    }

    public function setName(string $name)
    {
        return $this->name = $name;
    }

    public function getParent()
    {
        return $this->parent ?? new NullDepartment();
    }

    public function setParent(int $parent)
    {
        $this->parent = $parent;
    }

    public function getStatus() : int
    {
        return $this->status;
    }

    public function setStatus(int $status)
    {
        $this->status = $status;
    }

    public function getUnit()
    {
        return $this->unit ?? new NullUnit();
    }

    public function setUnit($unit)
    {
        $this->unit = $unit;
    }

    public function getDescription() : string
    {
        return $this->description;
    }

    public function setDescription(string $desc)
    {
        $this->description = $desc;
    }

    public function toArray() : array
    {
        return [
            'id'          => $this->id,
            'name'        => $this->name,
            'description' => $this->description,
            'unit'        => $this->unit,
        ];
    }

    /**
     * Get string representation.
     *
     * @return string
     *
     * @since  1.0.0
     */
    public function __toString()
    {
        return json_encode($this->toArray());
    }

    /**
     * Json serialize.
     *
     * @return string
     *
     * @since  1.0.0
     */
    public function jsonSerialize()
    {
        return $this->toArray();
    }
}
