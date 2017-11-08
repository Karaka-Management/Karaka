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

namespace phpOMS\Stdlib\Map;

use phpOMS\Utils\Permutation;

/**
 * Multimap utils.
 *
 * @category   Framework
 * @package    phpOMS\Stdlib
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
class MultiMap implements \Countable
{

    /**
     * Stored values.
     *
     * @var array
     * @since 1.0.0
     */
    private $values = [];

    /**
     * Associated keys for values.
     *
     * @var array
     * @since 1.0.0
     */
    private $keys = [];

    /**
     * Key type.
     *
     * @var int
     * @since 1.0.0
     */
    private $keyType = KeyType::SINGLE;

    /**
     * Order type.
     *
     * @var int
     * @since 1.0.0
     */
    private $orderType = OrderType::LOOSE;

    /**
     * Constructor.
     *
     * @param int $key   Key type (all keys need to match or just one)
     * @param int $order Order of the keys is important (only required for multiple keys)
     *
     * @since  1.0.0
     */
    public function __construct(int $key = KeyType::SINGLE, int $order = OrderType::LOOSE)
    {
        $this->keyType   = $key;
        $this->orderType = $order;
    }

    /**
     * Add data.
     *
     * @param array $keys      Keys for value
     * @param mixed $value     Value to store
     * @param bool  $overwrite Add value if key exists
     *
     * @return bool
     *
     * @since  1.0.0
     */
    public function add(array $keys, $value, bool $overwrite = true) : bool
    {
        $id       = count($this->values);
        $inserted = false;

        if ($this->keyType !== KeyType::SINGLE) {
            $keys = [implode(':', $keys)];
        }

        foreach ($keys as $key) {
            if ($overwrite || !isset($this->keys[$key])) {
                $id               = $this->keys[$key] ?? $id;
                $this->keys[$key] = $id;

                $inserted = true;
            }
        }

        if ($inserted) {
            $this->values[$id] = $value;
        }

        // todo: is this really required???? - i don't think so!
        $this->garbageCollect();

        return $inserted;
    }

    /**
     * Garbage collect unreferenced values/keys
     *
     * @return void
     *
     * @since  1.0.0
     */
    private function garbageCollect() /* : void */
    {
        /* garbage collect keys */
        foreach ($this->keys as $key => $keyValue) {
            if (!isset($this->values[$keyValue])) {
                unset($this->keys[$key]);
            }
        }

        /* garbage collect values */
        foreach ($this->values as $valueKey => $value) {
            if (!in_array($valueKey, $this->keys)) {
                unset($this->values[$valueKey]);
            }
        }
    }

    /**
     * Get data.
     *
     * @param mixed $key Key used to identify value
     *
     * @return mixed
     *
     * @since  1.0.0
     */
    public function get($key)
    {
        if ($this->keyType === KeyType::SINGLE) {
            return $this->getSingle($key);
        } else {
            return $this->getMultiple($key);
        }
    }

    /**
     * Get data.
     *
     * @param mixed $key Key used to identify value
     *
     * @return mixed
     *
     * @since  1.0.0
     */
    private function getSingle($key)
    {
        return isset($this->keys[$key]) ? $this->values[$this->keys[$key]] ?? null : null;
    }

    /**
     * Get data.
     *
     * @param mixed $key Key used to identify value
     *
     * @return mixed
     *
     * @since  1.0.0
     */
    private function getMultiple($key)
    {
        if (is_array($key)) {
            if ($this->orderType === OrderType::LOOSE) {
                $keys = Permutation::permut($key);

                foreach ($keys as $key => $value) {
                    $key = implode(':', $value);

                    if (isset($this->keys[$key])) {
                        return $this->values[$this->keys[$key]];
                    }
                }
            } else {
                $key = implode(':', $key);
            }
        }

        return isset($this->keys[$key]) ? $this->values[$this->keys[$key]] ?? null : null;
    }

    /**
     * Set existing key with data.
     *
     * @param mixed $key   Key used to identify value
     * @param mixed $value Value to store
     *
     * @return bool
     *
     * @since  1.0.0
     */
    public function set($key, $value) : bool
    {
        if ($this->keyType === KeyType::MULTIPLE && is_array($key)) {
            return $this->setMultiple($key, $value);
        }

        return $this->setSingle($key, $value);
    }

    /**
     * Set existing key with data.
     *
     * @param mixed $key   Key used to identify value
     * @param mixed $value Value to store
     *
     * @return bool
     *
     * @since  1.0.0
     */
    private function setMultiple($key, $value) : bool
    {
        if ($this->orderType !== OrderType::LOOSE) {
            $permutation = Permutation::permut($key);

            foreach ($permutation as $permut) {
                if ($this->set(implode(':', $permut), $value)) {
                    return true;
                }
            }
        } else {
            return $this->set(implode(':', $key), $value);
        }

        return false;
    }

    /**
     * Set existing key with data.
     *
     * @param mixed $key   Key used to identify value
     * @param mixed $value Value to store
     *
     * @return bool
     *
     * @since  1.0.0
     */
    private function setSingle($key, $value) : bool
    {
        if (isset($this->keys[$key])) {
            $this->values[$this->keys[$key]] = $value;

            return true;
        }

        return false;
    }

    /**
     * Remove value and all sibling keys based on key.
     *
     * @param mixed $key Key used to identify value
     *
     * @return bool
     *
     * @since  1.0.0
     */
    public function remove($key) : bool
    {
        if ($this->keyType === KeyType::MULTIPLE && is_array($key)) {
            return $this->removeMultiple($key);
        } else {
            return $this->removeSingle($key);
        }
    }

    /**
     * Remove value and all sibling keys based on key.
     *
     * @param mixed $key Key used to identify value
     *
     * @return void
     *
     * @since  1.0.0
     */
    private function removeMultiple($key) /* : void */
    {
        if ($this->orderType === OrderType::LOOSE) {
            $keys = Permutation::permut($key);

            foreach ($keys as $key => $value) {
                $this->remove(implode(':', $value));
            }
        } else {
            $this->remove(implode(':', $key));
        }
    }

    /**
     * Remove value and all sibling keys based on key.
     *
     * @param mixed $key Key used to identify value
     *
     * @return bool
     *
     * @since  1.0.0
     */
    private function removeSingle($key) : bool
    {
        if (isset($this->keys[$key])) {
            $id = $this->keys[$key];

            unset($this->values[$id]);

            $this->garbageCollect();

            return true;
        }

        return false;
    }

    /**
     * Remap key to a different value.
     *
     * Both keys need to exist in the multimap.
     *
     * @param mixed $old Old key
     * @param mixed $new New key
     *
     * @return bool
     *
     * @since  1.0.0
     */
    public function remap($old, $new) : bool
    {
        if ($this->keyType === KeyType::MULTIPLE) {
            return false;
        }

        if (isset($this->keys[$old], $this->keys[$new])) {
            $this->keys[$old] = $this->keys[$new];

            $this->garbageCollect();

            return true;
        }

        return false;
    }

    /**
     * Remove key.
     *
     * This only removes the value if no other key exists for this value.
     *
     * @param mixed $key Key used to identify value
     *
     * @return bool
     *
     * @since  1.0.0
     */
    public function removeKey($key) : bool
    {
        if ($this->keyType === KeyType::MULTIPLE && is_array($key)) {
            return $this->removeKeyMultiple($key);
        } else {
            return $this->removeKeySingle($key);
        }
    }

    /**
     * Remove key.
     *
     * This only removes the value if no other key exists for this value.
     *
     * @param mixed $key Key used to identify value
     *
     * @return bool
     *
     * @since  1.0.0
     */
    private function removeKeyMultiple($key) : bool
    {
        if ($this->orderType === OrderType::LOOSE) {
            $keys = Permutation::permut($key);

            $removed = false;

            foreach ($keys as $key => $value) {
                $removed |= $this->removeKey(implode(':', $value));
            }

            return $removed;
        } else {
            return $this->removeKey(implode(':', $key));
        }
    }

    /**
     * Remove key.
     *
     * This only removes the value if no other key exists for this value.
     *
     * @param mixed $key Key used to identify value
     *
     * @return bool
     *
     * @since  1.0.0
     */
    private function removeKeySingle($key) : bool
    {
        if (isset($this->keys[$key])) {
            unset($this->keys[$key]);

            $this->garbageCollect();

            return true;
        }

        return false;
    }

    /**
     * Get all sibling keys.
     *
     * @param mixed $key Key to find siblings for
     *
     * @return array
     *
     * @since  1.0.0
     */
    public function getSiblings($key) : array
    {
        if ($this->keyType === KeyType::MULTIPLE) {
            return $this->getSiblingsMultiple($key);
        }

        return $this->getSiblingsSingle($key);

    }

    /**
     * Get all sibling keys.
     *
     * @param mixed $key Key to find siblings for
     *
     * @return array
     *
     * @since  1.0.0
     */
    public function getSiblingsMultiple($key) : array
    {
        if ($this->orderType === OrderType::LOOSE) {
            return Permutation::permut($key);
        }

        return [];
    }

    /**
     * Get all sibling keys.
     *
     * @param mixed $key Key to find siblings for
     *
     * @return array
     *
     * @since  1.0.0
     */
    private function getSiblingsSingle($key) : array
    {
        $siblings = [];

        if (isset($this->keys[$key])) {
            $id = $this->keys[$key];

            foreach ($this->keys as $found => $value) {
                if ($value === $id && $found !== $key) {
                    $siblings[] = $found;
                }
            }
        }

        return $siblings;
    }

    /**
     * Get all keys.
     *
     * @return array
     *
     * @since  1.0.0
     */
    public function keys() : array
    {
        return $this->keys;
    }

    /**
     * Get all values.
     *
     * @return array
     *
     * @since  1.0.0
     */
    public function values() : array
    {
        return $this->values;
    }

    /**
     * Count values.
     *
     * @return int
     *
     * @since  1.0.0
     */
    public function count() : int
    {
        return count($this->values);
    }
}
