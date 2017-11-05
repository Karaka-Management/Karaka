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
use Modules\Knowledgebase\Models\WikiDocMapper;
use Modules\Knowledgebase\Models\WikiStatus;
use phpOMS\DataStorage\Database\DataMapperAbstract;
use phpOMS\DataStorage\Database\DatabasePool;
use phpOMS\Utils\RnG\Text;

require_once __DIR__ . '/../../../../../phpOMS/Autoloader.php';
require_once __DIR__ . '/../../../../../config.php';

class WikiDocMapperTest extends \PHPUnit\Framework\TestCase
{

    public function testCRUD()
    {
        $doc = new WikiDoc();

        $doc->setName('Doc Name');
        $doc->setDoc('Doc content');
        $doc->setStatus(WikiStatus::DRAFT);
        $doc->setCategory(1);
        $doc->setCreatedBy(1);
        $doc->setLanguage('en');
        $doc->addBadge(1);

        $id = WikiDocMapper::create($doc);
        self::assertGreaterThan(0, $doc->getId());
        self::assertEquals($id, $doc->getId());

        $docR = WikiDocMapper::get($doc->getId());
        self::assertEquals($doc->getName(), $docR->getName());
        self::assertEquals($doc->getDoc(), $docR->getDoc());
        self::assertEquals($doc->getStatus(), $docR->getStatus());
        self::assertEquals($doc->getLanguage(), $docR->getLanguage());
        self::assertEquals($doc->getCategory(), $docR->getCategory()->getId());
        self::assertEquals($doc->getCreatedBy(), $docR->getCreatedBy());
        self::assertEquals(count($doc->getBadges()), count($docR->getBadges()));
    }

    /**
     * @group volume
     */
    public function testVolume()
    {
        for ($i = 1; $i < 30; $i++) {
            $text = new Text();
            $doc = new WikiDoc();

            $doc->setName($text->generateText(mt_rand(1, 3)));
            $doc->setDoc($text->generateText(mt_rand(100, 500)));
            $doc->setStatus(WikiStatus::ACTIVE);
            $doc->setCategory(mt_rand(1, 9));
            $doc->setCreatedBy(1);
            $doc->setLanguage('en');
            $doc->addBadge(mt_rand(1, 9));

            $id = WikiDocMapper::create($doc);
        }
    }
}
