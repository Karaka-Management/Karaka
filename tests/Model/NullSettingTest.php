<?php
/**
 * Jingga
 *
 * PHP Version 8.1
 *
 * @package   tests
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.0
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

namespace tests\Model;

use Model\NullSetting;

/**
 * @internal
 */
#[\PHPUnit\Framework\Attributes\CoversClass(\Model\NullSetting::class)]
class NullSettingTest extends \PHPUnit\Framework\TestCase
{
    #[\PHPUnit\Framework\Attributes\Group('framework')]
    public function testDefault() : void
    {
        $null = new NullSetting(123);
        self::assertEquals(123, $null->getId());
    }
}
