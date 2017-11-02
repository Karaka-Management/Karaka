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

namespace Tests\PHPUnit\Modules\Knowledgebase\Models;

use Modules\Knowledgebase\Models\WikiBadge;

require_once __DIR__ . '/../../../../../phpOMS/Autoloader.php';
require_once __DIR__ . '/../../../../../config.php';

class WikiBadgeTest extends \PHPUnit\Framework\TestCase
{
    public function testDefult()
    {
        $badge = new WikiBadge();

        self::assertEquals(0, $badge->getId());
        self::assertEquals('', $badge->getName());
    }

    public function testSetGet()
    {
        $badge = new WikiBadge();

        $badge->setName('Badge Name');

        self::assertEquals('Badge Name', $badge->getName());
    }
}
