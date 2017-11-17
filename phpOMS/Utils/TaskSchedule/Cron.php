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
 * @codeCoverageIgnore
 */
class Cron extends SchedulerAbstract
{

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
     * {@inheritdoc}
     */
    public function getAll() : array
    {
        $lines = explode("\n", $this->normalize($this->run('-l')));
        unset($lines[0]);

        $jobs = [];
        foreach ($lines as $line) {
            if($line !== '' && strrpos($line, '#', -strlen($line)) === false) {
                $jobs[] = CronJob::createWith(str_getcsv($line, ' '));
            }
        }
        
        return $jobs;
    }

    /**
     * {@inheritdoc}
     */
    public function getAllByName(string $name, bool $exact = true) : array
    {
        $lines = explode("\n", $this->normalize($this->run('-l')));
        unset($lines[0]);

        if ($exact) {
            $jobs = [];
            foreach ($lines as $line) {
                $csv = str_getcsv($line, ' ');

                if($line !== '' && strrpos($line, '#', -strlen($line)) === false && $csv[5] === $name) {
                    $jobs[] = CronJob::createWith($csv);
                }
            }
        } else {
            $jobs = [];
            foreach ($lines as $line) {
                $csv = str_getcsv($line, ' ');

                if($line !== '' && strrpos($line, '#', -strlen($line)) === false && stripos($csv[5], $name) !== false) {
                    $jobs[] = CronJob::createWith($csv);
                }
            }
        }

        return $jobs;
    }
}
