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

namespace Tests\PHPUnit\phpOMS\Utils\RnG;

require_once __DIR__ . '/../../../../../phpOMS/Autoloader.php';

use phpOMS\Utils\RnG\DateTime;

class DateTimeTest extends \PHPUnit\Framework\TestCase
{
	public function testRnG()
	{
		for($i = 0; $i < 100; $i++) {
			$dateMin = new \DateTime();
			$dateMax = new \DateTime();

			$min = mt_rand(0, PHP_INT_MAX-2);
			$max = mt_rand($min + 1, PHP_INT_MAX);

			$dateMin->setTimestamp($min);
			$dateMax->setTimestamp($max);

			$rng = DateTime::generateDateTime($dateMin, $dateMax);

			self::assertTrue($rng->getTimestamp() >= $min && $rng->getTimestamp() <= $max);
		}
	}
}
