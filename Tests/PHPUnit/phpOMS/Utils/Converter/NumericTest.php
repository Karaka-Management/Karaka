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

namespace Tests\PHPUnit\phpOMS\Utils\Converter;

require_once __DIR__ . '/../../../../../phpOMS/Autoloader.php';

use phpOMS\Utils\Converter\Numeric;

class NumericTest extends \PHPUnit\Framework\TestCase
{
	public function testArabicRoman()
	{
		$rand = mt_rand(1, 9999);
		self::assertEquals($rand, Numeric::romanToArabic(Numeric::arabicToRoman($rand)));

		self::assertEquals('VIII', Numeric::arabicToRoman(8));
		self::assertEquals('IX', Numeric::arabicToRoman(9));
		self::assertEquals('X', Numeric::arabicToRoman(10));
		self::assertEquals('XI', Numeric::arabicToRoman(11));
	}

	public function testBase()
	{
		self::assertEquals('443', Numeric::convertBase('123', '0123456789', '01234'));
		self::assertEquals('7B', Numeric::convertBase('123', '0123456789', '0123456789ABCDEF'));
		self::assertEquals('173', Numeric::convertBase('123', '0123456789', '01234567'));

		self::assertEquals('123', Numeric::convertBase('443', '01234', '0123456789'));
		self::assertEquals('123', Numeric::convertBase('7B', '0123456789ABCDEF', '0123456789'));
		self::assertEquals('123', Numeric::convertBase('173', '01234567', '0123456789'));
	}
}
