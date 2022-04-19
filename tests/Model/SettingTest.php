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

/**
 * @internal
 */
class SettingTest extends \PHPUnit\Framework\TestCase
{
    private Setting $setting;

    protected function setUp() : void
    {
        $this->setting = new Setting();
    }

    /**
     * @covers Model\Setting
     * @group framework
     */
    public function testDefault() : void
    {
        self::assertEquals(0, $this->setting->getId());
    }

    /**
     * @covers Model\Setting
     * @group framework
     */
    public function testWithInitailization() : void
    {
        $this->setting->with(1, 'name', 'content', 'pattern', 1, 'module', 2, 3);
        self::assertEquals(1, $this->setting->getId());
        self::assertEquals('name', $this->setting->name);
        self::assertEquals('content', $this->setting->content);
        self::assertEquals('pattern', $this->setting->pattern);
        self::assertEquals('module', $this->setting->module);
        self::assertEquals(1, $this->setting->app);
        self::assertEquals(2, $this->setting->group);
        self::assertEquals(3, $this->setting->account);
    }
}
