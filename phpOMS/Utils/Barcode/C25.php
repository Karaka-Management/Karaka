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
 * Code 25 class.
 *
 * @category   Log
 * @package    Framework
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
class C25 extends C128Abstract
{
    /**
     * Char array.
     *
     * @var string[]
     * @since 1.0.0
     */
    protected static $CODEARRAY = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '0'];

    /**
     * Char weighted array.
     *
     * @var string[]
     * @since 1.0.0
     */
    protected static $CODEARRAY2 = [
        '3-1-1-1-3', '1-3-1-1-3', '3-3-1-1-1', '1-1-3-1-3', '3-1-3-1-1',
        '1-3-3-1-1', '1-1-1-3-3', '3-1-1-3-1', '1-3-1-3-1', '1-1-3-3-1',
    ];

    /**
     * Code start.
     *
     * @var string
     * @since 1.0.0
     */
    protected static $CODE_START = '1111';

    /**
     * Code end.
     *
     * @var string
     * @since 1.0.0
     */
    protected static $CODE_END = '311';

    /**
     * Constructor
     *
     * @param string $content     Content to encrypt
     * @param int    $width        Barcode width
     * @param int    $height        Barcode height
     * @param int    $orientation Orientation of the barcode
     *
     * @todo   : add mirror parameter
     *
     * @since  1.0.0
     */
    public function __construct(string $content = '', int $width = 100, int $height = 20, int $orientation = OrientationType::HORIZONTAL)
    {
        if (!ctype_digit($content)) {
            throw new \InvalidArgumentException($content);
        }

        parent::__construct($content, $width, $height, $orientation);
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
        if (!ctype_digit($content)) {
            throw new \InvalidArgumentException($content);
        }

        parent::setContent($content);
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
        $codeString  = '';
        $length      = strlen($this->content);
        $arrayLength = count(self::$CODEARRAY);
        $temp        = [];

        for ($posX = 1; $posX <= $length; $posX++) {
            for ($posY = 0; $posY < $arrayLength; $posY++) {
                if (substr($this->content, ($posX - 1), 1) == self::$CODEARRAY[$posY]) {
                    $temp[$posX] = self::$CODEARRAY2[$posY];
                }
            }
        }

        for ($posX = 1; $posX <= $length; $posX += 2) {
            if (isset($temp[$posX], $temp[($posX + 1)])) {
                $temp1 = explode('-', $temp[$posX]);
                $temp2 = explode('-', $temp[($posX + 1)]);

                $count = count($temp1);
                for ($posY = 0; $posY < $count; $posY++) {
                    $codeString .= $temp1[$posY] . $temp2[$posY];
                }
            }
        }

        return $codeString;
    }
}
