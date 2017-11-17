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

namespace Tests\PHPUnit\phpOMS\Utils\Git;

require_once __DIR__ . '/../../../../../phpOMS/Autoloader.php';

use phpOMS\Utils\Git\Author;

class AuthorTest extends \PHPUnit\Framework\TestCase
{
    public function testDefault()
    {
        $author = new Author();
        self::assertEquals('', $author->getName());
        self::assertEquals('', $author->getEmail());
        self::assertEquals(0, $author->getCommitCount());
        self::assertEquals(0, $author->getAdditionCount());
        self::assertEquals(0, $author->getRemovalCount());
    }

    public function testGetSet()
    {
        $author = new Author('test', 'email');
        self::assertEquals('test', $author->getName());
        self::assertEquals('email', $author->getEmail());

        $author->setCommitCount(1);
        self::assertEquals(1, $author->getCommitCount());

        $author->setAdditionCount(2);
        self::assertEquals(2, $author->getAdditionCount());

        $author->setRemovalCount(3);
        self::assertEquals(3, $author->getRemovalCount());
    }
}
