<?php
/**
 * Jingga
 *
 * PHP Version 8.2
 *
 * @package   Model
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.0
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

namespace Model;

use phpOMS\Config\OptionsTrait;
use phpOMS\Config\SettingsInterface;
use phpOMS\DataStorage\Cache\CachePool;

/**
 * Core settings class.
 *
 * This is used in order to manage global Framework and Module settings
 *
 * @package Model
 * @license OMS License 2.0
 * @link    https://jingga.app
 * @since   1.0.0
 *
 * @question Maybe it makes sense to allow modules and applications to install settings to be loaded based on the route.
 *      This would mean application would load all required settings at the beginning once and further queries
 *      would not be necessary effectively saving a bunch of individual queries.
 */
final class CoreSettings implements SettingsInterface
{
    use OptionsTrait;

    /**
     * Cache manager (pool).
     *
     * @var null|CachePool
     * @since 1.0.0
     */
    protected ?CachePool $cache = null;

    /**
     * {@inheritdoc}
     */
    public function get(
        mixed $ids = null,
        string|array|null $names = null,
        ?int $unit = null,
        ?int $app = null,
        ?string $module = null,
        ?int $group = null,
        ?int $account = null
    ) : mixed {
        $options      = [];
        $expectsArray = \is_array($ids) || \is_array($names);

        // get by ids
        if ($ids !== null) {
            if (!\is_array($ids)) {
                $ids = [$ids];
            }

            foreach ($ids as $i => $id) {
                if ($this->exists($id)) {
                    $options[$id] = $this->getOption($id);
                    unset($ids[$i]);
                }
            }
        }

        // get by names
        if ($names !== null) {
            if (!\is_array($names)) {
                $names = [$names];
            }

            foreach ($names as $i => $name) {
                $key = $name
                    . ':' . ($unit ?? '')
                    . ':' . ($app ?? '')
                    . ':' . ($module ?? '')
                    . ':' . ($group ?? '')
                    . ':' . ($account ?? '');

                $key = \trim($key, ':');

                if ($this->exists($key)) {
                    $options[$name] = $this->getOption($key);
                    unset($names[$i]);
                }
            }
        }

        // all from cache
        if (empty($ids) && empty($names)) {
            return $expectsArray ? $options : \reset($options);
        }

        /**
         * @var \Model\Setting[] $dbOptions
         */
        $dbOptions = SettingMapper::getSettings(
            [
            'ids'     => $ids,
            'names'   => $names,
            'unit'    => $unit,
            'app'     => $app,
            'module'  => $module,
            'group'   => $group,
            'account' => $account,
            ]
        );

        // remaining from storage
        try {
            foreach ($dbOptions as $option) {
                $key = ($option->name)
                    . ':' . ($option->unit ?? '')
                    . ':' . ($option->app ?? '')
                    . ':' . ($option->module ?? '')
                    . ':' . ($option->group ?? '')
                    . ':' . ($option->account ?? '');

                $key = \trim($key, ':');

                $this->setOption($key, $option, true);

                // required because the above solution inserts only by string,
                // this means the next get() call with just the int DB id would not hit the cache.
                // summary: line 65 would fail
                $this->setOption($option->id, $option, true);

                $options[$option->name] = $option;
            }
        } catch (\Throwable $_) {
            return new NullSetting();
        }

        if (empty($options)) {
            return $expectsArray ? [] : new NullSetting();
        }

        if ($expectsArray) {
            return \is_array($options) ? $options : [$options];
        } else {
            return \is_array($options) ? \reset($options) : $options;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function set(array $options, bool $store = false) : void
    {
        /**
         * @var array $option
         */
        foreach ($options as $option) {
            $key = '';
            if (\is_array($option)) {
                $key = ($option['name'] ?? '')
                    . ':' . ($option['unit'] ?? '')
                    . ':' . ($option['app'] ?? '')
                    . ':' . ($option['module'] ?? '')
                    . ':' . ($option['group'] ?? '')
                    . ':' . ($option['account'] ?? '');

                $key = \trim($key, ':');

                $setting = new Setting();
                $setting->with(
                    $option['id'] ?? 0,
                    $option['name'] ?? '',
                    $option['content'] ?? '',
                    $option['pattern'] ?? '',
                    $option['unit'] ?? null,
                    $option['app'] ?? null,
                    $option['module'] ?? null,
                    $option['group'] ?? null,
                    $option['account'] ?? null,
                    $option['isEncrypted'] ?? false,
                );
            } elseif (\is_object($option)) {
                $key = ($option->name ?? '')
                . ':' . ($option->unit ?? '')
                . ':' . ($option->app ?? '')
                . ':' . ($option->module ?? '')
                . ':' . ($option->group ?? '')
                . ':' . ($option->account ?? '');

                $key = \trim($key, ':');

                $setting = $option;
            } else {
                return;
            }

            $this->setOption($key, $setting, true);
            if (isset($setting->id)) {
                $this->setOption($setting->id, $setting, true);
            }

            if ($store) {
                SettingMapper::saveSetting($setting);
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function save(array $options = []) : void
    {
        // @feature The options are database focused but for applications we may also want simple memory/runtime options
        //      https://github.com/Karaka-Management/Karaka/issues/252
        $options = empty($options) ? $this->options : $options;

        foreach ($options as $option) {
            if (\is_array($option)) {
                if ($option['session'] ?? false) {
                    continue;
                }

                $setting = new Setting();
                $setting->with(
                    $option['id'] ?? 0,
                    $option['name'] ?? '',
                    $option['content'] ?? '',
                    $option['pattern'] ?? '',
                    $option['app'] ?? null,
                    $option['module'] ?? null,
                    $option['group'] ?? null,
                    $option['account'] ?? null,
                );

                $option = $setting;
            }

            SettingMapper::saveSetting($option);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function create(array $options = []) : void
    {
        $setting = new Setting();
        foreach ($options as $column => $option) {
            $setting->{$column} = $option;
        }

        SettingMapper::create()->execute($setting);
    }
}
