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

namespace phpOMS\Utils\Barcode;

/**
 * Codebar class.
 *
 * @category   Log
 * @package    Framework
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
class Codebar extends C128Abstract
{
    /**
     * Char array.
     *
     * @var string[]
     * @since 1.0.0
     */
    protected static $CODEARRAY = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '0', '-', '$', ':', '/', '.', '+', 'A', 'B', 'C', 'D'];

    /**
     * Char weighted array.
     *
     * @var string[]
     * @since 1.0.0
     */
    protected static $CODEARRAY2 = [
        '1111221', '1112112', '2211111', '1121121', '2111121', '1211112', '1211211', '1221111', '2112111', '1111122',
        '1112211', '1122111', '2111212', '2121112', '2121211', '1121212', '1122121', '1212112', '1112122', '1112221',
    ];

    /**
     * Code start.
     *
     * @var string
     * @since 1.0.0
     */
    protected static $CODE_START = '11221211';

    /**
     * Code end.
     *
     * @var string
     * @since 1.0.0
     */
    protected static $CODE_END = '1122121';

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
        $lenCodearr = count(self::$CODEARRAY);

        for ($posX = 1; $posX <= $length; $posX++) {
            for ($posY = 0; $posY < $lenCodearr; $posY++) {
                if (substr($this->content, ($posX - 1), 1) == self::$CODEARRAY[$posY]) {
                    $codeString .= self::$CODEARRAY2[$posY] . '1';
                }
            }
        }

        return $codeString;
    }
}
