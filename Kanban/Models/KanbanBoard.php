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
namespace Modules\Kanban\Models;

/**
 * Task class.
 *
 * @category   Kanban
 * @package    Modules
 * @license    OMS License 1.0
 * @link       http://orange-management.com
 * @since      1.0.0
 */
class KanbanBoard implements \JsonSerializable
{
    private $id = 0;

    private $name = '';

    private $status = BoardStatus::ACTIVE;

    private $order = 0;

    private $description = '';

    private $createdBy = 0;

    private $createdAt = null;

    private $columns = [];

    public function __construct()
    {
        $this->createdAt = new \DateTime('now');
    }

    public function getId() : int
    {
        return $this->id;
    }

    public function getName() : string
    {
        return $this->name;
    }

    public function setName(string $name) /* : void */
    {
        $this->name = $name;
    }

    public function getStatus() : int
    {
        return $this->status;
    }

    public function setStatus(int $status) /* : void */
    {
        $this->status = $status;
    }

    public function getOrder() : int
    {
        return $this->order;
    }

    public function setOrder(int $order) /* : void */
    {
        $this->order = $order;
    }

    public function getDescription() : string
    {
        return $this->description;
    }

    public function setDescription(string $description) /* : void */
    {
        $this->description = $description;
    }

    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    public function setCreatedBy(int $id) /* : void */
    {
        $this->createdBy = $id;
    }

    public function getCreatedAt() : \DateTime
    {
        return $this->createdAt;
    }

    public function getColumns() : array
    {
        return $this->columns;
    }

    public function addColumn($column) /* : void */
    {
        $this->columns[] = $column;
    }

    public function removeColumn(int $id) : bool
    {
        if (isset($this->columns[$id])) {
            unset($this->columns[$id]);

            return true;
        }

        return false;
    }

    public function jsonSerialize() : array
    {
        return [];
    }
}