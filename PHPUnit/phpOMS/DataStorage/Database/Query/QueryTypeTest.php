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

use phpOMS\DataStorage\Database\Query\QueryType;

class QueryTypeTest extends \PHPUnit\Framework\TestCase
{
    public function testEnums()
    {
        self::assertEquals(6, count(QueryType::getConstants()));
        self::assertEquals(QueryType::getConstants(), array_unique(QueryType::getConstants()));
        
        self::assertEquals(0, QueryType::SELECT);
        self::assertEquals(1, QueryType::INSERT);
        self::assertEquals(2, QueryType::UPDATE);
        self::assertEquals(3, QueryType::DELETE);
        self::assertEquals(4, QueryType::RANDOM);
        self::assertEquals(5, QueryType::RAW);
    }
}
