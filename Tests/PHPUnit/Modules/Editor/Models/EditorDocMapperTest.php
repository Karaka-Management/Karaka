<?php
/**
 * Orange Management
 *
 * PHP Version 7.1
 *
 * @category   TBD
 * @package    TBD
 * @author     OMS Development Team <dev@oms.com>
 * @copyright  2013 Dennis Eichhorn
 * @license    OMS License 1.0
 * @version    1.0.0
 * @link       http://website.orange-management.de
 */

namespace Tests\PHPUnit\Modules\Editor\Models;

use Modules\Editor\Models\EditorDoc;
use Modules\Editor\Models\EditorDocMapper;
use phpOMS\DataStorage\Database\DataMapperAbstract;
use phpOMS\DataStorage\Database\DatabasePool;
use phpOMS\Localization\ISO639x1Enum;
use phpOMS\Utils\RnG\Text;

require_once __DIR__ . '/../../../../../phpOMS/Autoloader.php';
require_once __DIR__ . '/../../../../../config.php';

class EditorDocMapperTest extends \PHPUnit\Framework\TestCase
{

    public function testCRUD()
    {
        $doc = new EditorDoc();

        $doc->setCreatedBy(1);
        $doc->setTitle('Title');
        $doc->setContent('Content');
        $doc->setPath('/some/test/path');

        $id = EditorDocMapper::create($doc);
        self::assertGreaterThan(0, $doc->getId());
        self::assertEquals($id, $doc->getId());

        $docR = EditorDocMapper::get($doc->getId());
        self::assertEquals($doc->getCreatedAt()->format('Y-m-d'), $docR->getCreatedAt()->format('Y-m-d'));
        self::assertEquals($doc->getCreatedBy(), $docR->getCreatedBy()->getId());
        self::assertEquals($doc->getContent(), $docR->getContent());
        self::assertEquals($doc->getTitle(), $docR->getTitle());
        self::assertEquals($doc->getPath(), $docR->getPath());
    }

    /**
     * @group volume
     */
    public function testVolume()
    {
        for ($i = 0; $i < 100; $i++) {
            $text = new Text();
            $doc = new EditorDoc();

            // Test other

            $doc->setCreatedBy(mt_rand(1, 2));
            $doc->setTitle($text->generateText(mt_rand(3, 7)));
            $doc->setContent($text->generateText(mt_rand(20, 500)));
            $doc->setPath('/some/test/path');

            $id = EditorDocMapper::create($doc);
        }
    }
}
