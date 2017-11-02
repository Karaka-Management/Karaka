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

namespace phpOMS\Utils\TaskSchedule;

use phpOMS\System\OperatingSystem;
use phpOMS\System\SystemType;

/**
 * Scheduler factory.
 *
 * @category   Framework
 * @package    phpOMS\Utils\TaskSchedule
 * @license    OMS License 1.0
 * @link       http://orange-management.com
 * @since      1.0.0
 */
final class SchedulerFactory
{
    /**
     * Create scheduler instance.
     *
     * @return SchedulerAbstract
     *
     * @throws \Exception
     *
     * @since  1.0.0
     */
    public static function create() : SchedulerAbstract
    {
        switch (OperatingSystem::getSystem()) {
            case SystemType::WIN:
                return new TaskScheduler();
            case SystemType::LINUX:
                return new Cron();
            default:
                throw new \Exception('Unsupported system.');
        }
    }
}