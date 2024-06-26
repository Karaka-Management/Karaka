<?php
/**
 * Jingga
 *
 * PHP Version 8.2
 *
 * @package   tests
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.0
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

namespace tests\Model;

use Model\CoreSettings;
use Model\Setting;
use Model\SettingMapper;
use Modules\Admin\Models\SettingsEnum;

/**
 * @internal
 */
#[\PHPUnit\Framework\Attributes\CoversClass(\Model\CoreSettings::class)]
#[\PHPUnit\Framework\Attributes\CoversClass(\Model\Setting::class)]
#[\PHPUnit\Framework\Attributes\CoversClass(\Model\SettingMapper::class)]
class CoreSettingsTest extends \PHPUnit\Framework\TestCase
{
    protected CoreSettings $settings;

    protected function setUp() : void
    {
        $this->settings = new CoreSettings();
    }

    #[\PHPUnit\Framework\Attributes\Group('framework')]
    public function testSettingsGet() : void
    {
        $this->settings->set([
            [
                'name'    => SettingsEnum::PASSWORD_INTERVAL,
                'content' => '60',
            ],
        ], false);
        self::assertEquals('60', $this->settings->get(SettingsEnum::PASSWORD_INTERVAL)->content); // get from cache

        self::assertCount(2,
            $this->settings->get(null, [
                SettingsEnum::DEFAULT_UNIT,
                SettingsEnum::PASSWORD_INTERVAL,
            ])
        );

        self::assertEmpty($this->settings->get(null, ['12345678', '123456789']));
        self::assertEquals(
            '1',
            $this->settings->get(null, SettingsEnum::DEFAULT_UNIT)->content
        );
    }

    #[\PHPUnit\Framework\Attributes\Group('framework')]
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
            $this->settings->get(null, SettingsEnum::PASSWORD_INTERVAL)->content
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
            $this->settings->get(null, SettingsEnum::PASSWORD_INTERVAL)->content
        );
    }

    #[\PHPUnit\Framework\Attributes\Group('framework')]
    public function testSettingsCreate() : void
    {
        self::assertEmpty(
            $this->settings->create([
                'name'    => 'test_name',
                'content' => '60',
            ])
        );

        $settings = new CoreSettings();
        self::assertEquals(
            '60',
            $settings->get(null, 'test_name')->content
        );
    }

    #[\PHPUnit\Framework\Attributes\Group('framework')]
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
            $this->settings->get(null, SettingsEnum::PASSWORD_INTERVAL)->content
        );

        // But not stored in database
        $settings2 = new CoreSettings();
        self::assertEquals(
            '90',
            $settings2->get(null, SettingsEnum::PASSWORD_INTERVAL)->content
        );
    }

    #[\PHPUnit\Framework\Attributes\Group('framework')]
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
            $this->settings->get(null, SettingsEnum::PASSWORD_INTERVAL)->content
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
            $this->settings->get(null, SettingsEnum::PASSWORD_INTERVAL)->content
        );
    }

    #[\PHPUnit\Framework\Attributes\Group('framework')]
    public function testSetWithSave() : void
    {
        $setting = new Setting();
        $setting->with(0, 'name', 'content', '', null, 1, 'Admin', 1, 1);
        $testId = SettingMapper::create()->execute($setting);

        $this->settings->set([
            [
                'id'       => $testId,
                'name'     => 'name',
                'content'  => 'new content',
                'pattern'  => '',
                'unit'     => null,
                'app'      => 1,
                'module'   => 'Admin',
                'group'    => 1,
                'account'  => 1,
            ],
        ], true);

        $settingR = SettingMapper::get()->where('id', $testId)->execute();
        self::assertEquals('new content', $settingR->content);

        $settingR2 = $this->settings->get($testId);
        self::assertEquals('new content', $settingR2->content);
    }
}
