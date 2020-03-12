<?php
/**
 * Orange Management
 *
 * PHP Version 7.4
 *
 * @package   Model
 * @copyright Dennis Eichhorn
 * @license   OMS License 1.0
 * @version   1.0.0
 * @link      https://orange-management.org
 */
declare(strict_types=1);

namespace Model;

use phpOMS\Config\OptionsTrait;
use phpOMS\Config\SettingsInterface;
use phpOMS\DataStorage\Cache\CachePool;
use phpOMS\DataStorage\Database\Connection\ConnectionAbstract;
use phpOMS\DataStorage\Database\Query\Builder;

/**
 * Core settings class.
 *
 * This is used in order to manage global Framework and Module settings
 *
 * @package Model
 * @license OMS License 1.0
 * @link    https://orange-management.org
 * @since   1.0.0
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
     * Database connection instance.
     *
     * @var ConnectionAbstract
     * @since 1.0.0
     */
    protected ConnectionAbstract $connection;

    /**
     * Columns.
     *
     * @var string[]
     * @since 1.0.0
     */
    protected static array $columns = [
        'id'      => 'settings_id',
        'name'    => 'settings_name',
        'content' => 'settings_content',
        'module'  => 'settings_module',
        'group'   => 'settings_group',
        'account' => 'settings_account',
    ];

    /**
     * Settings table.
     *
     * @var string
     * @since 1.0.0
     */
    protected static ?string $table = 'settings';

    /**
     * Constructor.
     *
     * @param ConnectionAbstract $connection Database connection
     *
     * @since 1.0.0
     */
    public function __construct(ConnectionAbstract $connection)
    {
        $this->connection = $connection;
    }

    /**
     * {@inheritdoc}
     */
    public function get(
        $ids = null,
        $names = null,
        string $module = null,
        int $group = null,
        int $account = null
    ) {
        $options = [];

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
                $key = ($name ?? '') . ':' . ($module ?? '') . ':' . ($group ?? '') . ':' . ($account ?? '');

                if ($this->exists($key)) {
                    $options[$key] = $this->getOption($key);
                    unset($names[$i]);
                }
            }
        }

        // all from cache
        if (empty($ids) && empty($names)) {
            return \count($options) > 1 ? $options : \reset($options);
        }

        // remaining from storage
        try {
            $dbOptions = [];
            $query     = new Builder($this->connection);
            $query->select(...\array_values(static::$columns))
                ->from(static::$table);

            if (!empty($ids)) {
                $query->where(static::$columns['id'], 'in', $ids);
            }

            if ($names !== null) {
                $query->andWhere(static::$columns['name'], 'in', $names);
            }

            if ($module !== null) {
                $query->andWhere(static::$columns['module'], '=', $module);
            }

            if ($group !== null) {
                $query->andWhere(static::$columns['group'], '=', $group);
            }

            if ($account !== null) {
                $query->andWhere(static::$columns['account'], '=', $account);
            }

            $sql = $query->toSql();

            $sth = $this->connection->con->prepare($sql);
            $sth->execute();

            $dbOptions = $sth->fetchAll(\PDO::FETCH_ASSOC);

            if ($dbOptions === false) {
                return \count($options) > 1 ? $options : \reset($options);
            }

            foreach ($dbOptions as $option) {
                $this->setOptions(
                    [
                        $option[static::$columns['name']] =>
                        [
                            'id'      => $option[static::$columns['id']] ?? null,
                            'name'    => $option[static::$columns['name']],
                            'content' => $option[static::$columns['content']],
                            'module'  => $option[static::$columns['module']] ?? null,
                            'group'   => $option[static::$columns['group']] ?? null,
                            'account' => $option[static::$columns['account']] ?? null,
                        ],
                    ],
                    true
                );
                $options[$option[static::$columns['name']]] = $option[static::$columns['content']];
            }
        } catch (\Throwable $e) {
            throw $e;
        }

        return \count($options) > 1 ? $options : \reset($options);
    }

    /**
     * {@inheritdoc}
     */
    public function set(array $options, bool $store = false) : void
    {
        if ($store) {
            $this->connection->con->beginTransaction();
        }

        foreach ($options as $option) {
            $this->setOptions(
                [
                    $option['id'] ?? $option['name'] ?? '0' =>
                    [
                        'id'      => $option['id'] ?? null,
                        'name'    => $option['name'] ?? null,
                        'content' => $option['content'] ?? null,
                        'module'  => $option['module'] ?? null,
                        'group'   => $option['group'] ?? null,
                        'account' => $option['account'] ?? null,
                    ],
                ],
                true
            );

            if (!$store) {
                continue;
            }

            $query = new Builder($this->connection);
            $query->update(static::$table)
                ->set([static::$columns['content'] => $option['content']]);

            if (!empty($option['id'])) {
                $query->where(static::$columns['id'], 'in', $option['id']);
            }

            if (isset($option['name'])) {
                $query->andWhere(static::$columns['name'], '=', $option['name']);
            }

            if (isset($option['module'])) {
                $query->andWhere(static::$columns['module'], '=', $option['module']);
            }

            if (isset($option['group'])) {
                $query->andWhere(static::$columns['group'], '=', $option['group']);
            }

            if (isset($option['account'])) {
                $query->andWhere(static::$columns['account'], '=', $option['account']);
            }

            $sth = $this->connection->con->prepare($query->toSql());
            $sth->execute();
        }

        if ($store) {
            $this->connection->con->commit();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function save(array $options = []) : void
    {
        $this->connection->con->beginTransaction();

        $options = empty($options) ? $this->options : $options;

        foreach ($options as $option) {
            $query = new Builder($this->connection);
            $query->update(static::$table)
                ->set([static::$columns['content'] => $option['content']]);

            if (!empty($option['id'])) {
                $query->where(static::$columns['id'], '=', $option['id']);
            }

            if (isset($option['name'])) {
                $query->andWhere(static::$columns['name'], '=', $option['name']);
            }

            if (isset($option['module'])) {
                $query->andWhere(static::$columns['module'], '=', $option['module']);
            }

            if (isset($option['group'])) {
                $query->andWhere(static::$columns['group'], '=', $option['group']);
            }

            if (isset($option['account'])) {
                $query->andWhere(static::$columns['account'], '=', $option['account']);
            }

            $sth = $this->connection->con->prepare($query->toSql());
            $sth->execute();
        }

        $this->connection->con->commit();
    }

    /**
     * {@inheritdoc}
     */
    public function create(array $options = []) : void
    {
        $query = new Builder($this->connection);
        $query->into(static::$table);

        foreach ($options as $column => $option) {
            $query->insert(static::$columns[$column])
                ->value($option);
        }

        $sql = $query->toSql();
        $sth = $this->connection->con->prepare($sql);
        $sth->execute();
    }
}
