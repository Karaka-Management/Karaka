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

use Modules\Knowledgebase\Models\WikiBadge;
use Modules\Knowledgebase\Models\WikiBadgeMapper;
use phpOMS\DataStorage\Database\DataMapperAbstract;
use phpOMS\DataStorage\Database\DatabasePool;
use phpOMS\Utils\RnG\Text;

require_once __DIR__ . '/../../../../../phpOMS/Autoloader.php';
require_once __DIR__ . '/../../../../../config.php';

class WikiBadgeMapperTest extends \PHPUnit\Framework\TestCase
{

    public function testCRUD()
    {
        $badge = new WikiBadge();

        $badge->setName('Test Badge');

        $id = WikiBadgeMapper::create($badge);
        self::assertGreaterThan(0, $badge->getId());
        self::assertEquals($id, $badge->getId());

        $badgeR = WikiBadgeMapper::get($badge->getId());
        self::assertEquals($badge->getName(), $badgeR->getName());
    }

    /**
     * @group volume
     */
    public function testVolume()
    {
        for ($i = 1; $i < 30; $i++) {
            $text = new Text();
            $badge = new WikiBadge();

            $badge->setName($text->generateText(mt_rand(1, 3)));

            $id = WikiBadgeMapper::create($badge);
        }
    }
}
