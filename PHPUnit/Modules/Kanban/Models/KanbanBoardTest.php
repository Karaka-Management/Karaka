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

namespace Tests\PHPUnit\Modules\Kanban\Models;

use Modules\Kanban\Models\KanbanBoard;
use Modules\Kanban\Models\BoardStatus;

require_once __DIR__ . '/../../../../../phpOMS/Autoloader.php';
require_once __DIR__ . '/../../../../../config.php';

class KanbanBoardTest extends \PHPUnit\Framework\TestCase
{
    public function testDefult()
    {
        $board = new KanbanBoard();

        self::assertEquals(0, $board->getId());
        self::assertEquals(BoardStatus::ACTIVE, $board->getStatus());
        self::assertEquals('', $board->getName());
        self::assertEquals('', $board->getDescription());
        self::assertEquals(0, $board->getCreatedBy());
        self::assertInstanceOf('\DateTime', $board->getCreatedAt());
        self::assertEquals([], $board->getColumns());
    }

    public function testSetGet()
    {
        $board = new KanbanBoard();

        $board->setName('Name');
        $board->setDescription('Description');
        $board->setStatus(BoardStatus::ARCHIVED);
        $board->setCreatedBy(1);
        $board->addColumn(2);

        self::assertEquals(BoardStatus::ARCHIVED, $board->getStatus());
        self::assertEquals('Name', $board->getName());
        self::assertEquals('Description', $board->getDescription());
        self::assertEquals(1, $board->getCreatedBy());
        self::assertEquals([2], $board->getColumns());
    }
}
