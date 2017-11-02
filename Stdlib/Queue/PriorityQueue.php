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

namespace phpOMS\Stdlib\Queue;

/**
 * Priority queue class.
 *
 * @category   Framework
 * @package    phpOMS\Stdlib
 * @license    OMS License 1.0
 * @link       http://orange-management.com
 * @since      1.0.0
 */
class PriorityQueue implements \Countable, \Serializable
{

    /**
     * Queue elements.
     *
     * @var int
     * @since 1.0.0
     */
    private $count = 0;

    /**
     * Queue.
     *
     * @var array
     * @since 1.0.0
     */
    private $queue = [];

    /**
     * Constructor.
     *
     * @since  1.0.0
     */
    public function __construct()
    {
    }

    /**
     * Insert element into queue.
     *
     * @param mixed $data     Queue element
     * @param float $priority Priority of this element
     *
     * @return int
     *
     * @since  1.0.0
     */
    public function insert($data, float $priority = 1.0) : int
    {
        do {
            $key = rand();
        } while (array_key_exists($key, $this->queue));

        if ($this->count === 0) {
            $this->queue[$key] = ['key' => $key, 'job' => $job, 'priority' => $priority];
        } else {
            $pos = 0;
            foreach ($this->queue as $ele) {
                if ($ele['priority'] < $priority) {
                    break;
                }

                $pos++;
            }

            array_splice($original, $pos, 0, [$key => ['key' => $key, 'job' => $job, 'priority' => $priority]]);
        }

        return $key;
    }

    /**
     * Increase all queue priorities.
     *
     * @param float $increase Value to increase every element
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function increaseAll(float $increase = 0.1) /* : void */
    {
        foreach ($this->queue as $key => &$ele) {
            $ele['priority'] += $increase;
        }
    }

    /**
     * Pop element.
     *
     * @return mixed
     *
     * @since  1.0.0
     */
    public function pop()
    {
        return array_pop($this->queue);
    }

    /**
     * Delete element.
     *
     * @param int $id Element to delete
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function delete(int $id = null) /* : void */
    {
        if ($id === null) {
            $this->remove();
        } else {
            unset($this->queue[$id]);
        }
    }

    /**
     * Delete last element.
     *
     * @since  1.0.0
     */
    public function remove()
    {
        return array_pop($this->queue);
    }

    /**
     * Set element priority.
     *
     * @param int   $id       Element ID
     * @param float $priority Element priority
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function setPriority(int $id, float $priority) /* : void */
    {
        $this->queue[$id]['priority'] = $priority;
    }

    /**
     * Set element priority.
     *
     * @param int $id Element ID
     *
     * @return float
     *
     * @since  1.0.0
     */
    public function getPriority(int $id) : float
    {
        return $this->queue[$id]['priority'];
    }

    /**
     * {@inheritdoc}
     */
    public function count() : int
    {
        return $this->count;
    }

    /**
     * {@inheritdoc}
     */
    public function serialize() : string
    {
        return json_encode($this->queue);
    }

    /**
     * Unserialize queue.
     *
     * @param string $data Data to unserialze
     *
     * @return array
     *
     * @since  1.0.0
     */
    public function unserialize($data) : array
    {
        $this->queue = json_decode($data);
        $this->count = count($this->queue);
    }
}
