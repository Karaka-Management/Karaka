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

namespace phpOMS\Event;

/**
 * EventManager class.
 *
 * @category   Framework
 * @package    phpOMS\Event
 * @license    OMS License 1.0
 * @link       http://orange-management.com
 * @since      1.0.0
 *
 * @todo       : make cachable + database storable -> can reload user defined listeners (persistent events)
 */
class EventManager
{
    /**
     * Events.
     *
     * @var array
     * @since 1.0.0
     */
    private $groups = [];

    /**
     * Callbacks.
     *
     * @var array
     * @since 1.0.0
     */
    private $callbacks = [];

    /**
     * Constructor.
     *
     * @since  1.0.0
     */
    public function __construct()
    {
    }

    /**
     * Attach new event
     *
     * @param string $group Name of the event (unique)
     * @param \Closure $callback Callback for the event
     * @param bool $remove Remove event after triggering it?
     * @param bool $reset Reset event after triggering it? Remove must be false!
     *
     * @return bool
     *
     * @since  1.0.0
     */
    public function attach(string $group, \Closure $callback, bool $remove = false, bool $reset = false) : bool
    {
        if (isset($this->callbacks[$group])) {
            return false;
        }

        $this->callbacks[$group] = ['remove' => $remove, 'reset' => $reset, 'func' => $callback];

        return true;
    }

    /**
     * Trigger event
     *
     * @param string $group Name of the event
     * @param string $id Sub-requirement for event
     * @param mixed $data Data to pass to the callback
     *
     * @return bool Returns true on sucessfully triggering the event, false if the event couldn't be triggered which also includes sub-requirements missing.
     *
     * @since  1.0.0
     */
    public function trigger(string $group, string $id = '', $data = null) : bool
    {
        if (!isset($this->callbacks[$group])) {
            return false;
        }

        if (isset($this->groups[$group])) {
            $this->groups[$group][$id] = true;
        }

        if (!$this->hasOutstanding($group)) {
            $this->callbacks[$group]['func']($data);

            if ($this->callbacks[$group]['remove']) {
                $this->detach($group);
            } elseif ($this->callbacks[$group]['reset']) {
                $this->reset($group);
            }

            return true;
        }

        return false;
    }

    /**
     * Reset group
     *
     * @param string $group Name of the event
     *
     * @return void
     *
     * @since  1.0.0
     */
    private function reset(string $group) /* : void */
    {
        foreach ($this->groups[$group] as $id => $ok) {
            $this->groups[$group][$id] = false;
        }
    }

    /**
     * Check if a group has missing sub-requirements
     *
     * @param string $group Name of the event
     *
     * @return bool
     *
     * @since  1.0.0
     */
    private function hasOutstanding(string $group) : bool
    {
        if (!isset($this->groups[$group])) {
            return false;
        }

        foreach ($this->groups[$group] as $id => $ok) {
            if (!$ok) {
                return true;
            }
        }

        return false;
    }

    /**
     * Detach an event
     *
     * @param string $group Name of the event
     *
     * @return bool
     *
     * @since  1.0.0
     */
    public function detach(string $group) : bool
    {
        $found = false;

        if (isset($this->callbacks[$group])) {
            unset($this->callbacks[$group]);
            $found = true;
        }

        if (isset($this->groups[$group])) {
            unset($this->groups[$group]);
            $found = true;
        }

        return $found;
    }

    /**
     * Add sub-requirement for event
     *
     * @param string $group Name of the event
     * @param string $id ID of the sub-requirement
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function addGroup(string $group, string $id) /* : void */
    {
        if (!isset($this->groups[$group])) {
            $this->groups[$group] = [];
        }

        $this->groups[$group][$id] = false;
    }

    /**
     * Count events.
     *
     * @return int
     *
     * @since  1.0.0
     */
    public function count() : int
    {
        return count($this->callbacks);
    }

}
