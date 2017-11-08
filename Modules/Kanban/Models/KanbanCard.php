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
namespace Modules\Kanban\Models;

use Modules\Media\Models\Media;

/**
 * Task class.
 *
 * @category   Kanban
 * @package    Modules
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
class KanbanCard implements \JsonSerializable
{
    private $id = 0;

    private $name = '';

    private $status = CardStatus::ACTIVE;

    private $type = CardType::TEXT;

    private $description = '';

    private $column = 0;

    private $order = 0;

    private $ref = 0;

    private $createdBy = 0;

    private $createdAt = null;

    private $comments = [];

    private $labels = [];

    private $media = [];

    public function __construct()
    {
        $this->createdAt = new \DateTime('now');
    }

    public function getOrder() : int
    {
        return $this->order;
    }

    public function setOrder(int $order) /* : void */
    {
        $this->order = $order;
    }

    public function getId() : int
    {
        return $this->id;
    }

    public function setColumn(int $id) /* : void */
    {
        $this->column = $id;
    }

    public function getColumn() : int
    {
        return $this->column;
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

    public function getType() : int
    {
        return $this->type;
    }

    public function setType(int $type) /* : void */
    {
        $this->type = $type;
    }

    public function getRef() : int
    {
        return $this->ref;
    }

    public function setRef(int $ref) /* : void */
    {
        $this->ref = $ref;
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

    public function getComments() : array
    {
        return $this->comments;
    }

    public function addComment($comment) /* : void */
    {
        $this->comments[] = $comment;
    }

    public function removeComment(int $id) : bool
    {
        if (isset($this->comments[$id])) {
            unset($this->comments[$id]);

            return true;
        }

        return false;
    }

    public function getMedia() : array
    {
        return $this->media;
    }

    public function addMedia($media) /* : void */
    {
        $this->media[] = $media;
    }

    public function getLabels() : array
    {
        return $this->labels;
    }

    public function addLabel($label) /* : void */
    {
        $this->labels[] = $label;
    }

    public function jsonSerialize() : array
    {
        return [
            'title' => $this->name,
            'description' => $this->description,
            'status' => $this->status,
            'type' => $this->type,
            'column' => $this->name,
            'order' => $this->name,
            'ref' => $this->name,
            'createdBy' => $this->name,
            'createdAt' => $this->name,
            'labels' => $this->name,
            'comments' => $this->name,
            'media' => $this->name,
        ];
    }

    public static function createFromTask(Task $task) : KanbanCard
    {
        $card = new self();
        $card->setRef($task->getId());

        return $card;
    }

    /* todo: maybe allow ref to be an object and datamapper creates that object? how does the datamapper know what kind of datamapper to use? Just assume it's called ObjectMapper? bad isn't it?! */
}