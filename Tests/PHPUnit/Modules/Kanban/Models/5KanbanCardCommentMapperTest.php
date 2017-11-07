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

use Modules\Kanban\Models\KanbanCardComment;
use Modules\Kanban\Models\KanbanCardCommentMapper;
use phpOMS\DataStorage\Database\DataMapperAbstract;
use phpOMS\DataStorage\Database\DatabasePool;
use phpOMS\Utils\RnG\Text;

require_once __DIR__ . '/../../../../../phpOMS/Autoloader.php';
require_once __DIR__ . '/../../../../../config.php';

class KanbanCardCommentMapperTest extends \PHPUnit\Framework\TestCase
{

    public function testCRUD()
    {
        $comment = new KanbanCardComment();

        $comment->setDescription('This is some card description');
        $comment->setCard(1);
        $comment->setCreatedBy(1);

        $id = KanbanCardCommentMapper::create($comment);
        self::assertGreaterThan(0, $comment->getId());
        self::assertEquals($id, $comment->getId());

        $commentR = KanbanCardCommentMapper::get($comment->getId());
        self::assertEquals($comment->getDescription(), $commentR->getDescription());
        self::assertEquals($comment->getCard(), $commentR->getCard());
        self::assertEquals($comment->getCreatedBy(), $commentR->getCreatedBy());
        self::assertEquals($comment->getCreatedAt()->format('Y-m-d'), $commentR->getCreatedAt()->format('Y-m-d'));
    }

    /**
     * @group volume
     */
    public function testVolume()
    {
        for ($i = 1; $i < 10; $i++) {
            $text = new Text();
            $comment = new KanbanCardComment();

            $comment->setDescription($text->generateText(mt_rand(20, 100)));
            $comment->setCard(1);
            $comment->setCreatedBy(1);

            $id = KanbanCardCommentMapper::create($comment);
        }
    }
}
