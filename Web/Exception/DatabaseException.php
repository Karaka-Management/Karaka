<?php
/**
 * Orange Management
 *
 * PHP Version 7.1
 *
 * @package    Web\Exception
 * @copyright  Dennis Eichhorn
 * @license    OMS License 1.0
 * @version    1.0.0
 * @link       http://website.orange-management.de
 */
namespace Web\Exception;

/**
 * Permission exception class.
 *
 * @package    Web\Exception
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
class DatabaseException extends \RuntimeException
{
    /**
     * Constructor.
     *
     * @param string     $message  Exception message
     * @param int        $code     Exception code
     * @param \Exception $previous Previous exception
     *
     * @since  1.0.0
     */
    public function __construct(string $message, int $code = 0, \Exception $previous = null)
    {
        parent::__construct('The database failed with "' . $message . '".', $code, $previous);
    }
}
