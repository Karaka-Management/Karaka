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
 * @link       http://website.orange-management.de
 */
declare(strict_types = 1);

namespace phpOMS\Socket;

/**
 * CommandManager class.
 *
 * @category   Framework
 * @package    phpOMS\Socket
 * @since      1.0.0
 *
 * @todo       : Hey, this looks like a copy of an event manager!
 */
class CommandManager implements \Countable
{

    /**
     * Commands.
     *
     * @var mixed[]
     * @since 1.0.0
     */
    private $commands = [];

    /**
     * Commands.
     *
     * @var int
     * @since 1.0.0
     */
    private $count = 0;

    /**
     * Constructor.
     *
     * @since  1.0.0
     */
    public function __construct()
    {
    }

    /**
     * Attach new command.
     *
     * @param string $cmd      Command ID
     * @param mixed  $callback Function callback
     * @param mixed  $source   Provider
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function attach(string $cmd, $callback, $source)
    {
        $this->commands[$cmd] = [$callback, $source];
        $this->count++;
    }

    /**
     * Detach existing command.
     *
     * @param string $cmd    Command ID
     * @param mixed  $source Provider
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function detach(string $cmd, $source)
    {
        if (array_key_exists($cmd, $this->commands)) {
            unset($this->commands[$cmd]);
            $this->count--;
        }
    }

    /**
     * Trigger command.
     *
     * @param string $cmd  Command ID
     * @param mixed  $conn Client ID
     * @param mixed  $para Parameters to pass
     *
     * @return mixed|bool
     *
     * @since  1.0.0
     */
    public function trigger(string $cmd, $conn, $para)
    {
        if (array_key_exists($cmd, $this->commands)) {
            return $this->commands[$cmd][0]($conn, $para);
        }

        return false;
    }

    /**
     * Count commands.
     *
     * @return int
     *
     * @since  1.0.0
     */
    public function count() : int
    {
        return $this->count;
    }
}
