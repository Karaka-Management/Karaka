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

namespace phpOMS\Console;

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
     * @param string $cmd       Command ID
     * @param mixed  $callback  Function callback
     * @param mixed  $source    Provider
     * @param bool   $overwrite Overwrite existing
     *
     * @return bool
     *
     * @since  1.0.0
     */
    public function attach(string $cmd, $callback, $source, bool $overwrite = true) : bool
    {
        if ($overwrite || !isset($this->commands[$cmd])) {
            $this->commands[$cmd] = [$callback, $source];
            $this->count++;

            return true;
        }

        return false;
    }

    /**
     * Detach existing command.
     *
     * @param string $cmd    Command ID
     * @param mixed  $source Provider
     *
     * @return bool
     *
     * @since  1.0.0
     */
    public function detach(string $cmd, $source) : bool
    {
        if (array_key_exists($cmd, $this->commands)) {
            unset($this->commands[$cmd]);
            $this->count--;

            return true;
        }

        return false;
    }

    /**
     * Trigger command.
     *
     * @param string $cmd  Command ID
     * @param mixed  $para Parameters to pass
     *
     * @return mixed|bool
     *
     * @since  1.0.0
     */
    public function trigger(string $cmd, $para)
    {
        if (array_key_exists($cmd, $this->commands)) {
            return $this->commands[$cmd][0]($para);
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
