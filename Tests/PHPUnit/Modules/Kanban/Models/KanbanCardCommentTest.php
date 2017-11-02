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

use Modules\Kanban\Models\KanbanCardComment;

require_once __DIR__ . '/../../../../../phpOMS/Autoloader.php';
require_once __DIR__ . '/../../../../../config.php';

class KanbanCardCommentTest extends \PHPUnit\Framework\TestCase
{
    public function testDefult()
    {
        $comment = new KanbanCardComment();

        self::assertEquals(0, $comment->getId());
        self::assertEquals(0, $comment->getCard());
        self::assertEquals('', $comment->getDescription());
        self::assertEquals(0, $comment->getCreatedBy());
        self::assertInstanceOf('\DateTime', $comment->getCreatedAt());
        self::assertEquals([], $comment->getMedia());
    }

    public function testSetGet()
    {
        $comment = new KanbanCardComment();

        $comment->setCard(2);
        $comment->setDescription('Description');
        $comment->setCreatedBy(1);
        $comment->addMedia(3);

        self::assertEquals(2, $comment->getCard());
        self::assertEquals('Description', $comment->getDescription());
        self::assertEquals(1, $comment->getCreatedBy());
        self::assertEquals([3], $comment->getMedia());
    }
}
