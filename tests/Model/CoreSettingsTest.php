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
use Model\Settings;
use phpOMS\DataStorage\Database\Connection\NullConnection;

/**
 * @internal
 */
class CoreSettingsTest extends \PHPUnit\Framework\TestCase
{
    public function testSettingsGet() : void
    {
        $settings = new CoreSettings($GLOBALS['dbpool']->get());

        self::assertEquals([Settings::DEFAULT_ORGANIZATION => '1', Settings::PASSWORD_INTERVAL => '90'], $settings->get(null, [Settings::DEFAULT_ORGANIZATION, Settings::PASSWORD_INTERVAL]));
        self::assertEmpty($settings->get(null, ['12345678', '123456789']));
        self::assertEquals('1', $settings->get(null, Settings::DEFAULT_ORGANIZATION));
    }

    public function testSettingsSet() : void
    {
        $settings = new CoreSettings($GLOBALS['dbpool']->get());

        self::assertEmpty($settings->set([['name' => Settings::PASSWORD_INTERVAL, 'content' => '60']], true));
        self::assertEquals('60', $settings->get(null, Settings::PASSWORD_INTERVAL));

        self::assertEmpty($settings->set([['name' => Settings::PASSWORD_INTERVAL, 'content' => '90']], true));
        self::assertEquals('90', $settings->get(null, Settings::PASSWORD_INTERVAL));
    }

    public function testSettingsSave() : void
    {
        $settings = new CoreSettings($GLOBALS['dbpool']->get());

        $settings->save([['name' => Settings::PASSWORD_INTERVAL, 'content' => '60']]);
        self::assertEquals('60', $settings->get(null, Settings::PASSWORD_INTERVAL));

        $settings->set([['name' => Settings::PASSWORD_INTERVAL, 'content' => '90']], true);
        $settings->save();
        self::assertEquals('90', $settings->get(null, Settings::PASSWORD_INTERVAL));
    }

    public function testDbException() : void
    {
        $this->expectException(\Throwable::class);

        $settings = new CoreSettings(new NullConnection());
        $settings->get(null, [Settings::DEFAULT_ORGANIZATION, Settings::PASSWORD_INTERVAL]);
    }
}
