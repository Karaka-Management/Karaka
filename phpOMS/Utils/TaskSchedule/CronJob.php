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

use phpOMS\Validation\Base\DateTime;


/**
 * CronJob class.
 *
 * @category   Framework
 * @package    phpOMS\Utils\TaskSchedule
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
class CronJob extends TaskAbstract
{
    /**
     * {@inheritdoc}
     */
    public static function createWith(array $jobData) : TaskAbstract
    {
            $job = new self($jobData[5], '');

            $job->setRun($jobData[5]);

            return $job;
    }
}
