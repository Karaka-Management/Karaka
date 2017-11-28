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
namespace Modules\Calendar\Models;

use phpOMS\Account\Account;
use phpOMS\Account\NullAccount;
use phpOMS\Stdlib\Base\Location;

/**
 * Event class.
 *
 * @category   Calendar
 * @package    Framework
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
class Event
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
     * Created.
     *
     * @var \Datetime
     * @since 1.0.0
     */
    private $createdAt = null;

    /**
     * Creator.
     *
     * @var int
     * @since 1.0.0
     */
    private $createdBy = 0;

    /**
     * Event type.
     *
     * Single event or a template (templates have a repeating)
     *
     * @var int
     * @since 1.0.0
     */
    private $type = EventType::SINGLE;

    /**
     * Event status.
     *
     * Active, inactive etc.
     *
     * @var int
     * @since 1.0.0
     */
    private $status = EventStatus::ACTIVE;

    /**
     * Schedule
     *
     * @var Schedule
     * @since 1.0.0
     */
    private $schedule = null;

    /**
     * Location of the event.
     *
     * @var Location
     * @since 1.0.0
     */
    private $location = null;

    /**
     * Calendar
     *
     * @var int
     * @since 1.0.0
     */
    private $calendar = null;

    /**
     * People.
     *
     * @var array
     * @since 1.0.0
     */
    private $people = [];

    /**
     * Constructor.
     *
     * @since  1.0.0
     */
    public function __construct()
    {
        $this->createdAt = new \DateTime('now');
        $this->location  = new Location();
        $this->schedule  = new Schedule();
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
     * @return Account[]
     *
     * @since  1.0.0
     */
    public function getPeople() : array
    {
        return $this->people;
    }

    /**
     * @param int $id Account id
     *
     * @return Account
     *
     * @since  1.0.0
     */
    public function getPerson(int $id) : Account
    {
        return $this->people[$id] ?? new NullAccount();
    }

    /**
     * @param Account $person Person to add
     *
     * @return int Account id/position
     *
     * @since  1.0.0
     */
    public function addPerson(Account $person)
    {
        $this->people[] = $person;

        end($this->people);
        $key = key($this->people);
        reset($this->people);

        return $key;
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
    public function removePerson(int $id) : bool
    {
        if (isset($this->people[$id])) {
            unset($this->people[$id]);

            return true;
        }

        return false;
    }

    /**
     * @param string $name Event name/title
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
     * @param string $desc Event description
     *
     * @since  1.0.0
     */
    public function setDescription(string $desc)
    {
        $this->description = $desc;
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
     * @return int
     *
     * @since  1.0.0
     */
    public function getCreatedBy() : int
    {
        return $this->createdBy;
    }

    /**
     * @param int $createdBy Creator
     *
     * @since  1.0.0
     */
    public function setCreatedBy(int $createdBy)
    {
        $this->createdBy = $createdBy;
        $this->schedule->setCreatedBy($this->createdBy);
    }

    /**
     * @param Location $location Event location
     *
     * @since  1.0.0
     */
    public function setLocation(Location $location)
    {
        $this->location = $location;
    }

    /**
     * @return Location
     *
     * @since  1.0.0
     */
    public function getLocation() : Location
    {
        return $this->location;
    }

    /**
     * @return int
     *
     * @since  1.0.0
     */
    public function getCalendar() : int
    {
        return $this->calendar;
    }

    /**
     * @return int
     *
     * @since  1.0.0
     */
    public function getType() : int
    {
        return $this->type;
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
     * @param int $calendar Calendar
     *
     * @since  1.0.0
     */
    public function setCalendar(int $calendar)
    {
        $this->calendar = $calendar;
    }

    /**
     * @return Schedule
     *
     * @since  1.0.0
     */
    public function getSchedule() : Schedule
    {
        return $this->schedule;
    }
}
