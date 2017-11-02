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
 * @link       http://orange-management.com
 */

namespace Tests\PHPUnit\phpOMS\Utils\Encoding;

require_once __DIR__ . '/../../../../../phpOMS/Autoloader.php';

use phpOMS\Utils\Encoding\XorEncoding;
use phpOMS\Utils\RnG\StringUtils;

class XorEncodingTest extends \PHPUnit\Framework\TestCase
{
	public function testEncoding()
	{
		$test = XorEncoding::encode('This is a test.', 'abcd');
		self::assertEquals(hex2bin('350a0a17410b10440042170112164d'), XorEncoding::encode('This is a test.', 'abcd'));
		self::assertEquals('This is a test.', XorEncoding::decode(hex2bin('350a0a17410b10440042170112164d'), 'abcd'));
	}

	public function testVolume()
	{
		for($i = 0; $i < 100; $i++) {
			$raw = StringUtils::generateString(1, 100);
			$key = StringUtils::generateString(1, 100);

			self::assertEquals($raw, XorEncoding::decode(XorEncoding::encode($raw, $key), $key));
		}
	}
}

