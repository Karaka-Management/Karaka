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
namespace Modules\Calendar\Models;

use phpOMS\Stdlib\Base\SmartDateTime;

/**
 * Calendar class.
 *
 * @category   Calendar
 * @package    Framework
 * @license    OMS License 1.0
 * @link       http://orange-management.com
 * @since      1.0.0
 */
class Calendar
{

    /**
     * Calendar ID.
     *
     * @var int
     * @since 1.0.0
     */
    private $id = 0;

    /**
     * Name.
     *
     * @var string
     * @since 1.0.0
     */
    private $name = '';

    /**
     * Description.
     *
     * @var string
     * @since 1.0.0
     */
    private $description = '';

    /**
     * Created at.
     *
     * @var \Datetime
     * @since 1.0.0
     */
    private $createdAt = null;

    /**
     * Current date of the calendar.
     *
     * @var SmartDateTime
     * @since 1.0.0
     */
    private $date = null;

    /**
     * Events.
     *
     * @var \Modules\Calendar\Models\Event[]
     * @since 1.0.0
     */
    private $events = [];

    /**
     * Constructor.
     *
     * @since  1.0.0
     */
    public function __construct()
    {
        $this->createdAt = new \DateTime('now');
        $this->date      = new SmartDateTime('now');
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
     * @return string
     *
     * @since  1.0.0
     */
    public function getName() : string
    {
        return $this->name;
    }

    /**
     * @param string $name Calendar name/title
     *
     * @since  1.0.0
     */
    public function setName(string $name)
    {
        $this->name = $name;
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
     * @param string $desc Calendar description
     *
     * @since  1.0.0
     */
    public function setDescription(string $desc)
    {
        $this->description = $desc;
    }

    /**
     * @param Event $event Calendar event
     *
     * @return int
     *
     * @since  1.0.0
     */
    public function addEvent(Event $event) : int
    {
        $this->events[] = $event;

        end($this->events);
        $key = key($this->events);
        reset($this->events);

        return $key;
    }

    /**
     * @return Event[]
     *
     * @since  1.0.0
     */
    public function getEvents() : array
    {
        return $this->events;
    }

    /**
     * @param int $id Event id
     *
     * @return bool
     *
     * @since  1.0.0
     */
    public function removeEvent(int $id) : bool
    {
        if (isset($this->events[$id])) {
            unset($this->events[$id]);

            return true;
        }

        return false;
    }

    /**
     * @param int $id Event id
     *
     * @return Event
     *
     * @since  1.0.0
     */
    public function getEvent(int $id) : Event
    {
        return $this->events[$id] ?? new NullEvent();
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
     * @param \DateTime $createdAt Calendar created at
     *
     * @since  1.0.0
     */
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * Get current date
     *
     * @return \DateTime
     *
     * @since  1.0.0
     */
    public function getDate() : \DateTime
    {
        return $this->date;
    }

    /**
     * Set current date
     *
     * @param \DateTime $date Current date
     *
     * @since  1.0.0
     */
    public function setDate(\DateTime $date)
    {
        $this->date = $date;
    }

    /**
     * Get event by date
     *
     * @param \DateTime $date Date of the event
     *
     * @return Event[]
     *
     * @since  1.0.0
     */
    public function getEventByDate(\DateTime $date) : array
    {
        $events = [];
        foreach ($this->events as $event) {
            if ($event->getCreatedAt()->format('Y-m-d') === $date->format('Y-m-d')) {
                $events[] = $event;
            }
        }

        return $events;
    }

    /**
     * Has event on date
     *
     * @param \DateTime $date Date of the event
     *
     * @return bool
     *
     * @since  1.0.0
     */
    public function hasEventOnDate(\DateTime $date) : bool
    {
        foreach ($this->events as $event) {
            if ($event->getCreatedAt()->format('Y-m-d') === $date->format('Y-m-d')) {
                return true;
            }
        }

        return false;
    }
}
