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

namespace Tests\PHPUnit\Modules\Comments\Models;

use Modules\Comments\Models\Comment;

require_once __DIR__ . '/../../../../../phpOMS/Autoloader.php';
require_once __DIR__ . '/../../../../../config.php';

class CommentTest extends \PHPUnit\Framework\TestCase
{
    public function testDefult()
    {
        $comment = new Comment();
        self::assertEquals(0, $comment->getId());

        $date = new \DateTime('now');
        self::assertEquals($date->format('Y-m-d'), $comment->getCreatedAt()->format('Y-m-d'));
        self::assertEquals(0, $comment->getCreatedBy());
        self::assertEquals(0, $comment->getList());
        self::assertEquals(0, $comment->getRef());
        self::assertEquals('', $comment->getTitle());
        self::assertEquals('', $comment->getContent());
    }

    public function testGetSet()
    {
        $comment = new Comment();

        $comment->setCreatedBy(1);
        self::assertEquals(1, $comment->getCreatedBy());

        $comment->setList(2);
        self::assertEquals(2, $comment->getList());

        $comment->setRef(3);
        self::assertEquals(3, $comment->getRef());

        $comment->setTitle('Test Title');
        self::assertEquals('Test Title', $comment->getTitle());

        $comment->setContent('Test Content');
        self::assertEquals('Test Content', $comment->getContent());
    }
}