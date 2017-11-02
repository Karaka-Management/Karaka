<?php
/**
 * Orange Management
 *
 * PHP Version 7.1
 *
 * @category   TBD
 * @package    TBD
 * @copyright  Dennis Eichhorn
 * @license    OMS License 1.0
 * @version    1.0.0
 * @link       http://orange-management.com
 */
declare(strict_types = 1);

namespace phpOMS\Module;

/**
 * Console module interface.
 *
 * @category   Module
 * @package    Framework
 * @license    OMS License 1.0
 * @link       http://orange-management.com
 * @since      1.0.0
 */
interface ConsoleInterface
{

    /**
     * Answer console request.
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function callConsole();
}
