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

namespace phpOMS\Utils\Barcode;

/**
 * Code 39 class.
 *
 * @category   Log
 * @package    Framework
 * @license    OMS License 1.0
 * @link       http://orange-management.com
 * @since      1.0.0
 */
class C39 extends C128Abstract
{
    /**
     * Char weighted array.
     *
     * @var string[]
     * @since 1.0.0
     */
    protected static $CODEARRAY = [
        '0' => '111221211', '1' => '211211112', '2' => '112211112', '3' => '212211111', '4' => '111221112',
        '5' => '211221111', '6' => '112221111', '7' => '111211212', '8' => '211211211', '9' => '112211211',
        'A' => '211112112', 'B' => '112112112', 'C' => '212112111', 'D' => '111122112', 'E' => '211122111',
        'F' => '112122111', 'G' => '111112212', 'H' => '211112211', 'I' => '112112211', 'J' => '111122211',
        'K' => '211111122', 'L' => '112111122', 'M' => '212111121', 'N' => '111121122', 'O' => '211121121',
        'P' => '112121121', 'Q' => '111111222', 'R' => '211111221', 'S' => '112111221', 'T' => '111121221',
        'U' => '221111112', 'V' => '122111112', 'W' => '222111111', 'X' => '121121112', 'Y' => '221121111',
        'Z' => '122121111', '-' => '121111212', '.' => '221111211', ' ' => '122111211', '$' => '121212111',
        '/' => '121211121', '+' => '121112121', '%' => '111212121', '*' => '121121211',
    ];

    /**
     * Code start.
     *
     * @var string
     * @since 1.0.0
     */
    protected static $CODE_START = '1211212111';

    /**
     * Code end.
     *
     * @var string
     * @since 1.0.0
     */
    protected static $CODE_END = '121121211';

    /**
     * Constructor
     *
     * @param string $content     Content to encrypt
     * @param int    $size        Barcode height
     * @param int    $orientation Orientation of the barcode
     *
     * @todo   : add mirror parameter
     *
     * @since  1.0.0
     */
    public function __construct(string $content = '', int $size = 20, int $orientation = OrientationType::HORIZONTAL)
    {
        parent::__construct(strtoupper($content), $size, $orientation);
    }

    /**
     * Set content to encrypt
     *
     * @param string $content Barcode content
     *
     * @since  1.0.0
     */
    public function setContent(string $content) /* : void */
    {
        parent::setContent(strtoupper($content));
    }

    /**
     * Generate weighted code string
     *
     * @return string
     *
     * @since  1.0.0
     */
    protected function generateCodeString() : string
    {
        $codeString = '';
        $length     = strlen($this->content);

        for ($X = 1; $X <= $length; $X++) {
            $codeString .= self::$CODEARRAY[substr($this->content, ($X - 1), 1)] . '1';
        }

        return $codeString;
    }
}
