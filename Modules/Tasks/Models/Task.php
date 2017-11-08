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
namespace Modules\Tasks\Models;
use Modules\Calendar\Models\Schedule;
use phpOMS\Stdlib\Base\Exception\InvalidEnumValue;

/**
 * Task class.
 *
 * @category   Tasks
 * @package    Modules
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
class Task implements \JsonSerializable
{

    /**
     * ID.
     *
     * @var int
     * @since 1.0.0
     */
    protected $id = 0;

    /**
     * Title.
     *
     * @var string
     * @since 1.0.0
     */
    protected $title = '';

    /**
     * Creator.
     *
     * @var int
     * @since 1.0.0
     */
    protected $createdBy = 0;

    /**
     * Created.
     *
     * @var \DateTime
     * @since 1.0.0
     */
    protected $createdAt = null;

    /**
     * Description.
     *
     * @var string
     * @since 1.0.0
     */
    protected $description = '';

    /**
     * Type.
     *
     * @var int
     * @since 1.0.0
     */
    protected $type = TaskType::SINGLE;

    /**
     * Status.
     *
     * @var int
     * @since 1.0.0
     */
    protected $status = TaskStatus::OPEN;

    /**
     * Task can be closed by user.
     *
     * @var bool
     * @since 1.0.0
     */
    protected $isClosable = true;

    /**
     * Start.
     *
     * @var \DateTime
     * @since 1.0.0
     */
    protected $start = null;

    /**
     * Due.
     *
     * @var \DateTime
     * @since 1.0.0
     */
    protected $due = null;

    /**
     * Done.
     *
     * @var \DateTime
     * @since 1.0.0
     */
    protected $done = null;

    /**
     * Task elements.
     *
     * @var TaskElement[]
     * @since 1.0.0
     */
    protected $taskElements = [];

    /**
     * Schedule
     *
     * @var Schedule
     * @since 1.0.0
     */
    protected $schedule = null;

    protected $priority = TaskPriority::MEDIUM;

    protected $media = [];

    /**
     * Constructor.
     *
     * @since  1.0.0
     */
    public function __construct()
    {
        $this->createdAt = new \DateTime('now');
        $this->start = new \DateTime('now');
        $this->due = new \DateTime('now');
        $this->due->modify('+1 day');
        $this->schedule = new Schedule();
    }

    public function setClosable(bool $closable) /* : void */
    {
        $this->isClosable = $closable;
    }

    public function isClosable() : bool
    {
        return $this->isClosable;
    }

    /**
     * Adding new task element.
     *
     * @param TaskElement $element Task element
     *
     * @return int
     *
     * @since  1.0.0
     */
    public function addElement(TaskElement $element) : int
    {
        $this->taskElements[] = $element;

        end($this->taskElements);
        $key = key($this->taskElements);
        reset($this->taskElements);

        return $key;
    }

    public function getMedia() : array
    {
        return $this->media;
    }

    public function addMedia($media) /* : void */
    {
        $this->media[] = $media;
    }

    public function isCc(int $id) : bool
    {
        return false;
    }

    public function isForwarded(int $id) : bool
    {
        foreach ($this->taskElements as $element) {
            if ($element->getForwarded()->getId() === $id) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return \DateTime
     *
     * @since  1.0.0
     */
    public function getCreatedAt() : \DateTime
    {
        return $this->createdAt ?? new \DateTime();
    }

    /**
     * @param \DateTime $created
     *
     * @since  1.0.0
     */
    public function setCreatedAt(\DateTime $created)
    {
        $this->createdAt = $created;
    }

    /**
     * @return \DateTime
     *
     * @since  1.0.0
     */
    public function getStart() : \DateTime
    {
        return $this->start ?? new \DateTime();
    }

    /**
     * @param \DateTime $created
     *
     * @since  1.0.0
     */
    public function setStart(\DateTime $start)
    {
        $this->start = $start;
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
     * @param mixed $id
     *
     * @since  1.0.0
     */
    public function setCreatedBy($id)
    {
        $this->createdBy = $id;
        $this->schedule->setCreatedBy($id);
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
    public function getDone() : \DateTime
    {
        return $this->done ?? new \DateTime('now');
    }

    /**
     * @param \DateTime $done
     *
     * @since  1.0.0
     */
    public function setDone(\DateTime $done)
    {
        $this->done = $done;
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
     * @since  1.0.0
     */
    public function setDue(\DateTime $due)
    {
        $this->due = $due;
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
    public function getPriority() : int
    {
        return $this->priority;
    }

    /**
     * @param int $priority
     *
     * @throws InvalidEnumValue
     *
     * @since  1.0.0
     */
    public function setPriority(int $priority)
    {
        if (!TaskStatus::isValidValue($priority)) {
            throw new InvalidEnumValue((string) $priority);
        }

        $this->priority = $priority;
    }

    /**
     * @return string
     *
     * @since  1.0.0
     */
    public function getTitle() : string
    {
        return $this->title;
    }

    /**
     * @param string $title
     *
     * @since  1.0.0
     */
    public function setTitle(string $title)
    {
        $this->title = $title;
    }

    /**
     * Remove Element from list.
     *
     * @param int $id Task element
     *
     * @return bool
     *
     * @since  1.0.0
     */
    public function removeElement($id) : bool
    {
        if (isset($this->taskElements[$id])) {
            unset($this->taskElements[$id]);

            return true;
        }

        return false;
    }

    /**
     * Get task elements.
     *
     * @return TaskElement[]
     *
     * @since  1.0.0
     */
    public function getTaskElements() : array
    {
        return $this->taskElements;
    }

    /**
     * Get task elements.
     *
     * @param int $id Element id
     *
     * @return TaskElement
     *
     * @since  1.0.0
     */
    public function getTaskElement(int $id) : TaskElement
    {
        return $this->taskElements[$id] ?? new NullTaskElement();
    }

    /**
     * Get task type.
     *
     * @return int
     *
     * @since  1.0.0
     */
    public function getType() : int
    {
        return $this->type;
    }

    /**
     * Set task type.
     *
     * @param int $type Task type
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function setType(int $type = TaskType::SINGLE)
    {
        $this->type = $type;
    }

    /**
     * Get schedule.
     *
     * @return Schedule
     *
     * @since  1.0.0
     */
    public function getSchedule() : Schedule {
        return $this->schedule;
    }

    public function toArray() : array
    {
        return [
            'id' => $this->id,
            'createdBy' => $this->createdBy,
            'createdAt' => $this->createdAt->format('Y-m-d H:i:s'),
            'title' => $this->title,
            'description' => $this->description,
            'status' => $this->status,
            'type' => $this->type,
            'priority' => $this->priority,
            'due' => $this->due->format('Y-m-d H:i:s'),
            'done' => (!isset($this->done) ? null : $this->done->format('Y-m-d H:i:s')),
        ];
    }

    /**
     * Specify data which should be serialized to JSON
     * @link  http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
        return $this->toArray();
    }
}
