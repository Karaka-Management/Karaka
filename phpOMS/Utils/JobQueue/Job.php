<?php
/**
 * Orange Management
 *
 * PHP Version 7.1
 *
 * @category   TBD
 * }
 * @package    TBD
 * @copyright  Dennis Eichhorn
 * @license    OMS License 1.0
 * @version    1.0.0
 * @link       http://website.orange-management.de
 */
declare(strict_types = 1);

namespace phpOMS\Utils\JobQueue;

/**
 * Array utils.
 *
 * @category   Framework
 * @package    phpOMS\Utils
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
class Job
{
    private $priority = 0.0;
    private $callback = null;

    public function __construct($callback, float $priority = 0.0)
    {
        $this->priority = $priority;
        $this->callback = $callback;
    }

    public function execute()
    {
        $this->callback();
    }

    public function getPriority() : float
    {
        return $this->priority;
    }

    public function setPriority(float $priority) /* : void */
    {
        $this->priority = $priority;
    }
}