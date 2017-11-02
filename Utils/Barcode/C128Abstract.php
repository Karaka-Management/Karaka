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

use phpOMS\Stdlib\Base\Exception\InvalidEnumValue;

/**
 * Code 128 abstract class.
 *
 * @category   Log
 * @package    Framework
 * @license    OMS License 1.0
 * @link       http://orange-management.com
 * @since      1.0.0
 */
abstract class C128Abstract
{
    /**
     * Checksum.
     *
     * @var int
     * @since 1.0.0
     */
    protected static $CHECKSUM = 0;

    /**
     * Char weighted array.
     *
     * @var string[]
     * @since 1.0.0
     */
    protected static $CODEARRAY = [];

    /**
     * Code start.
     *
     * @var string
     * @since 1.0.0
     */
    protected static $CODE_START = '';

    /**
     * Code end.
     *
     * @var string
     * @since 1.0.0
     */
    protected static $CODE_END = '';

    /**
     * Orientation.
     *
     * @var int
     * @since 1.0.0
     */
    protected $orientation = 0;

    /**
     * Barcode dimension.
     *
     * @todo  : Implement!
     *
     * @var int[]
     * @since 1.0.0
     */
    protected $dimension = ['width' => 0, 'height' => 0];

    /**
     * Content to encrypt.
     *
     * @var string|int
     * @since 1.0.0
     */
    protected $content = 0;

    /**
     * Show text below barcode.
     *
     * @var string
     * @since 1.0.0
     */
    protected $showText = true;

    /**
     * Margin for barcode (padding).
     *
     * @var int[]
     * @since 1.0.0
     */
    protected $margin = ['top' => 0, 'right' => 4, 'bottom' => 0, 'left' => 4];

    /**
     * Background color.
     *
     * @var int[]
     * @since 1.0.0
     */
    protected $background = ['r' => 0, 'g' => 0, 'b' => 0, 'a' => 0];

    /**
     * Front color.
     *
     * @var int[]
     * @since 1.0.0
     */
    protected $front = ['r' => 0, 'g' => 0, 'b' => 0, 'a' => 0];

    /**
     * Constructor
     *
     * @param string $content     Content to encrypt
     * @param int    $width       Barcode width
     * @param int    $height      Barcode height
     * @param int    $orientation Orientation of the barcode
     *
     * @todo   : add mirror parameter
     *
     * @since  1.0.0
     */
    public function __construct(string $content = '', int $width = 20, int $height = 20, int $orientation = OrientationType::HORIZONTAL)
    {
        $this->content = $content;
        $this->setDimension($width, $height);
        $this->setOrientation($orientation);
    }

    /**
     * Set barcode dimensions
     *
     * @param int $width  Barcode width
     * @param int $height Barcode height
     *
     * @since  1.0.0
     */
    public function setDimension(int $width, int $height) /* : void */
    {
        if ($width < 0) {
            throw new \OutOfBoundsException($width);
        }

        if ($height < 0) {
            throw new \OutOfBoundsException($height);
        }

        $this->dimension['width']  = $width;
        $this->dimension['height'] = $height;
    }

    /**
     * Set barcode orientation
     *
     * @param int $orientation Barcode orientation
     *
     * @since  1.0.0
     */
    public function setOrientation(int $orientation) /* : void */
    {
        if (!OrientationType::isValidValue($orientation)) {
            throw new InvalidEnumValue($orientation);
        }

        $this->orientation = $orientation;
    }

    /**
     * Get content
     *
     * @return string
     *
     * @since  1.0.0
     */
    public function getContent() : string
    {
        return $this->content;
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
        $this->content = $content;
    }

    /**
     * Get image reference
     *
     * @return mixed
     *
     * @since  1.0.0
     */
    public function get()
    {
        $codeString = static::$CODE_START . $this->generateCodeString() . static::$CODE_END;

        return $this->createImage($codeString, 20);
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
        $keys       = array_keys(static::$CODEARRAY);
        $values     = array_flip($keys);
        $codeString = '';
        $length     = strlen($this->content);
        $checksum   = static::$CHECKSUM;

        for ($pos = 1; $pos <= $length; $pos++) {
            $activeKey = substr($this->content, ($pos - 1), 1);
            $codeString .= static::$CODEARRAY[$activeKey];
            $checksum += $values[$activeKey] * $pos;
        }

        $codeString .= static::$CODEARRAY[$keys[($checksum - (intval($checksum / 103) * 103))]];
        $codeString = static::$CODE_START . $codeString . static::$CODE_END;

        return $codeString;
    }

    /**
     * Create barcode image
     *
     * @param string $codeString Code string to render
     * @param int    $codeLength Barcode length (based on $codeString)
     *
     * @return mixed
     *
     * @since  1.0.0
     */
    protected function createImage(string $codeString, int $codeLength = 20)
    {
        for ($i = 1; $i <= strlen($codeString); $i++) {
            $codeLength = $codeLength + (int) (substr($codeString, ($i - 1), 1));
        }

        if ($this->orientation === OrientationType::HORIZONTAL) {
            $imgWidth  = max($codeLength, $this->dimension['width']);
            $imgHeight = $this->dimension['height'];
        } else {
            $imgWidth  = $this->dimension['width'];
            $imgHeight = max($codeLength, $this->dimension['height']);
        }

        $image    = imagecreate($imgWidth, $imgHeight);
        $black    = imagecolorallocate($image, 0, 0, 0);
        $white    = imagecolorallocate($image, 255, 255, 255);
        $location = 0;
        $length   = strlen($codeString);
        imagefill($image, 0, 0, $white);

        for ($position = 1; $position <= $length; $position++) {
            $cur_size = $location + (int) (substr($codeString, ($position - 1), 1));

            if ($this->orientation === OrientationType::HORIZONTAL) {
                imagefilledrectangle($image, $location, 0, $cur_size, $imgHeight, ($position % 2 == 0 ? $white : $black));
            } else {
                imagefilledrectangle($image, 0, $location, $imgWidth, $cur_size, ($position % 2 == 0 ? $white : $black));
            }

            $location = $cur_size;
        }

        return $image;
    }
}
