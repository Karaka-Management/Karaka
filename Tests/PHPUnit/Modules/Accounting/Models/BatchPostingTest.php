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

namespace Tests\PHPUnit\Modules\Accounting\Models;

use Modules\Accounting\Models\BatchPosting;

require_once __DIR__ . '/../../../../../phpOMS/Autoloader.php';
require_once __DIR__ . '/../../../../../config.php';

class BatchPostingTest extends \PHPUnit\Framework\TestCase
{
    public function testDefault()
    {
        $batch = new BatchPosting();
        self::assertEquals(0, $batch->count());
        self::assertEquals(0, $batch->getId());
        self::assertEquals(0, $batch->getCreator());
        self::assertInstanceOf('\DateTime', $batch->getCreatedAt());
    }

    public function testSetGet()
    {
        $batch = new BatchPosting();

        $batch->setCreator(2);
        self::assertEquals(2, $batch->getCreator());

        $batch->setDescription('Test');
        self::assertEquals('Test', $batch->getDescription());
    }
}