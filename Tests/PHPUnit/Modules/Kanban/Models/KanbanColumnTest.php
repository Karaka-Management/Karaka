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

namespace Tests\PHPUnit\Modules\Kanban\Models;

use Modules\Kanban\Models\KanbanColumn;
use Modules\Kanban\Models\KanbanCard;

require_once __DIR__ . '/../../../../../phpOMS/Autoloader.php';
require_once __DIR__ . '/../../../../../config.php';

class KanbanColumnTest extends \PHPUnit\Framework\TestCase
{
    public function testDefult()
    {
        $column = new KanbanColumn();

        self::assertEquals(0, $column->getId());
        self::assertEquals('', $column->getName());
        self::assertEquals(0, $column->getOrder());
        self::assertEquals(0, $column->getBoard());
        self::assertEquals([], $column->getCards());
    }

    public function testSetGet()
    {
        $column = new KanbanColumn();

        $column->setName('Name');
        $column->setOrder(2);
        $column->setBoard(3);
        $column->addCard(new KanbanCard());

        self::assertEquals('Name', $column->getName());
        self::assertEquals(2, $column->getOrder());
        self::assertEquals(3, $column->getBoard());
        self::assertEquals([new KanbanCard()], $column->getCards());
    }
}
