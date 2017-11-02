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

namespace Tests\PHPUnit\phpOMS\System\File;

require_once __DIR__ . '/../../../../../phpOMS/Autoloader.php';

use phpOMS\System\File\ContentPutMode;

class ContentPutModeTest extends \PHPUnit\Framework\TestCase
{
	public function testEnums()
    {
        self::assertEquals(4, count(ContentPutMode::getConstants()));
        self::assertEquals(ContentPutMode::getConstants(), array_unique(ContentPutMode::getConstants()));

        self::assertEquals(1, ContentPutMode::APPEND);
        self::assertEquals(2, ContentPutMode::PREPEND);
        self::assertEquals(4, ContentPutMode::REPLACE);
        self::assertEquals(8, ContentPutMode::CREATE);
    }
}

