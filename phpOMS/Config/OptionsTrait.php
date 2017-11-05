<?php
/**
 * Orange Management
 *
 * PHP Version 7.1
 *
 * @category   Framework
 * @package    phpOMS\Config
 * @copyright  Dennis Eichhorn
 * @license    OMS License 1.0
 * @version    1.0.0
 * @link       http://website.orange-management.de
 */
declare(strict_types = 1);

namespace phpOMS\Config;

/**
 * Options trait.
 *
 * @category   Framework
 * @package    phpOMS\Config
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
trait OptionsTrait
{

    /**
     * Options.
     *
     * @var array
     * @since 1.0.0
     */
    private $options = [];

    /**
     * {@inheritdoc}
     */
    public function exists($key) : bool
    {
        return isset($this->options[$key]);
    }

    /**
     * {@inheritdoc}
     */
    public function getOption($key)
    {
        return $this->options[$key] ?? null;
    }

    /**
     * {@inheritdoc}
     */
    public function setOption($key, $value, bool $overwrite = true) : bool
    {
        if ($overwrite || !array_key_exists($key, $this->options)) {
            $this->options[$key] = $value;

            return true;
        }

        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function setOptions(array $pair, bool $overwrite = true) : bool
    {
        if ($overwrite) {
            $this->options += $pair;

            return true;
        }

        return false;
    }

}
