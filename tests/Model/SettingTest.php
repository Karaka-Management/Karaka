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

use Model\Setting;

/**
 * @internal
 */
#[\PHPUnit\Framework\Attributes\CoversClass(\Model\Setting::class)]
class SettingTest extends \PHPUnit\Framework\TestCase
{
    private Setting $setting;

    protected function setUp() : void
    {
        $this->setting = new Setting();
    }

    #[\PHPUnit\Framework\Attributes\Group('framework')]
    public function testDefault() : void
    {
        self::assertEquals(0, $this->setting->getId());
    }

    #[\PHPUnit\Framework\Attributes\Group('framework')]
    public function testWithInitailization() : void
    {
        $this->setting->with(1, 'name', 'content', 'pattern', 2, 3, 'module', 4, 5);
        self::assertEquals(1, $this->setting->getId());
        self::assertEquals('name', $this->setting->name);
        self::assertEquals('content', $this->setting->content);
        self::assertEquals('pattern', $this->setting->pattern);
        self::assertEquals('module', $this->setting->module);
        self::assertEquals(2, $this->setting->unit);
        self::assertEquals(3, $this->setting->app);
        self::assertEquals(4, $this->setting->group);
        self::assertEquals(5, $this->setting->account);
    }
}
