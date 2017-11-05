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
 * CronJob class.
 *
 * @category   Framework
 * @package    phpOMS\Utils\TaskSchedule
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
class CronJob extends TaskAbstract implements \Serializable
{

    /**
     * Constructor.
     *
     * @param Interval $interval Interval
     * @param string   $cmd      Command to execute
     *
     * @since  1.0.0
     */
    public function __construct(Interval $interval = null, $cmd = '')
    {
        if (!isset($interval)) {
            $this->interval = new Interval();
        } else {
            $this->interval = $interval;
        }

        $this->command = $cmd;
    }

    /**
     * Serialize cronjob.
     *
     * @return string
     *
     * @since  1.0.0
     */
    public function serialize()
    {
        $minute     = $this->printValue($this->interval->getMinute());
        $hour       = $this->printValue($this->interval->getHour());
        $dayOfMonth = $this->printValue($this->interval->getDayOfMonth());
        $month      = $this->printValue($this->interval->getMonth());
        $dayOfWeek  = $this->printValue($this->interval->getDayOfWeek());

        return $minute . ' ' . $hour . ' ' . $dayOfMonth . ' ' . $month . ' ' . $dayOfWeek . ' ' . $this->command;
    }

    /**
     * Print value.
     *
     * @param array $value Element to serialize
     *
     * @return string
     *
     * @since  1.0.0
     */
    private function printValue(array $value) : string
    {
        if (($count = count($value['dayOfWeek'])) > 0) {
            $parsed = implode(',', $value['dayOfWeek']);
        } elseif ($value['start'] !== 0 && $value['end']) {
            $parsed = $value['start'] . '-' . $value['end'];
            $count  = 2;
        } else {
            $parsed = '*';
            $count  = 1;
        }

        if ($count === 0 && $value['step'] !== 0) {
            $parsed .= '/' . $value['step'];
        }

        return $parsed;
    }

    /**
     * Unserialize cronjob.
     *
     * @param string $serialized To unserialize
     *
     * @since  1.0.0
     */
    public function unserialize($serialized)
    {
        // TODO: Implement unserialize() method.
    }
}
