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

use phpOMS\Utils\ArrayUtils;

require_once __DIR__ . '/../../../../phpOMS/Autoloader.php';

class ArrayUtilsTest extends \PHPUnit\Framework\TestCase
{
    public function testArrayGetSet()
    {
        $expected = [
            'a' => [
                'aa' => 1,
                'ab' => [
                    'aba',
                    'ab0',
                    [
                        3,
                        'c',
                    ],
                    4,
                ],
            ],
            2 => '2a',
        ];

        $actual = [];
        $actual = ArrayUtils::setArray('a/aa', $actual, 1, '/');
        $actual = ArrayUtils::setArray('a/ab', $actual, ['aba'], '/');
        $actual = ArrayUtils::setArray('a/ab', $actual, 'abb', '/');
        $actual = ArrayUtils::setArray('2', $actual, '2a', '/');
        $actual = ArrayUtils::setArray('a/ab/1', $actual, 'ab0', '/', true);
        $actual = ArrayUtils::setArray('a/ab', $actual, [3, 4], '/');
        $actual = ArrayUtils::setArray('a/ab/2', $actual, 'c', '/');

        var_dump($actual);

        self::assertEquals($expected, $actual);
        self::assertEquals('ab0', ArrayUtils::getArray('a/ab/1', $expected));
    }

    public function testArrayInRecursive()
    {
        $expected = [
            'a' => [
                'aa' => 1,
                'ab' => [
                    'aba',
                    'ab0',
                ],
            ],
            2 => '2a',
        ];

        self::assertTrue(ArrayUtils::inArrayRecursive('aba', $expected));
        self::assertFalse(ArrayUtils::inArrayRecursive('aba', ArrayUtils::unsetArray('a/ab', $expected, '/')));
    }

    public function testArrayConversion()
    {
        $expected = [
            'a' => [
                'aa' => 1,
                'ab' => [
                    'aba',
                    'ab0',
                ],
            ],
            2 => '2a',
        ];

        $expected_str = "['a' => ['aa' => 1, 'ab' => [0 => 'aba', 1 => 'ab0', ], ], 2 => '2a', ]";

        self::assertEquals($expected_str, ArrayUtils::stringify($expected));
        self::assertEquals('2;3;1;"""Text;"' . "\n", ArrayUtils::arrayToCSV(['a' => 2, 3, 1, '"Text;'], ';', '"', '\\'));
    }

    public function testArrayRecursiveManipulation()
    {
        $numArr = [1, 2, 3, 4];
        $numArrRec = [1, [2, [3, 4]]];
        self::assertEquals(10, ArrayUtils::arraySumRecursive($numArrRec));
        self::assertEquals($numArr, ArrayUtils::arrayFlatten($numArrRec));
    }

    public function testArraySum()
    {
        $numArr = [1, 2, 3, 4];
        self::assertEquals(10, ArrayUtils::arraySum($numArr));
        self::assertEquals(9, ArrayUtils::arraySum($numArr, 1));
        self::assertEquals(5, ArrayUtils::arraySum($numArr, 1, 2));
    }

    public function testArrayAllIn()
    {
        $numArr = [1, 2, 3, 4];
        self::assertTrue(ArrayUtils::allInArray([], $numArr));
        self::assertTrue(ArrayUtils::allInArray([1, 3, 4], $numArr));
        self::assertTrue(ArrayUtils::allInArray([1, 2, 3, 4], $numArr));
        self::assertFalse(ArrayUtils::allInArray([1, 5, 3], $numArr));
    }

    public function testArrayAnyIn()
    {
        $numArr = [1, 2, 3, 4];
        self::assertTrue(ArrayUtils::anyInArray($numArr, [2, 6, 8]));
        self::assertFalse(ArrayUtils::anyInArray($numArr, [10, 22]));
    }
}
