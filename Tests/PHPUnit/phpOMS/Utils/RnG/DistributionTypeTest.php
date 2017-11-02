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

namespace Tests\PHPUnit\phpOMS\Utils\RnG;

require_once __DIR__ . '/../../../../../phpOMS/Autoloader.php';

use phpOMS\Utils\RnG\DistributionType;

class DistributionTypeTest extends \PHPUnit\Framework\TestCase
{
    public function testEnums()
    {
        self::assertEquals(2, count(DistributionType::getConstants()));
        self::assertEquals(DistributionType::getConstants(), array_unique(DistributionType::getConstants()));
        
        self::assertEquals(0, DistributionType::UNIFORM);
        self::assertEquals(1, DistributionType::NORMAL);
    }
}
