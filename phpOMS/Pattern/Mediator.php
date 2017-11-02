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

namespace phpOMS\Pattern;

/**
 * Mediator.
 *
 * @category   Pattern
 * @package    Framework
 * @license    OMS License 1.0
 * @link       http://orange-management.com
 * @since      1.0.0
 */
interface Mediator extends \Countable
{

    /**
     * Attach a listener.
     *
     * Listeners will get called if a certain event gets triggered
     *
     * @param string   $group    Group
     * @param \Closure $callback Function to call if the event gets triggered
     * @param bool     $remove   Remove event after execution
     *
     * @return bool
     *
     * @since  1.0.0
     */
    public function attach(string $group, \Closure $callback, bool $remove = false) : bool;

    /**
     * Removing a event.
     *
     * @param string $group Group
     *
     * @return bool
     *
     * @since  1.0.0
     */
    public function detach(string $group) : bool;

    /**
     * Add group.
     *
     * Add new element to group
     *
     * @param string $group Group
     * @param string $id    Event ID
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function addGroup(string $group, string $id) /* : void */;

    /**
     * Trigger event.
     *
     * An object fires an event
     *
     * @param string $group Group
     * @param string $id    Event ID
     * @param bool $reset Reset if success
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function trigger(string $group, string $id, bool $reset = false) /* : void */;
}
