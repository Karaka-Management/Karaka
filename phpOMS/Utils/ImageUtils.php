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

namespace phpOMS\Utils;

/**
 * Image utils class.
 *
 * This class provides static helper functionalities for images.
 *
 * @category   Framework
 * @package    phpOMS\Utils
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
class ImageUtils
{
    /**
     * Decode base64 image.
     *
     * @param string $img Encoded image
     *
     * @return string Decoded image
     *
     * @since  1.0.0
     */
    public static function decodeBase64Image(string $img) : string
    {
        $img = str_replace('data:image/png;base64,', '', $img);
        $img = str_replace(' ', '+', $img);

        return base64_decode($img);
    }
}
