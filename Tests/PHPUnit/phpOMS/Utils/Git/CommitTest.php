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

use phpOMS\Utils\Git\Commit;
use phpOMS\Utils\Git\Author;
use phpOMS\Utils\Git\Branch;
use phpOMS\Utils\Git\Tag;
use phpOMS\Utils\Git\Repository;

class CommitTest extends \PHPUnit\Framework\TestCase
{
    public function testDefault()
    {
        $commit = new Commit();
        self::assertEquals('', $commit->getId());
        self::assertEquals('', $commit->getMessage());
        self::assertEquals([], $commit->getFiles());
        self::assertInstanceOf('\phpOMS\Utils\Git\Author', $commit->getAuthor());
        self::assertInstanceOf('\phpOMS\Utils\Git\Branch', $commit->getBranch());
        self::assertInstanceOf('\phpOMS\Utils\Git\Tag', $commit->getTag());
        self::assertInstanceOf('\phpOMS\Utils\Git\Repository', $commit->getRepository());
        self::assertInstanceOf('\DateTime', $commit->getDate());
    }
}
