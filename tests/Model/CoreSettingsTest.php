<?php
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
declare(strict_types=1);

namespace tests\Model;

use Model\CoreSettings;
use Model\Setting;
use Model\SettingMapper;
use Model\SettingsEnum;
use phpOMS\DataStorage\Database\Connection\NullConnection;

/**
 * @internal
 */
class CoreSettingsTest extends \PHPUnit\Framework\TestCase
{
    protected CoreSettings $settings;

    protected function setUp() : void
    {
        $this->settings = new CoreSettings($GLOBALS['dbpool']->get());
    }

    /**
     * @covers Model\CoreSettings
     * @group framework
     */
    public function testSettingsGet() : void
    {
        self::assertCount(2,
            $this->settings->get(null, [
                SettingsEnum::DEFAULT_ORGANIZATION,
                SettingsEnum::PASSWORD_INTERVAL,
            ])
        );

        self::assertEmpty($this->settings->get(null, ['12345678', '123456789']));
        self::assertEquals(
            '1',
            $this->settings->get(null, SettingsEnum::DEFAULT_ORGANIZATION)['content']
        );
    }

    /**
     * @covers Model\CoreSettings
     * @group framework
     */
    public function testSettingsSet() : void
    {
        self::assertEmpty(
            $this->settings->set([
                [
                    'name'    => SettingsEnum::PASSWORD_INTERVAL,
                    'content' => '60',
                ],
            ], true)
        );

        self::assertEquals(
            '60',
            $this->settings->get(null, SettingsEnum::PASSWORD_INTERVAL)['content']
        );

        self::assertEmpty(
            $this->settings->set([
                [
                    'name'    => SettingsEnum::PASSWORD_INTERVAL,
                    'content' => '90',
                ],
            ], true)
        );

        self::assertEquals(
            '90',
            $this->settings->get(null, SettingsEnum::PASSWORD_INTERVAL)['content']
        );
    }

    /**
     * @covers Model\CoreSettings
     * @group framework
     */
    public function testSettingsSetWithoutStore() : void
    {
        self::assertEmpty(
            $this->settings->set([
                [
                    'name'    => SettingsEnum::PASSWORD_INTERVAL,
                    'content' => '60',
                ],
            ], false)
        );

        // Stored in settings
        self::assertEquals(
            '60',
            $this->settings->get(null, SettingsEnum::PASSWORD_INTERVAL)['content']
        );

        // But not stored in database
        $settings2 = new CoreSettings($GLOBALS['dbpool']->get());
        self::assertEquals(
            '90',
            $settings2->get(null, SettingsEnum::PASSWORD_INTERVAL)['content']
        );
    }

    /**
     * @covers Model\CoreSettings
     * @group framework
     */
    public function testSettingsSave() : void
    {
        $this->settings->save([
            [
                'name'    => SettingsEnum::PASSWORD_INTERVAL,
                'content' => '60',
            ],
        ]);

        self::assertEquals(
            '60',
            $this->settings->get(null, SettingsEnum::PASSWORD_INTERVAL)['content']
        );

        $this->settings->set([
            [
                'name'    => SettingsEnum::PASSWORD_INTERVAL,
                'content' => '90', ],
            ], true
        );

        $this->settings->save();
        self::assertEquals(
            '90',
            $this->settings->get(null, SettingsEnum::PASSWORD_INTERVAL)['content']
        );
    }

    /**
     * @covers Model\CoreSettings
     * @group framework
     */
    public function testSetWithSave() : void
    {
        $setting = new Setting();
        $setting->with(0, 'name', 'content', 'Admin', 1, 1);
        $testId = SettingMapper::create($setting);

        $this->settings->set([
            [
                'id'      => $testId,
                'name'    => 'name',
                'content' => 'new content',
                'module'  => 'Admin',
                'group'   => 1,
                'account' => 1,
            ],
        ], true);

        $settingR = SettingMapper::get($testId);
        self::assertEquals('new content', $settingR->content);

        $settingR2 = $this->settings->get($testId, 'name', 'Admin', 1, 1);
        self::assertEquals('new content', $settingR2['content']);
    }

    /**
     * @covers Model\CoreSettings
     * @group framework
     */
    public function testDbException() : void
    {
        $this->expectException(\Throwable::class);

        $this->settings = new CoreSettings(new NullConnection());
        $this->settings->get(null, [SettingsEnum::DEFAULT_ORGANIZATION, SettingsEnum::PASSWORD_INTERVAL]);
    }
}
