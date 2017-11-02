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
class KanbanCardComment implements \JsonSerializable
{
    private $id = 0;

    private $description = '';

    private $card = 0;

    private $createdBy = 0;

    private $createdAt = null;

    private $media = [];

    public function __construct()
    {
        $this->createdAt = new \DateTime('now');
    }

    public function getId() : int
    {
        return $this->id;
    }

    public function setCard(int $id) /* : void */
    {
        $this->card = $id;
    }

    public function getCard() : int
    {
        return $this->card;
    }

    public function getDescription() : string
    {
        return $this->description;
    }

    public function setDescription(string $description) /* : void */
    {
        $this->description = $description;
    }

    public function getCreatedBy() : int
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

    public function getMedia() : array
    {
        return $this->media;
    }

    public function addMedia($media) /* : void */
    {
        $this->media[] = $media;
    }

    public function jsonSerialize() : array
    {
        return [];
    }
}