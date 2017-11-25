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

use Modules\Accounting\Models\AccountType;

require_once __DIR__ . '/../../../../../phpOMS/Autoloader.php';
require_once __DIR__ . '/../../../../../config.php';

class AccountTypeTest extends \PHPUnit\Framework\TestCase
{
    public function testEnums()
    {
        self::assertEquals(4, count(AccountType::getConstants()));
        self::assertEquals(AccountType::getConstants(), array_unique(AccountType::getConstants()));
        
        self::assertEquals(0, AccountType::IMPERSONAL);
        self::assertEquals(1, AccountType::PERSONAL);
        self::assertEquals(2, AccountType::CREDITOR);
        self::assertEquals(4, AccountType::DEBITOR);
    }
}