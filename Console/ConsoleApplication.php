<?php
/**
 * Karaka
 *
 * PHP Version 8.1
 *
 * @package   Web
 * @copyright Dennis Eichhorn
 * @license   OMS License 1.0
 * @version   1.0.0
 * @link      https://karaka.app
 */
declare(strict_types=1);

namespace Console;

use phpOMS\Application\ApplicationAbstract;

/**
 * Application class.
 *
 * @package Console
 * @license OMS License 1.0
 * @link    https://karaka.app
 * @since   1.0.0
 *
 * @codeCoverageIgnore
 */
class ConsoleApplication extends ApplicationAbstract
{
    /**
     * Constructor.
     *
     * @param array{log:array{file:array{path:string}}, app:array{path:string, default:array{id:string, app:string, org:int, lang:string}, domains:array}, page:array{root:string, https:bool}, language:string[]} $config Core config
     *
     * @since 1.0.0
     */
    public function __construct(array $config)
    {
        $response = null;
        $sub      = null;
    }
}
