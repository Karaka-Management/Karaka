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
 * Filesystem class.
 *
 * Performing operations on the file system
 *
 * @category   System
 * @package    phpOMS\Utils\TaskSchedule
 * @license    OMS License 1.0
 * @link       http://orange-management.com
 * @since      1.0.0
 */
class InvalidTaskParameterException extends \UnexpectedValueException
{
    public function __construct($message, $code = 0, \Exception $previous = null)
    {
        parent::__construct('The parameter "' . $message . '" is not valid for this task.', $code, $previous);
    }
}
