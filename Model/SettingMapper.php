<?php
/**
 * Orange Management
 *
 * PHP Version 8.0
 *
 * @package   Model
 * @copyright Dennis Eichhorn
 * @license   OMS License 1.0
 * @version   1.0.0
 * @link      https://orange-management.org
 */
declare(strict_types=1);

namespace Model;

use phpOMS\DataStorage\Database\DataMapperAbstract;
use phpOMS\DataStorage\Database\Query\Builder;
use phpOMS\DataStorage\Database\RelationType;

/**
 * Account mapper class.
 *
 * @package Model
 * @license OMS License 1.0
 * @link    https://orange-management.org
 * @since   1.0.0
 */
final class SettingMapper extends DataMapperAbstract
{
    /**
     * Columns.
     *
     * @var array<string, array<string, bool|string|array>>
     * @since 1.0.0
     */
    protected static array $columns = [
        'settings_id'             => ['name' => 'settings_id',           'type' => 'int',      'internal' => 'id'],
        'settings_name'           => ['name' => 'settings_name',        'type' => 'string',   'internal' => 'name'],
        'settings_content'        => ['name' => 'settings_content',        'type' => 'string',   'internal' => 'content'],
        'settings_pattern'        => ['name' => 'settings_pattern',        'type' => 'string',   'internal' => 'pattern'],
        'settings_app'            => ['name' => 'settings_app',        'type' => 'int',   'internal' => 'app'],
        'settings_module'         => ['name' => 'settings_module',        'type' => 'string',   'internal' => 'module'],
        'settings_group'          => ['name' => 'settings_group',        'type' => 'int',   'internal' => 'group'],
        'settings_account'        => ['name' => 'settings_account',        'type' => 'int',   'internal' => 'account'],
    ];

    /**
     * Model to use by the mapper.
     *
     * @var string
     * @since 1.0.0
     */
    protected static string $model = Setting::class;

    /**
     * Primary table.
     *
     * @var string
     * @since 1.0.0
     */
    protected static string $table = 'settings';

    /**
     * Primary field name.
     *
     * @var string
     * @since 1.0.0
     */
    protected static string $primaryField = 'settings_id';

    /**
     * Save setting / option to database
     *
     * @param Setting $option Option / setting
     *
     * @return void
     *
     * @since 1.0.0
     */
    public static function saveSetting(Setting $option) : void
    {
        $query = new Builder(self::$db);
        $query->update(self::$table)
            ->set(['settings_content' => $option->content]);

        if (!empty($option->getId())) {
            $query->where('settings_id', '=', $option->getId());
        }

        if (!empty($option->name)) {
            $query->andWhere('settings_name', '=', $option->name);
        }

        if (!empty($option->app)) {
            $query->andWhere('settings_app', '=', $option->app);
        }

        if (!empty($option->module)) {
            $query->andWhere('settings_module', '=', $option->module);
        }

        if (!empty($option->group)) {
            $query->andWhere('settings_group', '=', $option->group);
        }

        if (!empty($option->account)) {
            $query->andWhere('settings_account', '=', $option->account);
        }

        $sth = self::$db->con->prepare($query->toSql());
        if ($sth === false) {
            return; // @codeCoverageIgnore
        }

        $sth->execute();
    }

    /**
     * Get setting / option from database
     *
     * @param array $where Where conditions
     *
     * @return array
     *
     * @since 1.0.0
     */
    public static function getSettings(array $where) : array
    {
        $depth = 3;
        $query = self::getQuery();

        if (!empty($where['ids'])) {
            $query->where('settings_id', 'in', $where['ids']);
        }

        if (!empty($where['names'])) {
            $query->andWhere('settings_name', 'in', $where['names']);
        }

        if (!empty($where['app'])) {
            $query->andWhere('settings_app', '=', $where['app']);
        }

        if (!empty($where['module'])) {
            $query->andWhere('settings_module', '=', $where['module']);
        }

        if (!empty($where['group'])) {
            $query->andWhere('settings_group', '=', $where['group']);
        }

        if (!empty($where['account'])) {
            $query->andWhere('settings_account', '=', $where['account']);
        }

        return self::getAllByQuery($query, RelationType::ALL, $depth);
    }
}
