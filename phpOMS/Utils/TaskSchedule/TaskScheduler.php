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
 * Task scheduler class.
 *
 * @category   Framework
 * @package    phpOMS\Utils\TaskSchedule
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
class TaskScheduler extends SchedulerAbstract
{
    /**
     * {@inheritdoc}
     */
    public function save() /* : void */
    {

    }

    /**
     * Run command
     *
     * @param string $cmd Command to run
     *
     * @return string
     *
     * @throws \Exception
     *
     * @since  1.0.0
     */
    private function run(string $cmd) : string
    {
        $cmd = 'cd ' . escapeshellarg(dirname(self::$bin)) . ' && ' . basename(self::$bin) . ' ' . $cmd;

        $pipes = [];
        $desc  = [
            1 => ['pipe', 'w'],
            2 => ['pipe', 'w'],
        ];

        $resource = proc_open($cmd, $desc, $pipes, __DIR__, null);
        $stdout   = stream_get_contents($pipes[1]);
        $stderr   = stream_get_contents($pipes[2]);

        foreach ($pipes as $pipe) {
            fclose($pipe);
        }

        $status = trim((string) proc_close($resource));

        if ($status == -1) {
            throw new \Exception($stderr);
        }

        return trim($stdout);
    }

    /**
     * Normalize run result for easier parsing
     *
     * @param string $raw Raw command output
     *
     * @return string Normalized string for parsing
     *
     * @since  1.0.0
     */
    private function normalize(string $raw) : string 
    {
        return str_replace("\r\n", "\n", $raw);
    }

    /**
     * Parse a list of jobs
     *
     * @param array $jobData Csv data containing the job information
     *
     * @return TaskAbstract Parsed job
     *
     * @since  1.0.0
     */
    private function parseJobList(array $jobData) : TaskAbstract
    {
            $job = TaskFactory::create($jobData[1], '');

            $job->setRun($jobData[8]);
            $job->setStatus($jobData[3]);

            if (DateTime::isValid($jobData[2])) { 
                $job->setNextRunTime(new \DateTime($jobData[2]));
            }

            if (DateTime::isValid($jobData[5])) { 
                $job->setLastRuntime(new \DateTime($jobData[5]));
            }
            
            $job->setAuthor($jobData[7]);
            $job->setComment($jobData[10]);

            if (DateTime::isValid($jobData[20])) { 
                $job->setStart(new \DateTime($jobData[20]));
            }

            if (DateTime::isValid($jobData[21])) { 
                $job->setEnd(new \DateTime($jobData[21]));
            }

            $job->addResult($jobData[6]);

            return $job;
    }

    /**
     * {@inheritdoc}
     */
    public function getAll() : array
    {
        $lines = explode("\n", $this->normalize($this->run('/query /v /fo CSV')));
        unset($lines[0]);

        $jobs = [];
        foreach ($lines as $line) {
            $jobs[] = $this->parseJobList(str_getcsv($line));
        }
        
        return $jobs;
    }

    /**
     * {@inheritdoc}
     */
    public function get(string $id)
    {
        // todo: implement
    }

    /**
     * {@inheritdoc}
     */
    public function getByName(string $name) : Schedule
    {
        // todo: implement
    }

    /**
     * {@inheritdoc}
     */
    public function getAllByName(string $name, bool $exact = true) : array
    {
        if ($exact) {
            $lines = explode("\n", $this->normalize($this->run('/query /v /fo CSV /tn ' . escapeshellarg($name))));
            unset($lines[0]);

            $jobs = [];
            foreach ($lines as $line) {
                $jobs[] = $this->parseJobList(str_getcsv($line));
            }
        } else {
            $lines = explode("\n", $this->normalize($this->run('/query /v /fo CSV')));
            $jobs = [];
            
            unset($lines[0]);

            foreach ($lines as $key => $line) {
                $line = str_getcsv($line);

                if (strpos($line[1], $name) !== false) {
                    $jobs[] = $this->parseJobList($line);
                }
            }
        }

        return $jobs;
    }

    /**
     * {@inheritdoc}
     */
    public function create(Schedule $task)
    {
        // todo: implement
    }
}
