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

namespace Tests\PHPUnit\phpOMS\DataStorage\Database\Query;

require_once __DIR__ . '/../../../../../../phpOMS/Autoloader.php';

use phpOMS\DataStorage\Database\Query\JoinType;

class JoinTypeTest extends \PHPUnit\Framework\TestCase
{
    public function testEnums()
    {
        self::assertEquals(11, count(JoinType::getConstants()));
        self::assertEquals(JoinType::getConstants(), array_unique(JoinType::getConstants()));

        self::assertEquals('JOIN', JoinType::JOIN);
        self::assertEquals('LEFT JOIN', JoinType::LEFT_JOIN);
        self::assertEquals('LEFT OUTER JOIN', JoinType::LEFT_OUTER_JOIN);
        self::assertEquals('LEFT INNER JOIN', JoinType::LEFT_INNER_JOIN);
        self::assertEquals('RIGHT JOIN', JoinType::RIGHT_JOIN);
        self::assertEquals('RIGHT OUTER JOIN', JoinType::RIGHT_OUTER_JOIN);
        self::assertEquals('RIGHT INNER JOIN', JoinType::RIGHT_INNER_JOIN);
        self::assertEquals('OUTER JOIN', JoinType::OUTER_JOIN);
        self::assertEquals('INNER JOIN', JoinType::INNER_JOIN);
        self::assertEquals('CROSS JOIN', JoinType::CROSS_JOIN);
        self::assertEquals('FULL OUTER JOIN', JoinType::FULL_OUTER_JOIN);
    }
}
