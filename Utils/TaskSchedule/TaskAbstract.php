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

/**
 * Abstract task class.
 *
 * @category   Framework
 * @package    phpOMS\Utils\TaskSchedule
 * @license    OMS License 1.0
 * @link       http://orange-management.com
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

    protected $status = '';

    protected $nextRunTime = null;

    protected $lastRunTime = null;

    protected $start = null;

    protected $end = null;

    protected $comment = '';

    protected $results = [];

    protected $author = '';

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
     * Get command.
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
     * Set command.
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
     * Get run.
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
     * Set run.
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
     * Get start.
     *
     * @return \DateTime
     *
     * @since  1.0.0
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * Set start.
     *
     * @param \DateTime $start Start
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
     * @param \DateTime $end End
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
     * Get author.
     *
     * @return string
     *
     * @since  1.0.0
     */
    public function getAuthor() : string
    {
        return $this->author;
    }

    /**
     * Set author.
     *
     * @param string $author Author
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function setAuthor(string $author) /* : void */
    {
        $this->author = $author;
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
}
