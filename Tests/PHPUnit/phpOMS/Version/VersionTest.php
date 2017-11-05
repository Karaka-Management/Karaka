<?php
/**
 * Orange Management
 *
 * PHP Version 7.1
 *
 * @category   TBD
 * @package    TBD
 * @author     OMS Development Team <dev@oms.com>
 * @copyright  Dennis Eichhorn
 * @license    OMS License 1.0
 * @version    1.0.0
 * @link       http://website.orange-management.de
 */

namespace Tests\PHPUnit\phpOMS\Version;

use phpOMS\Version\Version;

require_once __DIR__ . '/../../../../phpOMS/Autoloader.php';

class VersionTest extends \PHPUnit\Framework\TestCase
{
    public function testVersionCompare()
    {
        $version1 = '1.23.456';
        $version2 = '1.23.567';

        self::assertEquals(Version::compare($version1, $version1), 0);
        self::assertEquals(Version::compare($version1, $version2), -1);
        self::assertEquals(Version::compare($version2, $version1), 1);
    }
}
