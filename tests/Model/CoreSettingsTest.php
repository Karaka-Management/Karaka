<?php declare(strict_types=1);
/**
 * Orange Management
 *
 * PHP Version 7.4
 *
 * @package   tests
 * @copyright Dennis Eichhorn
 * @license   OMS License 1.0
 * @version   1.0.0
 * @link      https://orange-management.org
 */

namespace tests\Model;

use Model\CoreSettings;
use phpOMS\DataStorage\Database\Connection\NullConnection;

/**
 * @internal
 */
class CoreSettingsTest extends \PHPUnit\Framework\TestCase
{
    public function testSettingsGet() : void
    {
        $settings = new CoreSettings($GLOBALS['dbpool']->get());

        self::assertEquals(['1000000009' => '1', '1000000020' => 'en'], $settings->get(null, ['1000000009', '1000000020']));
        self::assertEmpty($settings->get(null, ['12345678', '123456789']));
        self::assertEquals('1', $settings->get(null, '1000000009'));
    }

    public function testSettingsSet() : void
    {
        $settings = new CoreSettings($GLOBALS['dbpool']->get());

        self::assertEmpty($settings->set([['name' => '1000000020', 'content' => 'de']], true));
        self::assertEquals('de', $settings->get(null, '1000000020'));

        self::assertEmpty($settings->set([['name' => '1000000020', 'content' => 'en']], true));
        self::assertEquals('en', $settings->get(null, '1000000020'));
    }

    public function testSettingsSave() : void
    {
        $settings = new CoreSettings($GLOBALS['dbpool']->get());

        $settings->save([['name' => '1000000020', 'content' => 'uk']]);
        self::assertEquals('uk', $settings->get(null, '1000000020'));

        $settings->set([['name' => '1000000020', 'content' => 'en']], true);
        $settings->save();
        self::assertEquals('en', $settings->get(null, '1000000020'));
    }

    public function testDbException() : void
    {
        self::expectException(\Throwable::class);

        $settings = new CoreSettings(new NullConnection());
        $settings->get(null, ['1000000009', '1000000020']);
    }
}
