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

use Modules\Media\Models\Media;

/**
 * Task class.
 *
 * @category   Kanban
 * @package    Modules
 * @license    OMS License 1.0
 * @link       http://orange-management.com
 * @since      1.0.0
 */
class KanbanLabel implements \JsonSerializable
{
    private $id = 0;

    private $name = '';

    private $board = 0;

    private $color = 0;

    public function __construct()
    {
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

    public function setColor(int $color) /* : void */
    {
        $this->color = $color;
    }

    public function getColor() : int
    {
        return $this->color;
    }

    public function getBoard() : int
    {
        return $this->board;
    }

    public function setBoard(int $board) /* : void */
    {
        $this->board = $board;
    }

    public function jsonSerialize() : array
    {
        return [];
    }

}