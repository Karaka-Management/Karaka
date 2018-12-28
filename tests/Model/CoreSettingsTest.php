<?php
/**
 * Orange Management
 *
 * PHP Version 7.2
 *
 * @package    tests
 * @copyright  Dennis Eichhorn
 * @license    OMS License 1.0
 * @version    1.0.0
 * @link       http://website.orange-management.de
 */

namespace tests\Model;

use Model\CoreSettings;

class CoreSettingsTest extends \PHPUnit\Framework\TestCase
{

    public function testSettings()
    {
        $settings = new CoreSettings($GLOBALS['dbpool']->get());

        self::assertEquals([1000000009 => 'Orange Management', 1000000020 => 'en'], $settings->get([1000000009, 1000000020]));
        self::assertEmpty($settings->get([12345678, 123456789]));
        self::assertEquals('Orange Management', $settings->get(1000000009));
    }
}
