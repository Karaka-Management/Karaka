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

use Model\NullSetting;

/**
 * @internal
 */
class NullSettingTest extends \PHPUnit\Framework\TestCase
{
    public function testDefault() : void
    {
        $null = new NullSetting(123);
        self::assertEquals(123, $null->getId());
    }
}
