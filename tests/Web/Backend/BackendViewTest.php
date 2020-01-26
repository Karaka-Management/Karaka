<?php declare(strict_types=1);
/**
 * Orange Management
 *
 * PHP Version 7.4
 *
 * @package   tests
 * @copyright Dennis Eichhorn
 * @license   OMS License 1.0
 * @version   1.0.0
 * @link      https://orange-management.org
 */

namespace tests\Web\Backend;

require_once __DIR__ . '/../../../phpOMS/Autoloader.php';

use Web\Backend\BackendView;

/**
 * @internal
 */
class BackendViewTest extends \PHPUnit\Framework\TestCase
{
    public function testDefault() : void
    {
        $view = new BackendView();

        self::assertStringContainsString('Web/Backend/img/user_default_', $view->getProfileImage());
    }
}
