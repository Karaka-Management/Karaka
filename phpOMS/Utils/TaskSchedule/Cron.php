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
 * Cron class.
 *
 * @category   Framework
 * @package    phpOMS\Utils\TaskSchedule
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
class Cron extends SchedulerAbstract
{

    public function save()
    {

    }

    /**
     * Run command
     *
     * @param string $cmd Command to run
     *
     * @return array
     *
     * @since  1.0.0
     */
    public function run(string $cmd) : array
    {
        // TODO: Implement run() method.
        return [];
    }
}
