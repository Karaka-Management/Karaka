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

namespace Tests\PHPUnit\Install;

use Model\CoreSettings;
use phpOMS\DataStorage\Database\DatabasePool;

require_once __DIR__ . '/../../../phpOMS/Autoloader.php';
require_once __DIR__ . '/../../../config.php';

class CoreSettingsTest extends \PHPUnit\Framework\TestCase
{

    public function testSettings()
    {
        $settings = new CoreSettings($GLOBALS['dbpool']->get());

        self::assertEquals([1000000009 => 'Orange Management', 1000000029 => 'en'], $settings->get([1000000009, 1000000029]));
        self::assertEmpty($settings->get([12345678, 123456789]));
        self::assertEquals([1000000009 => 'Orange Management'], $settings->get(1000000009));
    }
}
