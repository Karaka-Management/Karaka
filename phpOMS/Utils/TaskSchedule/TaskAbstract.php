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
 * Abstract task class.
 *
 * @category   Framework
 * @package    phpOMS\Utils\TaskSchedule
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
abstract class TaskAbstract
{
    /**
     * Id.
     *
     * @var string
     * @since 1.0.0
     */
    protected $id = '';

    /**
     * Command used for creating the task
     *
     * @var string
     * @since 1.0.0
     */
    protected $command = '';

    /**
     * Command/script to run.
     *
     * @var string
     * @since 1.0.0
     */
    protected $run = '';

    /**
     * Status of the task
     *
     * @var string
     * @since 1.0.0
     */
    protected $status = '';

    /**
     * Next runtime
     *
     * @var \DateTime
     * @since 1.0.0
     */
    protected $nextRunTime = null;

    /**
     * Last runtime
     *
     * @var \DateTime
     * @since 1.0.0
     */
    protected $lastRunTime = null;

    /**
     * Comment
     * 
     * @param string $name Name of the task
     * @param string $cmd Command/script to run
     *
     * @var string
     * @since 1.0.0
     */
    protected $comment = '';

    public function __construct(string $name, string $cmd = '') {
        $this->id = $name;
        $this->command = $cmd;
    }

    /**
     * Get id.
     *
     * @return string
     *
     * @since  1.0.0
     */
    public function getId() : string
    {
        return $this->id;
    }

    /**
     * Get command to create the task
     *
     * @return string
     *
     * @since  1.0.0
     */
    public function getCommand() : string
    {
        return $this->command;
    }

    /**
     * Set command to create the task
     *
     * @param string $command Command
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function setCommand(string $command) /* : void */
    {
        $this->command = $command;
    }

    /**
     * Get command/script to run
     *
     * @return string
     *
     * @since  1.0.0
     */
    public function getRun() : string
    {
        return $this->run;
    }

    /**
     * Set script to run
     *
     * @param string $run Command/script to run
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function setRun(string $run) /* : void */
    {
        $this->run = $run;
    }

    /**
     * Get status.
     *
     * @return string
     *
     * @since  1.0.0
     */
    public function getStatus() : string
    {
        return $this->status;
    }

    /**
     * Set status.
     *
     * @param string $status Status
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function setStatus(string $status) /* : void */
    {
        $this->status = $status;
    }

    /**
     * Get next run time.
     *
     * @return \DateTime
     *
     * @since  1.0.0
     */
    public function getNextRunTime()
    {
        return $this->nextRunTime;
    }

    /**
     * Set next run time.
     *
     * @param \DateTime $nextRunTime Next run time
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function setNextRunTime(\DateTime $nextRunTime) /* : void */
    {
        $this->nextRunTime = $nextRunTime;
    }

    /**
     * Get last run time.
     *
     * @return \DateTime
     *
     * @since  1.0.0
     */
    public function getLastRuntime() 
    {
        return $this->lastRunTime;
    }

    /**
     * Set last run time.
     *
     * @param \DateTime $lastRunTime Last run time
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function setLastRuntime(\DateTime $lastRunTime) /* : void */
    {
        $this->lastRunTime = $lastRunTime;
    }

    /**
     * Get comment.
     *
     * @return string
     *
     * @since  1.0.0
     */
    public function getComment() : string
    {
        return $this->comment;
    }

    /**
     * Set comment.
     *
     * @param string $comment Comment
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function setComment(string $comment) /* : void */
    {
        $this->comment = $comment;
    }

    /**
     * Get comment.
     *
     * @return string
     *
     * @since  1.0.0
     */
    public function addResult(string $result)
    {
        $this->results[] = $result;
    }

    /**
     * Create task based on job data
     * 
     * @param array $jobData Raw job data
     * 
     * @return TaskAbstract
     * 
     * @since 1.0.0
     */
    abstract public static function createWith(array $jobData) : TaskAbstract;
}
