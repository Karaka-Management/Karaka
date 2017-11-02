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

namespace phpOMS\Utils\IO\Json;

/**
 * Json decoding exception class.
 *
 * @category   Framework
 * @package    phpOMS\Utils\IO\Json
 * @license    OMS License 1.0
 * @link       http://orange-management.com
 * @since      1.0.0
 */
class InvalidJsonException extends \UnexpectedValueException
{
    /**
     * Constructor.
     *
     * @param string     $message Exception message
     * @param int        $code    Exception code
     * @param \Exception $previous Previous exception
     *
     * @since  1.0.0
     */
    public function __construct($message, $code = 0, \Exception $previous = null)
    {
        parent::__construct('Couldn\'t parse "' . $message . '" as valid json.', $code, $previous);
    }
}
