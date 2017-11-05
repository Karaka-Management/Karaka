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

namespace Tests\PHPUnit\Modules\Comments\Models;

use Modules\Comments\Models\CommentList;
use Modules\Comments\Models\Comment;

require_once __DIR__ . '/../../../../../phpOMS/Autoloader.php';
require_once __DIR__ . '/../../../../../config.php';

class CommentListTest extends \PHPUnit\Framework\TestCase
{
    public function testDefult()
    {
        $list = new CommentList();
        self::assertEquals(0, $list->getId());
        self::assertEquals([], $list->getComments());
    }

    public function testGetSet()
    {
        $list = new CommentList();
        $comment = new Comment();
        $comment->setTitle('Test Comment');

        $list->addComment($comment);
        self::assertEquals('Test Comment', $list->getComments()[0]->getTitle());
    }
}