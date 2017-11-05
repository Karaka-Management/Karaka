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

namespace phpOMS\Version;

/**
 * Version class.
 *
 * Responsible for handling versions
 *
 * @category   Version
 * @package    Framework
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
class Version
{

    /**
     * Constructor.
     *
     * @since  1.0.0
     * @codeCoverageIgnore
     */
    private function __construct()
    {
    }

    /**
     * Comparing two versions.
     *
     * @param string $ver1 Version
     * @param string $ver2 Version
     *
     * @return int
     *
     * @since  1.0.0
     */
    public static function compare(string $ver1, string $ver2) : int
    {
        return version_compare($ver1, $ver2);
    }
}
