<?php
/**
 * Orange Management
 *
 * PHP Version 7.1
 *
 * @category   TBD
 * @package    TBD
 * @author     OMS Development Team <dev@oms.com>
 * @copyright  Dennis Eichhorn
 * @license    OMS License 1.0
 * @version    1.0.0
 * @link       http://website.orange-management.de
 */

namespace Tests\PHPUnit\phpOMS\Utils;

use phpOMS\Utils\StringUtils;

require_once __DIR__ . '/../../../../phpOMS/Autoloader.php';

class StringUtilsTest extends \PHPUnit\Framework\TestCase
{
    public function testEvaluation()
    {
        self::assertTrue(abs(2.5 - StringUtils::getEntropy('akj@!0aj')) < 0.1);
    }

    public function testStartsEnds()
    {
        $string = 'This is a test string.';
        self::assertTrue(StringUtils::startsWith($string, 'This '));
        self::assertFalse(StringUtils::startsWith($string, 'Thss '));
        self::assertTrue(StringUtils::endsWith($string, 'string.'));
        self::assertFalse(StringUtils::endsWith($string, 'strng.'));

        self::assertTrue(StringUtils::mb_startsWith($string, 'This '));
        self::assertFalse(StringUtils::mb_startsWith($string, 'Thss '));
        self::assertTrue(StringUtils::mb_endsWith($string, 'string.'));
        self::assertFalse(StringUtils::mb_endsWith($string, 'strng.'));
    }

    public function testTransform()
    {
        self::assertEquals('This ', StringUtils::mb_ucfirst('this '));
        self::assertNotEquals('this ', StringUtils::mb_ucfirst('this '));
        self::assertEquals('thss', StringUtils::mb_lcfirst('Thss'));
        self::assertNotEquals('Thss', StringUtils::mb_lcfirst('Thss'));
    }

    public function testTrim()
    {
        $string = 'This is a test string.';

        self::assertEquals($string, StringUtils::mb_trim($string, ' '));
        self::assertEquals('This is a test string', StringUtils::mb_trim($string, '.'));
        self::assertEquals('asdf', StringUtils::mb_trim(' asdf ', ' '));
        self::assertEquals('asdf', StringUtils::mb_trim('%asdf%', '%'));

        self::assertEquals(' asdf', StringUtils::mb_rtrim(' asdf   '));
        self::assertEquals('%asdf', StringUtils::mb_rtrim('%asdf%', '%'));

        self::assertEquals('asdf  ', StringUtils::mb_ltrim(' asdf  '));
        self::assertEquals('asdf%', StringUtils::mb_ltrim('%asdf%', '%'));
    }

    public function testContains()
    {
        $string = 'This is a test string.';

        self::assertTrue(StringUtils::contains($string, ['is', 'nothing', 'string']));
        self::assertFalse(StringUtils::contains($string, ['iss', 'nothing', 'false']));

        self::assertTrue(StringUtils::mb_contains($string, ['is', 'nothing', 'string']));
        self::assertFalse(StringUtils::mb_contains($string, ['iss', 'nothing', 'false']));
    }

    public function testCount()
    {
        self::assertEquals(5, StringUtils::mb_count_chars('αααααΕεΙιΜμΨψ')['α']);
        self::assertEquals(4, StringUtils::countCharacterFromStart('    Test string', ' '));
        self::assertEquals(0, StringUtils::countCharacterFromStart('    Test string', 's'));
    }
}
