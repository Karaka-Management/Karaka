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

namespace Tests\PHPUnit\Model\Message;

use Model\Message\DomAction;

require_once __DIR__ . '/../../../../phpOMS/Autoloader.php';
require_once __DIR__ . '/../../../../config.php';

class DomActionTest extends \PHPUnit\Framework\TestCase
{
    public function testEnums()
    {
        self::assertEquals(9, count(DomAction::getConstants()));
        self::assertEquals(DomAction::getConstants(), array_unique(DomAction::getConstants()));
        
        self::assertEquals(0, DomAction::CREATE_BEFORE);
        self::assertEquals(1, DomAction::CREATE_AFTER);
        self::assertEquals(2, DomAction::DELETE);
        self::assertEquals(3, DomAction::REPLACE);
        self::assertEquals(4, DomAction::MODIFY);
        self::assertEquals(5, DomAction::SHOW);
        self::assertEquals(6, DomAction::HIDE);
        self::assertEquals(7, DomAction::ACTIVATE);
        self::assertEquals(8, DomAction::DEACTIVATE);
    }
}
