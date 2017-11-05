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

use Modules\Comments\Models\Comment;
use Modules\Comments\Models\CommentMapper;

require_once __DIR__ . '/../../../../../phpOMS/Autoloader.php';
require_once __DIR__ . '/../../../../../config.php';

class CommentMapperTest extends \PHPUnit\Framework\TestCase
{

    public function testCRUD()
    {
        $comment = new Comment();
        $comment->setCreatedBy(1);
        $comment->setTitle('Test Title');
        $comment->setContent('Test Content');
        $comment->setRef(1);
        $comment->setList(1);

        $id = CommentMapper::create($comment);
        self::assertGreaterThan(0, $comment->getId());
        self::assertEquals($id, $comment->getId());

        $commentR = CommentMapper::get($comment->getId());
        self::assertEquals($id, $commentR->getId());
        self::assertEquals($comment->getCreatedBy(), $commentR->getCreatedBy());
        self::assertEquals($comment->getTitle(), $commentR->getTitle());
        self::assertEquals($comment->getContent(), $commentR->getContent());
        self::assertEquals($comment->getRef(), $commentR->getRef());
        self::assertEquals($comment->getList(), $commentR->getList());
    }
}