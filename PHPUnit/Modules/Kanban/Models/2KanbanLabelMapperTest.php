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

use Modules\Kanban\Models\KanbanLabel;
use Modules\Kanban\Models\KanbanLabelMapper;
use phpOMS\DataStorage\Database\DataMapperAbstract;
use phpOMS\DataStorage\Database\DatabasePool;
use phpOMS\Utils\RnG\Text;

require_once __DIR__ . '/../../../../../phpOMS/Autoloader.php';
require_once __DIR__ . '/../../../../../config.php';

class KanbanLabelMapperTest extends \PHPUnit\Framework\TestCase
{

    public function testCRUD()
    {
        $label = new KanbanLabel();

        $label->setName('Some Label');
        $label->setBoard(1);
        $label->setColor(16711680);

        $id = KanbanLabelMapper::create($label);
        self::assertGreaterThan(0, $label->getId());
        self::assertEquals($id, $label->getId());

        $labelR = KanbanLabelMapper::get($label->getId());
        self::assertEquals($label->getName(), $labelR->getName());
        self::assertEquals($label->getBoard(), $labelR->getBoard());
        self::assertEquals($label->getColor(), $labelR->getColor());
    }

    /**
     * @group volume
     */
    public function testVolume()
    {
        for ($i = 1; $i < 10; $i++) {
            $text = new Text();
            $label = new KanbanLabel();

            $label->setName($text->generateText(mt_rand(1, 3)));
            $label->setBoard(1);
            $label->setColor(mt_rand(0, 16777215));

            $id = KanbanLabelMapper::create($label);
        }
    }
}
