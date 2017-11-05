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

namespace phpOMS\Utils\TaskSchedule;

/**
 * Interval class for tasks.
 *
 * @category   Framework
 * @package    phpOMS\Utils\TaskSchedule
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
class Interval implements \Serializable
{

    /**
     * Start.
     *
     * @var \DateTime
     * @since 1.0.0
     */
    private $start = null;

    /**
     * End.
     *
     * @var \DateTime
     * @since 1.0.0
     */
    private $end = null;

    /**
     * Minute.
     *
     * @var array
     * @since 1.0.0
     */
    private $minute = [];

    /**
     * Hour.
     *
     * @var array
     * @since 1.0.0
     */
    private $hour = [];

    /**
     * Day of month.
     *
     * @var array
     * @since 1.0.0
     */
    private $dayOfMonth = [];

    /**
     * Month.
     *
     * @var array
     * @since 1.0.0
     */
    private $month = [];

    /**
     * Day of week.
     *
     * @var array
     * @since 1.0.0
     */
    private $dayOfWeek = [];

    /**
     * Year.
     *
     * @var array
     * @since 1.0.0
     */
    private $year = [];

    /**
     * Constructor.
     *
     * @param string $interval Interval to parse
     *
     * @since  1.0.0
     */
    public function __construct(string $interval = null)
    {
        $this->start = new \DateTime('now');

        if (isset($interval)) {
            $this->unserialize($interval);
        }
    }

    /**
     * Unserialize.
     *
     * @param string $serialized String to unserialize
     *
     * @since  1.0.0
     */
    public function unserialize($serialized)
    {
        $elements = explode(' ', trim($serialized));

        $this->minute     = $this->parseMinute($elements[0]);
        $this->hour       = $this->parseHour($elements[1]);
        $this->dayOfMonth = $this->parseDayOfMonth($elements[2]);
        $this->month      = $this->parseMonth($elements[3]);
        $this->dayOfWeek  = $this->parseDayOfWeek($elements[4]);
        $this->year       = $this->parseYear($elements[5]);
    }

    /**
     * Parse element.
     *
     * @param string $minute Minute
     *
     * @return array
     *
     * @since  1.0.0
     */
    private function parseMinute(string $minute) : array
    {

    }

    /**
     * Parse element.
     *
     * @param string $hour Hour
     *
     * @return array
     *
     * @since  1.0.0
     */
    private function parseHour(string $hour) : array
    {

    }

    /**
     * Parse element.
     *
     * @param string $dayOfMonth Day of month
     *
     * @return array
     *
     * @since  1.0.0
     */
    private function parseDayOfMonth(string $dayOfMonth) : array
    {

    }

    /**
     * Parse element.
     *
     * @param string $month Month
     *
     * @return array
     *
     * @since  1.0.0
     */
    private function parseMonth(string $month) : array
    {

    }

    /**
     * Parse element.
     *
     * @param string $dayOfWeek Day of week
     *
     * @return array
     *
     * @since  1.0.0
     */
    private function parseDayOfWeek(string $dayOfWeek) : array
    {

    }

    /**
     * Parse element.
     *
     * @param string $year Year
     *
     * @return array
     *
     * @since  1.0.0
     */
    private function parseYear(string $year) : array
    {

    }

    /**
     * Get start.
     *
     * @return \DateTime
     *
     * @since  1.0.0
     */
    public function getStart() : \DateTime
    {
        return $this->start;
    }

    /**
     * Set start.
     *
     * @param \DateTime $start Start date
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function setStart(\DateTime $start) /* : void */
    {
        $this->start = $start;
    }

    /**
     * Get end.
     *
     * @return \DateTime
     *
     * @since  1.0.0
     */
    public function getEnd()
    {
        return $this->end;
    }

    /**
     * Set end.
     *
     * @param \DateTime $end End date
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function setEnd(\DateTime $end) /* : void */
    {
        $this->end = $end;
    }

    /**
     * Get minute.
     *
     * @return array
     *
     * @since  1.0.0
     */
    public function getMinute() : array
    {
        return $this->minute;
    }

    /**
     * Set mintue.
     *
     * @param array $minute Minute
     * @param int   $step   Step
     * @param bool  $any    Any
     *
     * @throws \Exception
     *
     * @since  1.0.0
     */
    public function setMinute(array $minute, int $step = 0, bool $any = false) /* : void */
    {
        if ($this->validateTime($minute, $step, 0, 59)) {
            $this->hour = [
                'minutes' => $minute,
                'step'    => $step,
                'any'     => $any,
            ];
        } else {
            throw new \Exception('Invalid format.');
        }
    }

    /**
     * Validate time.
     *
     * @param array $times   Times
     * @param int   $step    Step
     * @param int   $lowest  Lowest limet
     * @param int   $highest Highest limet
     *
     * @return bool
     *
     * @since  1.0.0
     */
    private function validateTime(array $times, int $step, int $lowest, int $highest) : bool
    {
        foreach ($times as $minute) {
            if ($minute > $highest || $minute < $lowest) {
                return false;
            }
        }

        if ($step > $highest || $step < $lowest) {
            return false;
        }

        return true;
    }

    /**
     * Get hour.
     *
     * @return array
     *
     * @since  1.0.0
     */
    public function getHour() : array
    {
        return $this->hour;
    }

    /**
     * Set hour.
     *
     * @param array $hour Hour
     * @param int   $step Step
     * @param bool  $any  Any
     *
     * @throws \Exception
     *
     * @since  1.0.0
     */
    public function setHour(array $hour, int $step = 0, bool $any = false) /* : void */
    {
        if ($this->validateTime($hour, $step, 0, 23)) {
            $this->hour = [
                'hours' => $hour,
                'step'  => $step,
                'any'   => $any,
            ];
        } else {
            throw new \Exception('Invalid format.');
        }
    }

    /**
     * Get day of month.
     *
     * @return array
     *
     * @since  1.0.0
     */
    public function getDayOfMonth() : array
    {
        return $this->dayOfMonth;
    }

    /**
     * Set day of month.
     *
     * @param array $dayOfMonth Day of month
     * @param int   $step       Step
     * @param bool  $any        Any
     * @param bool  $last       Last
     * @param int   $nearest    Nearest day
     *
     * @throws \Exception
     *
     * @since  1.0.0
     */
    public function setDayOfMonth(array $dayOfMonth, int $step = 0, bool $any = false, bool $last = false, int $nearest = 0) /* : void */
    {
        if ($this->validateDayOfMonth($arr = [
            'dayOfMonth' => $dayOfMonth,
            'step'       => $step,
            'any'        => $any,
            'last'       => $last,
            'nearest'    => $nearest,
        ])
        ) {
            $this->hour = $arr;
        } else {
            throw new \Exception('Invalid format.');
        }
    }

    /**
     * Validate day of month.
     *
     * @param array $array Element to validate
     *
     * @return bool
     *
     * @since  1.0.0
     */
    private function validateDayOfMonth(array $array) : bool
    {
        foreach ($array['dayOfMonth'] as $dayOfMonth) {
            if ($dayOfMonth > 31 || $dayOfMonth < 1) {
                return false;
            }
        }

        if ($array['step'] > 31 || $array['step'] < 1) {
            return false;
        }
        if ($array['nearest'] > 31 || $array['nearest'] < 1) {
            return false;
        }

        return true;
    }

    /**
     * Get day of week.
     *
     * @return array
     *
     * @since  1.0.0
     */
    public function getDayOfWeek() : array
    {
        return $this->dayOfWeek;
    }

    /**
     * Set day of week.
     *
     * @param array $dayOfWeek Day of week
     * @param int   $step      Step
     * @param bool  $any       Any
     * @param bool  $last      Last
     *
     * @throws \Exception
     *
     * @since  1.0.0
     */
    public function setDayOfWeek(array $dayOfWeek, int $step = 0, bool $any = false, bool $last = false) /* : void */
    {
        if ($this->validateDayOfWeek($arr = [
            'dayOfWeek' => $dayOfWeek,
            'step'      => $step,
            'any'       => $any,
            'last'      => $last,
        ])
        ) {
            $this->hour = $arr;
        } else {
            throw new \Exception('Invalid format.');
        }
    }

    /**
     * Validate day of week.
     *
     * @param array $array Element to validate
     *
     * @return bool
     *
     * @since  1.0.0
     */
    private function validateDayOfWeek(array $array) : bool
    {
        foreach ($array['dayOfWeek'] as $dayOfWeek) {
            if ($dayOfWeek > 7 || $dayOfWeek < 1) {
                return false;
            }
        }

        if ($array['step'] > 5 || $array['step'] < 1) {
            return false;
        }

        return true;
    }

    /**
     * Get month.
     *
     * @return array
     *
     * @since  1.0.0
     */
    public function getMonth() : array
    {
        return $this->month;
    }

    /**
     * Set month.
     *
     * @param array $month Month
     * @param int   $step  Step
     * @param bool  $any   Any
     *
     * @throws \Exception
     *
     * @since  1.0.0
     */
    public function setMonth(array $month, int $step = 0, bool $any = false) /* : void */
    {
        if ($this->validateTime($month, $step, 1, 12)) {
            $this->month = [
                'month' => $month,
                'step'  => $step,
                'any'   => $any,
            ];
        } else {
            throw new \Exception('Invalid format.');
        }
    }

    /**
     * Get year.
     *
     * @return array
     *
     * @since  1.0.0
     */
    public function getYear() : array
    {
        return $this->year;
    }

    /**
     * Set yaer.
     *
     * @param array $year Year
     * @param int   $step Step
     * @param bool  $any  Any
     *
     * @throws \Exception
     *
     * @since  1.0.0
     */
    public function setYear(array $year, int $step = 0, bool $any = false) /* : void */
    {
        if ($this->validateYear($arr = [
            'year' => $year,
            'step' => $step,
            'any'  => $any,
        ])
        ) {
            $this->hour = $arr;
        } else {
            throw new \Exception('Invalid format.');
        }
    }

    /**
     * Validate year.
     *
     * @param array $array Element to validate
     *
     * @return bool
     *
     * @since  1.0.0
     */
    private function validateYear(array $array) : bool
    {
        return true;
    }

    /**
     * Create string representation.
     *
     * @return string
     *
     * @since  1.0.0
     */
    public function serialize()
    {
        $minute     = $this->serializeTime($this->minute['minutes'], $this->minute['step']);
        $hour       = $this->serializeTime($this->hour['hours'], $this->hour['step']);
        $dayOfMonth = $this->serializeDayOfMonth();
        $month      = $this->serializeTime($this->month['month'], $this->month['step']);
        $dayOfWeek  = $this->serializeDayOfWeek();
        $year       = $this->serializeTime($this->year['year'], $this->year['step']);

        return $minute . ' ' . $hour . ' ' . $dayOfMonth . ' ' . $month . ' ' . $dayOfWeek . ' ' . $year;
    }

    /**
     * Create string representation.
     *
     * @param array $time Time
     * @param int   $step Step for repetition
     *
     * @return string
     *
     * @since  1.0.0
     */
    public function serializeTime($time, $step) /* : void */
    {
        if (($count = count($time)) > 0) {
            $serialize = implode(',', $time);
        } else {
            $serialize = '*';
            $count     = 1;
        }

        if ($count === 0 && $step !== 0) {
            $serialize .= '/' . $step;
        }

        return $serialize;
    }

    /**
     * Create string representation.
     *
     * @return string
     *
     * @since  1.0.0
     */
    public function serializeDayOfMonth() /* : void */
    {
        if (($count = count($this->dayOfMonth['dayOfMonth'])) > 0) {
            $serialize = implode(',', $this->dayOfMonth['dayOfMonth']);
        } else {
            $serialize = '*';
            $count     = 1;
        }

        if ($count === 0 && $this->dayOfMonth['step'] !== 0) {
            $serialize .= '/' . $this->dayOfMonth['step'];
        }

        if ($this->dayOfMonth['last']) {
            $serialize .= 'L';
        }

        return $serialize;
    }

    /**
     * Create string representation.
     *
     * @return string
     *
     * @since  1.0.0
     */
    public function serializeDayOfWeek() /* : void */
    {
        if (($count = count($this->dayOfWeek['dayOfWeek'])) > 0) {
            $serialize = implode(',', $this->dayOfWeek['dayOfWeek']);
        } else {
            $serialize = '*';
            $count     = 1;
        }

        if ($count === 0 && $this->dayOfWeek['step'] !== 0) {
            $serialize .= '#' . $this->dayOfWeek['step'];
        }

        if ($this->dayOfWeek['last']) {
            $serialize .= 'L';
        }

        return $serialize;
    }
}
