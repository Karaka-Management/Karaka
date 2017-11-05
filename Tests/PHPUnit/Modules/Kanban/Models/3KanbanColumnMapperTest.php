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
use Modules\Kanban\Models\KanbanColumnMapper;
use phpOMS\DataStorage\Database\DataMapperAbstract;
use phpOMS\DataStorage\Database\DatabasePool;
use phpOMS\Utils\RnG\Text;

require_once __DIR__ . '/../../../../../phpOMS/Autoloader.php';
require_once __DIR__ . '/../../../../../config.php';

class KanbanColumnMapperTest extends \PHPUnit\Framework\TestCase
{

    public function testCRUD()
    {
        $column = new KanbanColumn();

        $column->setName('Some Column');
        $column->setBoard(1);
        $column->setOrder(1);

        $id = KanbanColumnMapper::create($column);
        self::assertGreaterThan(0, $column->getId());
        self::assertEquals($id, $column->getId());

        $columnR = KanbanColumnMapper::get($column->getId());
        self::assertEquals($column->getName(), $columnR->getName());
        self::assertEquals($column->getBoard(), $columnR->getBoard());
        self::assertEquals($column->getOrder(), $columnR->getOrder());
    }

    /**
     * @group volume
     */
    public function testVolume()
    {
        for ($i = 1; $i < 4; $i++) {
            $text = new Text();
            $column = new KanbanColumn();

            $column->setName($text->generateText(mt_rand(3, 7)));
            $column->setBoard(1);
            $column->setOrder($i + 1);

            $id = KanbanColumnMapper::create($column);
        }
    }
}
