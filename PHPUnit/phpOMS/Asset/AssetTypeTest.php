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
 * @link       http://orange-management.com
 */

namespace Tests\PHPUnit\phpOMS\Asset;

require_once __DIR__ . '/../../../../phpOMS/Autoloader.php';

use phpOMS\Asset\AssetType;

class AssetTypeTest extends \PHPUnit\Framework\TestCase
{
    public function testEnums()
    {
        self::assertEquals(3, count(AssetType::getConstants()));
        self::assertEquals(0, AssetType::CSS);
        self::assertEquals(1, AssetType::JS);
        self::assertEquals(2, AssetType::JSLATE);
    }
}
