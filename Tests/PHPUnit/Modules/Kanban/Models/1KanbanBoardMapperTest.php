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
use Modules\Kanban\Models\KanbanBoardMapper;
use phpOMS\DataStorage\Database\DataMapperAbstract;
use phpOMS\DataStorage\Database\DatabasePool;
use phpOMS\Utils\RnG\Text;

require_once __DIR__ . '/../../../../../phpOMS/Autoloader.php';
require_once __DIR__ . '/../../../../../config.php';

class KanbanBoardMapperTest extends \PHPUnit\Framework\TestCase
{

    public function testCRUD()
    {
        $board = new KanbanBoard();

        $board->setName('Test Board 0');
        $board->setDescription('This is some description');
        $board->setCreatedBy(1);

        $id = KanbanBoardMapper::create($board);
        self::assertGreaterThan(0, $board->getId());
        self::assertEquals($id, $board->getId());

        $boardR = KanbanBoardMapper::get($board->getId());
        self::assertEquals($board->getName(), $boardR->getName());
        self::assertEquals($board->getStatus(), $boardR->getStatus());
        self::assertEquals($board->getDescription(), $boardR->getDescription());
        self::assertEquals($board->getCreatedBy(), $boardR->getCreatedBy()->getId());
        self::assertEquals($board->getCreatedAt(), $boardR->getCreatedAt());
        self::assertEquals($board->getColumns(), $boardR->getColumns());
    }

    /**
     * @group volume
     */
    public function testVolume()
    {
        for ($i = 1; $i < 30; $i++) {
            $text = new Text();
            $board = new KanbanBoard();

            $board->setName($text->generateText(mt_rand(3, 7)));
            $board->setDescription($text->generateText(mt_rand(20, 70)));
            $board->setCreatedBy(1);

            $id = KanbanBoardMapper::create($board);
        }
    }
}
