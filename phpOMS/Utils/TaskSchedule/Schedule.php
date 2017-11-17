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
 * Schedule class.
 *
 * @category   Framework
 * @package    phpOMS\Utils\TaskSchedule
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
class Schedule extends TaskAbstract
{
    /**
     * {@inheritdoc}
     */
    public static function createWith(array $jobData) : TaskAbstract
    {
            $job = new self($jobData[1], '');

            $job->setRun($jobData[8]);
            $job->setStatus($jobData[3]);

            if (DateTime::isValid($jobData[2])) { 
                $job->setNextRunTime(new \DateTime($jobData[2]));
            }

            if (DateTime::isValid($jobData[5])) { 
                $job->setLastRuntime(new \DateTime($jobData[5]));
            }
            
            $job->setComment($jobData[10]);
            $job->addResult($jobData[6]);

            return $job;
    }
}
