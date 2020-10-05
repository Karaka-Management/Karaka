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
    protected static string $table = 'settings';

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
                $key = ($name ?? '')
                    . ':' . ($module ?? '')
                    . ':' . ($group ?? '')
                    . ':' . ($account ?? '');

                $key = \trim($key, ':');

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

        $query = new Builder($this->connection);

        // remaining from storage
        try {
            $dbOptions = [];
            $query->select(...\array_values(static::$columns))
                ->from(static::$table);

            if (!empty($ids)) {
                $query->where(static::$columns['id'], (\is_array($ids) ? 'in' : '='), $ids);
            }

            if (!empty($names)) {
                $query->andWhere(static::$columns['name'], (\is_array($names) ? 'in' : '='), $names);
            }

            if (!empty($module)) {
                $query->andWhere(static::$columns['module'], '=', $module);
            }

            if (!empty($group)) {
                $query->andWhere(static::$columns['group'], '=', $group);
            }

            if (!empty($account)) {
                $query->andWhere(static::$columns['account'], '=', $account);
            }

            $sth = $this->connection->con->prepare($query->toSql());
            $sth->execute();

            $dbOptions = $sth->fetchAll(\PDO::FETCH_ASSOC);

            if ($dbOptions === false) {
                return \count($options) > 1 ? $options : \reset($options);
            }

            foreach ($dbOptions as $option) {
                $key = ($option[static::$columns['name']] ?? '')
                    . ':' . ($option[static::$columns['module']] ?? '')
                    . ':' . ($option[static::$columns['group']] ?? '')
                    . ':' . ($option[static::$columns['account']] ?? '');

                $key = \trim($key, ':');

                $this->setOptions(
                    [
                        $key =>
                        [
                            'id'      => $option[static::$columns['id']] ?? null,
                            'name'    => $option[static::$columns['name']] ?? null,
                            'content' => $option[static::$columns['content']] ?? null,
                            'module'  => $option[static::$columns['module']] ?? null,
                            'group'   => $option[static::$columns['group']] ?? null,
                            'account' => $option[static::$columns['account']] ?? null,
                        ],
                    ],
                    true
                );
                $options[$key] = $this->getOption($key);
            }
        } catch (\Throwable $e) {
            \var_dump($query->toSql()); // @codeCoverageIgnore
            throw $e; // @codeCoverageIgnore
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

        /** @var array $option */
        foreach ($options as $option) {
            $key = ($option['name'] ?? '')
                . ':' . ($option['module'] ?? '')
                . ':' . ($option['group'] ?? '')
                . ':' . ($option['account'] ?? '');

            $key = \trim($key, ':');

            $this->setOptions(
                [
                    $key =>
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

            if ($store) {
                $this->saveOptionToDatabase($option);
            }
        }

        if ($store) {
            $this->connection->con->commit();
        }
    }

    /**
     * Save setting / option to database
     *
     * @param array $option Option / setting
     *
     * @return void
     *
     * @since 1.0.0
     */
    private function saveOptionToDatabase(array $option) : void
    {
        $query = new Builder($this->connection);
        $query->update(static::$table)
            ->set([static::$columns['content'] => $option['content']]);

        if (!empty($option['id'])) {
            $query->where(static::$columns['id'], '=', $option['id']);
        }

        if (!empty($option['name'])) {
            $query->andWhere(static::$columns['name'], '=', $option['name']);
        }

        if (!empty($option['module'])) {
            $query->andWhere(static::$columns['module'], '=', $option['module']);
        }

        if (!empty($option['group'])) {
            $query->andWhere(static::$columns['group'], '=', $option['group']);
        }

        if (!empty($option['account'])) {
            $query->andWhere(static::$columns['account'], '=', $option['account']);
        }

        $sth = $this->connection->con->prepare($query->toSql());
        $sth->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function save(array $options = []) : void
    {
        $this->connection->con->beginTransaction();

        $options = empty($options) ? $this->options : $options;

        foreach ($options as $option) {
            $this->saveOptionToDatabase($option);
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
