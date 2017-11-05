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

namespace Tests\PHPUnit\phpOMS;

require_once __DIR__ . '/../../../phpOMS/Autoloader.php';

use phpOMS\UnhandledHandler;

class UnhandledHandlerTest extends \PHPUnit\Framework\TestCase
{
    public function testErrorHandling()
    {
        set_exception_handler(['\phpOMS\UnhandledHandler', 'exceptionHandler']);
        set_error_handler(['\phpOMS\UnhandledHandler', 'errorHandler']);
        register_shutdown_function(['\phpOMS\UnhandledHandler', 'shutdownHandler']);

        trigger_error('', E_USER_ERROR);
        
        UnhandledHandler::shutdownHandler();

        self::assertFalse(UnhandledHandler::errorHandler(0, '', '', 0));
    }

}
