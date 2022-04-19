<?php
/**
 * Karaka
 *
 * PHP Version 8.1
 *
 * @package   tests
 * @copyright Dennis Eichhorn
 * @license   OMS License 1.0
 * @version   1.0.0
 * @link      https://karaka.app
 */
declare(strict_types=1);

namespace tests\Model;

use Model\Setting;
use Model\SettingMapper;

/**
 * @internal
 */
class SettingMapperTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @covers Model\SettingMapper
     * @group framework
     */
    public function testCR() : void
    {
        $setting = new Setting();
        $setting->with(0, 'name', 'content', 'pattern', 1, 'Admin', 1, 1);
        $id = SettingMapper::create()->execute($setting);

        $settingR = SettingMapper::get()->where('id', $setting->getId())->execute();
        self::assertGreaterThan(0, $id);
        self::assertEquals($id, $settingR->getId());
        self::assertEquals($setting->getId(), $settingR->getId());
        self::assertEquals($setting->name, $settingR->name);
        self::assertEquals($setting->content, $settingR->content);
        self::assertEquals($setting->pattern, $settingR->pattern);
        self::assertEquals($setting->app, $settingR->app);
        self::assertEquals($setting->module, $settingR->module);
        self::assertEquals($setting->group, $settingR->group);
        self::assertEquals($setting->account, $settingR->account);
    }
}
