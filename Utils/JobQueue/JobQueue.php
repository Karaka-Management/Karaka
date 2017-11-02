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

namespace phpOMS\Utils\JobQueue;

use phpOMS\Stdlib\Queue\PriorityQueue;

/**
 * Array utils.
 *
 * @category   Framework
 * @package    phpOMS\Utils
 * @license    OMS License 1.0
 * @link       http://orange-management.com
 * @since      1.0.0
 */
class JobQueue
{
    private $queue = null;
    private $run = true;
    private $suspended = false;
    private $isTerminating = true;
    private $isDeamonized;

    public function __construct()
    {
        $this->queue = new PriorityQueue();
    }

    public function dispatch(Job $job)
    {
        $this->queue->insert($job, $job->getPriority());
    }

    public function run()
    {
        $this->run       = true;
        $this->suspended = false;

        if ($this->isDeamonized) {
            if ($pid = pcntl_fork()) {
                return $pid;
            }

            $this->runAsDeamon();

            if (posix_setsid() < 0 || $pid = pcntl_fork()) {
                return 0;
            }
        }

        while ($this->run) {
            while (!$this->suspended) {
                if ($this->deamonized) {
                    // todo: see if still unsuspended and still running (db, file etc)
                }
            }

            $job = $this->queue->pop();

            $this->queue->increaseAll();
            $job['job']->execute();

            if ($this->isTerminating && $this->queue->count() < 1) {
                $this->suspended = true;
                $this->run       = false;
            }

            sleep(1);
        }

        sleep(1);
    }

    private function runAsDeamon()
    {
        ob_end_clean();
        fclose(STDIN);
        fclose(STDOUT);
        fclose(STDERR);

        register_shutdown_function(function() { posix_kill(posix_getpid(), SIGHUP); });
    }

    public function setRunning(bool $run = true) /* : void */
    {
        $this->run       = $run;
        $this->suspended = $run;
    }

    public function isRunning() : bool
    {
        return $this->run;
    }

    public function isSuspended() : bool
    {
        return $this->suspended;
    }

    public function setSuspended(bool $suspended = true) /* : void */
    {
        $this->suspended = $suspended;
    }

    public function isTerminating() : bool
    {
        return $this->isTerminating;
    }

    public function setTerminating(bool $terminating = true) /* : void */
    {
        $this->isTerminating = $terminating;
    }

    public function isDeamonized() : bool
    {
        return $this->isDeamonized;
    }

    public function setDeamonized(bool $deamonized) /* : void */
    {
        $this->isDeamonized = $deamonized;
    }

    private function savePid()
    {
        // todo: save pid somewhere for kill
    }
}