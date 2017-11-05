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

namespace Tests\PHPUnit\phpOMS\Localization;

require_once __DIR__ . '/../../../../phpOMS/Autoloader.php';

use phpOMS\Localization\NullLocalization;
use phpOMS\Localization\Localization;

class NullLocalizationTest extends \PHPUnit\Framework\TestCase
{
    public function testNullModel()
    {
        self::assertInstanceOf(Localization::class, new NullLocalization());
    }
}
