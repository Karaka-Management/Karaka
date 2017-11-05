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

namespace Tests\PHPUnit\phpOMS\Stdlib\Queue;

require_once __DIR__ . '/../../../../../phpOMS/Autoloader.php';

use phpOMS\Stdlib\Queue\PriorityMode;

class PriorityModeTest extends \PHPUnit\Framework\TestCase
{
	public function testEnums()
	{
		self::assertEquals(6, count(PriorityMode::getConstants()));
        self::assertEquals(1, PriorityMode::FIFO);
        self::assertEquals(2, PriorityMode::LIFO);
        self::assertEquals(4, PriorityMode::EARLIEST_DEADLINE);
        self::assertEquals(8, PriorityMode::SHORTEST_JOB);
        self::assertEquals(16, PriorityMode::HIGHEST);
        self::assertEquals(32, PriorityMode::LOWEST);
	}
}

