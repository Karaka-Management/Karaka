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

namespace phpOMS\Stdlib\Collection;

use phpOMS\Utils\ArrayUtils;

/**
 * Collection.
 *
 * @category   Framework
 * @package    phpOMS\Stdlib
 * @license    OMS License 1.0
 * @link       http://orange-management.com
 * @since      1.0.0
 */
class Collection implements \Countable, \ArrayAccess, \Iterator, \JsonSerializable
{
    /**
     * Collection.
     *
     * @var array
     * @since 1.0.0
     */
    private $collection = [];

    /**
     * Create collection from array.
     *
     * @param array $data Collection data
     *
     * @since  1.0.0
     */
    public function __construct(array $data)
    {
        $this->collection = $data;
    }

    /**
     * Turn collection to array.
     *
     * @return array Collection array representation
     *
     * @since  1.0.0
     */
    public function toArray() : array
    {
        return $this->collection;
    }

    /**
     * Json serialize.
     *
     * @return string
     *
     * @since  1.0.0
     */
    public function jsonSerialize()
    {
        return $this->collection;
    }

    /**
     * Get average of collection data.
     *
     * @param mixed $filter Filter for average calculation
     *
     * @return mixed
     *
     * @since  1.0.0
     */
    public function avg($filter = null)
    {
        return $this->sum($filter) / $this->count();
    }

    /**
     * Get sum of collection data.
     *
     * @param mixed $filter Filter for sum calculation
     *
     * @return mixed
     *
     * @since  1.0.0
     */
    public function sum($filter = null)
    {
        $sum = 0;

        if (!isset($filter)) {
            foreach ($this->collection as $key => $value) {
                if (is_numeric($value)) {
                    $sum += $value;
                } elseif ($value instanceof Collection) {
                    $sum += $value->sum();
                }
            }
        } elseif (is_string($filter)) {
            foreach ($this->collection as $key => $value) {
                if (isset($value[$filter]) && is_numeric($value[$filter])) {
                    $sum += $value[$filter];
                }
            }
        } elseif ($filter instanceof \Closure) {
            $sum = $filter($this->collection);
        }

        return $sum;
    }

    /**
     * Get collection count.
     *
     * @return int
     *
     * @since  1.0.0
     */
    public function count()
    {
        return count($this->collection);
    }

    /**
     * Chunk collection.
     *
     * Creates new collection in the specified size.
     *
     * @param int $size Chunk size
     *
     * @return Collection[]
     *
     * @since  1.0.0
     */
    public function chunk(int $size) : array
    {
        $arrays = array_chunk($this->collection, $size);
        $collections = [];

        foreach ($arrays as $array) {
            $collections[] = new self($array);
        }

        return $collections;
    }

    /**
     * Collapse collection.
     *
     * @return Collection
     *
     * @since  1.0.0
     */
    public function collapse() : Collection
    {
        $return = [];

        return new self(array_walk_recursive($this->collection, function ($a) use (&$return) {
            $return[] = $a;
        }));
    }

    public function combine(array $values) : Collection
    {
        foreach ($this->collection as $key => $value) {
            if (is_int($key) && is_string($value)) {
                $this->collection[$value] = current($values);
                unset($this->collection[$key]);
            } elseif (is_string($key) && is_string($value)) {
                $this->collection[$key] = [$value, current($values)];
            } elseif (is_array($value)) {
                $this->collection[$key][] = current($values);
            } else {
                continue;
            }

            next($values);
        }

        return $this;
    }

