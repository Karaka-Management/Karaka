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
namespace Modules\Tasks\Models;
use phpOMS\Stdlib\Base\Exception\InvalidEnumValue;

/**
 * Task class.
 *
 * @category   Modules
 * @package    Framework
 * @license    OMS License 1.0
 * @link       http://orange-management.com
 * @since      1.0.0
 */
class TaskElement implements \JsonSerializable
{

    /**
     * Id.
     *
     * @var int
     * @since 1.0.0
     */
    private $id = 0;

    /**
     * Description.
     *
     * @var string
     * @since 1.0.0
     */
    private $description = '';

    /**
     * Task.
     *
     * @var int
     * @since 1.0.0
     */
    private $task = 0;

    /**
     * Creator.
     *
     * @var int
     * @since 1.0.0
     */
    private $createdBy = 0;

    /**
     * Created.
     *
     * @var \DateTime
     * @since 1.0.0
     */
    private $createdAt = null;

    /**
     * Status.
     *
     * @var int
     * @since 1.0.0
     */
    private $status = TaskStatus::OPEN;

    /**
     * Due.
     *
     * @var \DateTime
     * @since 1.0.0
     */
    private $due = null;

    /**
     * Forwarded to.
     *
     * @var int
     * @since 1.0.0
     */
    private $forwarded = 0;

    /**
     * Media.
     *
     * @var array
     * @since 1.0.0
     */
    private $media = [];

    /**
     * Constructor.
     *
     * @since  1.0.0
     */
    public function __construct()
    {
        $this->due       = new \DateTime('now');
        $this->due->modify('+1 day');
        $this->createdAt = new \DateTime('now');
    }

    /**
     * @return \DateTime
     *
     * @since  1.0.0
     */
    public function getCreatedAt() : \DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $created
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function setCreatedAt(\DateTime $created)
    {
        $this->createdAt = $created;
    }

    /**
     * @return mixed
     *
     * @since  1.0.0
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * @param mixed $creator
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function setCreatedBy($creator)
    {
        $this->createdBy = $creator;

        if ($this->forwarded === 0) {
            $this->setForwarded($this->createdBy);
        }
    }

    public function getMedia() : array
    {
        return $this->media;
    }

    public function addMedia($media) /* : void */
    {
        $this->media[] = $media;
    }

    /**
     * @return string
     *
     * @since  1.0.0
     */
    public function getDescription() : string
    {
        return $this->description;
    }

    /**
     * @param string $description
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function setDescription(string $description)
    {
        $this->description = $description;
    }

    /**
     * @return \DateTime
     *
     * @since  1.0.0
     */
    public function getDue() : \DateTime
    {
        return $this->due;
    }

    /**
     * @param \DateTime $due
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function setDue(\DateTime $due)
    {
        $this->due = $due;
    }

    /**
     * @return mixed
     *
     * @since  1.0.0
     */
    public function getForwarded()
    {
        return $this->forwarded;
    }

    /**
     * @param mixed $forwarded
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function setForwarded($forwarded)
    {
        $this->forwarded = $forwarded;
    }

    /**
     * @return int
     *
     * @since  1.0.0
     */
    public function getId() : int
    {
        return $this->id;
    }

    /**
     * @return int
     *
     * @since  1.0.0
     */
    public function getStatus() : int
    {
        return $this->status;
    }

    /**
     * @param int $status
     *
     * @return void
     *
     * @throws InvalidEnumValue
     *
     * @since  1.0.0
     */
    public function setStatus(int $status)
    {
        if (!TaskStatus::isValidValue($status)) {
            throw new InvalidEnumValue((string) $status);
        }

        $this->status = $status;
    }

    /**
     * @return int
     *
     * @since  1.0.0
     */
    public function getTask() : int
    {
        return $this->task;
    }

    /**
     * @param int $task
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function setTask(int $task)
    {
        $this->task = $task;
    }

    public function toArray() : array {
        return [
            'id' => $this->id,
            'task' => $this->task,
            'createdBy' => $this->createdBy,
            'createdAt' => $this->createdAt,
            'description' => $this->description,
            'status' => $this->status,
            'forward' => $this->forwarded,
            'due' => isset($this->due) ? $this->due->format('Y-m-d H:i:s') : null,
        ];
    }

    public function jsonSerialize() {
        return $this->toArray();
    }
}
