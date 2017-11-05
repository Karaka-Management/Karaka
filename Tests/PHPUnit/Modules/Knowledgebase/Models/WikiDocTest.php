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

namespace Tests\PHPUnit\Modules\Knowledgebase\Models;

use Modules\Knowledgebase\Models\WikiDoc;
use Modules\Knowledgebase\Models\WikiStatus;
use Modules\Knowledgebase\Models\WikiBadge;

require_once __DIR__ . '/../../../../../phpOMS/Autoloader.php';
require_once __DIR__ . '/../../../../../config.php';

class WikiDocTest extends \PHPUnit\Framework\TestCase
{
    public function testDefult()
    {
        $doc = new WikiDoc();

        self::assertEquals(0, $doc->getId());
        self::assertEquals('', $doc->getName());
        self::assertEquals('', $doc->getDoc());
        self::assertEquals(WikiStatus::ACTIVE, $doc->getStatus());
        self::assertEquals(0, $doc->getCategory());
        self::assertEquals('', $doc->getLanguage());
        self::assertEquals(0, $doc->getCreatedBy());
        self::assertInstanceOf('\DateTime', $doc->getCreatedAt());
        self::assertEquals([], $doc->getBadges());
    }

    public function testSetGet()
    {
        $doc = new WikiDoc();

        $doc->setName('Doc Name');
        $doc->setDoc('Doc content');
        $doc->setStatus(WikiStatus::DRAFT);
        $doc->setCategory(1);
        $doc->setCreatedBy(2);
        $doc->setLanguage('en');
        $doc->addBadge(new WikiBadge());

        self::assertEquals('Doc Name', $doc->getName());
        self::assertEquals('Doc content', $doc->getDoc());
        self::assertEquals(WikiStatus::DRAFT, $doc->getStatus());
        self::assertEquals('en', $doc->getLanguage());
        self::assertEquals(1, $doc->getCategory());
        self::assertEquals(2, $doc->getCreatedBy());
        self::assertEquals([new WikiBadge()], $doc->getBadges());
    }
}