    /**
     * Check if collection contains a value.
     *
     * @param string|int|float|\Closure $find Needle
     *
     * @return bool
     *
     * @since  1.0.0
     */
    public function contains($find) : bool
    {
        foreach ($this->collection as $key => $value) {
            if (is_string($find) && ((is_string($value) && $find === $value) || (is_array($value) && in_array($find, $value)))) {
                return true;
            } elseif ($find instanceof \Closure) {
                $result = $find($value, $key);

                if ($result) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Diff of collection.
     *
     * @param Collection|array $compare To compare with
     *
     * @return array
     *
     * @since  1.0.0
     */
    public function diff($compare) : array
    {
        $diff = [];

        foreach ($this->collection as $key => $value) {
            if ($value !== current($compare)) {
                $diff[] = $value;
            }

            next($compare);
        }

        return $diff;
    }

    public function diffKeys(array $compare)
    {
        $diff = [];

        foreach ($this->collection as $key => $value) {
            if ($key !== current($compare)) {
                $diff = $key;
            }

            next($compare);
        }

        return $diff;
    }

    /**
     * Get collection that contains every n-th element.
     *
     * @param int $n Every n-th element
     *
     * @return Collection
     *
     * @since  1.0.0
     */
    public function every(int $n) : Collection
    {
        $values = array_values($this->collection);
        $keys   = array_keys($this->collection);
        $count  = count($values);

        $new = [];
        for ($i = 0; $i < $count; $i += $n) {
            $new[$keys[$i]] = $values[$i];
        }

        return new self($new);
    }

    public function get($key)
    {
        if (!isset($this->collection[$key])) {
            if (is_int($key) && $key < $this->count()) {
                return $this->collection[array_keys($this->collection)[$key]];
            }
        } else {
            return $this->collection[$key];
        }

        return null;
    }

    public function except($filter) : Collection
    {
        if (!is_array($filter)) {
            $filter = [$filter];
        }

        $new = [];
        for ($i = 0; $i < $this->count(); $i++) {

            if (!in_array($this->get($i), $filter)) {
                $new[] = $this->get($i);
            }
        }

        return new self($new);
    }

    public function filter($filter) : Collection
    {
        $new = [];
        foreach ($this->collection as $key => $value) {
            if ($filter($key, $value)) {
                $new[$key] = $value;
            }
        }

        return new self($new);
    }

    public function first(\Closure $filter = null)
    {
        foreach ($this->collection as $key => $value) {
            if (!isset($filter) || $filter($key, $value)) {
                return $value;
            }
        }

        return null;
    }

    public function flatten() : Collection
    {
        return new self(ArrayUtils::arrayFlatten($this->collection));
    }

    public function flip() : Collection
    {
        return new self(array_flip($this->collection));
    }

    public function groupBy($filter) : Collection
    {
        $new = [];
        foreach ($this->collection as $key => $value) {
            if (is_string($filter)) {
                $group = $filter;
            } elseif ($filter instanceof \Closure) {
                $group = $filter($value, $key);
            } else {
                throw new \Exception();
            }

            $new[$value[$group]][] = $value;
        }

        return new self($new);
    }

    public function last(\Closure $filter = null)
    {
        $collection = array_reverse($this->collection, true);
        foreach ($collection as $key => $value) {
            if (!isset($filter) || $filter($key, $value)) {
                return $value;
            }
        }

        return null;
    }

    public function sort() : Collection
    {
        return new self(arsort($this->collection));
    }

    public function sortBy($filter) : Collection
    {
        return new self(uasort($this->collection, $filter));
    }

    public function reverse() : Collection
    {
        return new self(array_reverse($this->collection));
    }

    public function map($filter) : Collection
    {
        $new = [];
        foreach ($this->collection as $key => $value) {
            $new[$key] = $filter($value, $key);
        }

        return new self($new);
    }

    public function remove($key) : Collection
    {
        if ($key instanceof \Closure) {
            foreach ($this->collection as $index => $value) {
                if ($key($value, $index)) {
                    unset($this->collection[$index]);
                }
            }
        } elseif (is_scalar($key)) {
            unset($this->collection[$key]);
        }

        return $this;
    }

    public function has($key) : bool
    {
        return isset($this->collection[$key]);
    }

    public function implode(string $delim, $key) : string
    {
        $implode = '';
        foreach ($this->collection as $colKey => $value) {
            if (!isset($key) && is_scalar($value)) {
                $implode .= $value . $delim;
            } elseif (isset($key)) {
                $implode .= $value[$key] . $delim;
            }
        }

        return rtrim($implode, $delim);
    }

    public function intersect(array $values) : Collection
    {
        $new = [];
        foreach ($this->collection as $key => $value) {
            if (in_array($value, $values)) {
                $new[] = $value;
            }
        }

        return new self($new);
    }

    public function isEmpty() : bool
    {
        return empty($this->collection);
    }

    public function keys() : array
    {
        return array_keys($this->collection);
    }

    public function max($key = null)
    {
        $max = null;
        foreach ($this->collection as $index => $value) {
            if (isset($key) && is_array($value)) {
                $value = $value[$index];
            }

            if (!isset($max) || $value > $max) {
                $max = $value;
            }
        }

        return $max;
    }

    public function min($key = null)
    {
        $min = null;
        foreach ($this->collection as $index => $value) {
            if (isset($key) && is_array($value)) {
                $value = $value[$index];
            }

            if (!isset($min) || $value > $min) {
                $min = $value;
            }
        }

        return $min;
    }

    public function only(array $filter) : Collection
    {
        $new = [];
        foreach ($filter as $key => $value) {
            $new[$value] = $this->collection[$value];
        }

        return new self($new);
    }

    public function pluck(string $id) : Collection
    {
        $new = [];
        foreach ($this->collection as $key => $value) {
            $new[] = $value[$id];
        }

        return new self($new);
    }

    public function merge(array $merge) : Collection
    {
        return new self(array_merge($this->collection, $merge));
    }

    public function pop()
    {
        return array_pop($this->collection);
    }

    public function prepend(...$element) : Collection
    {
        $this->collection = array_merge($element, $this->collection);

        return $this;
    }

    public function pull($key)
    {
        $value = $this->collection[$key];
        unset($this->collection[$key]);

        return $value;
    }

    public function put($key, $value) : Collection
    {
        $this->collection[$key] = $value;

        return $this;
    }

    public function random()
    {
        $i = mt_rand(0, $this->count() - 1);

        return $this->get($i);
    }

    public function reduce($callback, $start = 0)
    {
        $total = $start;
        foreach ($this->collection as $key => $value) {
            $total = $callback($total, $value, $key);
        }

        return $total;
    }

    public function search($filter, bool $strict = true) /* : void */
    {
        if (is_scalar($filter)) {
            array_search($filter, $this->collection, $strict);
        } else {
            foreach ($this->collection as $key => $value) {
                if ($filter($value, $key)) {
                    return $key;
                }
            }
        }

        return null;
    }

    public function shift() : Collection
    {
        return new self(array_shift($this->collection));
    }

    public function shuffle() : Collection
    {
        return new self(shuffle($this->collection));
    }

    public function slice(int $offset, int $length) : Collection
    {
        return new self(array_slice($this->collection, $offset, $length));
    }

    public function splice(int $offset, int $length) : Collection
    {
        return new self(array_splice($this->collection, $offset, $length));
    }

    public function push($value) : Collection
    {
        $this->collection[] = $value;

        return $this;
    }

    /**
     * Return the current element
     * @link  http://php.net/manual/en/iterator.current.php
     * @return mixed Can return any type.
     * @since 5.0.0
     */
    public function current()
    {
        return current($this->collection);
    }

    /**
     * Offset to retrieve
     *
     * @param mixed $offset The offset to retrieve.
     *
     * @return mixed Can return all value types.
     *
     * @throws \Exception
     *
     * @link  http://php.net/manual/en/arrayaccess.offsetget.php
     *
     * @since 1.0.0
     */
    public function offsetGet($offset)
    {
        if (!isset($this->collection[$offset])) {
            throw new \Exception('Invalid offset');
        }

        return $this->collection[$offset];
    }

    /**
     * Move forward to next element
     * @link  http://php.net/manual/en/iterator.next.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function next()
    {
        next($this->collection);
    }

    /**
     * Return the key of the current element
     * @link  http://php.net/manual/en/iterator.key.php
     * @return mixed scalar on success, or null on failure.
     * @since 5.0.0
     */
    public function key()
    {
        return key($this->collection);
    }

    /**
     * Checks if current position is valid
     * @link  http://php.net/manual/en/iterator.valid.php
     * @return boolean The return value will be casted to boolean and then evaluated.
     * Returns true on success or false on failure.
     * @since 5.0.0
     */
    public function valid()
    {
        return isset($this->collection[key($this->collection)]);
    }

    /**
     * Whether a offset exists
     * @link  http://php.net/manual/en/arrayaccess.offsetexists.php
     * @param mixed $offset <p>
     *                      An offset to check for.
     *                      </p>
     * @return boolean true on success or false on failure.
     *                      </p>
     *                      <p>
     *                      The return value will be casted to boolean if non-boolean was returned.
     * @since 5.0.0
     */
    public function offsetExists($offset)
    {
        return isset($this->collection[$offset]);
    }

    /**
     * Rewind the Iterator to the first element
     * @link  http://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function rewind()
    {
        rewind($this->collection);
    }

    /**
     * Offset to set
     * @link  http://php.net/manual/en/arrayaccess.offsetset.php
     * @param mixed $offset <p>
     *                      The offset to assign the value to.
     *                      </p>
     * @param mixed $value  <p>
     *                      The value to set.
     *                      </p>
     * @return void
     * @since 5.0.0
     */
    public function offsetSet($offset, $value)
    {
        $this->collection[$offset] = $value;
    }

    /**
     * Offset to unset
     * @link  http://php.net/manual/en/arrayaccess.offsetunset.php
     * @param mixed $offset <p>
     *                      The offset to unset.
     *                      </p>
     * @return void
     * @since 5.0.0
     */
    public function offsetUnset($offset)
    {
        if (isset($this->collection[$offset])) {
            unset($this->collection[$offset]);
        }
    }
}