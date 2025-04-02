<?php
/**
 * Jingga
 *
 * PHP Version 8.2
 *
 * @package   tests
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.2
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

namespace tests\Cli;

require_once __DIR__ . '/../../phpOMS/Autoloader.php';

use Cli\CliApplication;

/**
 * @internal
 */
class CliApplicationTest extends \PHPUnit\Framework\TestCase
{
    #[\PHPUnit\Framework\Attributes\Group('framework')]
    public function testCliApplication() : void
    {
        $console = new CliApplication(
            $GLOBALS['CONFIG']
        );

        self::assertInstanceOf('\Cli\CliApplication', $console);

        \restore_error_handler();
        \restore_exception_handler();
    }
}
