<?php
/**
 * Jingga
 *
 * PHP Version 8.1
 *
 * @package   Model
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.0
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

namespace Model;

use phpOMS\DataStorage\Database\Mapper\DataMapperFactory;
use phpOMS\DataStorage\Database\Query\Builder;

/**
 * Account mapper class.
 *
 * @package Model
 * @license OMS License 2.0
 * @link    https://jingga.app
 * @since   1.0.0
 *
 * @template T of Setting
 * @extends  DataMapperFactory<T>
 */
final class SettingMapper extends DataMapperFactory
{
    /**
     * Columns.
     *
     * @var array<string, array{name:string, type:string, internal:string, autocomplete?:bool, readonly?:bool, writeonly?:bool, annotations?:array}>
     * @since 1.0.0
     */
    public const COLUMNS = [
        'settings_id'                => ['name' => 'settings_id',           'type' => 'int',      'internal' => 'id'],
        'settings_name'              => ['name' => 'settings_name',        'type' => 'string',   'internal' => 'name'],
        'settings_content'           => ['name' => 'settings_content',        'type' => 'string',   'internal' => 'content'],
        'settings_pattern'           => ['name' => 'settings_pattern',        'type' => 'string',   'internal' => 'pattern'],
        'settings_unit'              => ['name' => 'settings_unit',        'type' => 'int',   'internal' => 'unit'],
        'settings_app'               => ['name' => 'settings_app',        'type' => 'int',   'internal' => 'app'],
        'settings_module'            => ['name' => 'settings_module',        'type' => 'string',   'internal' => 'module'],
        'settings_group'             => ['name' => 'settings_group',        'type' => 'int',   'internal' => 'group'],
        'settings_account'           => ['name' => 'settings_account',        'type' => 'int',   'internal' => 'account'],
        'settings_encrypted'         => ['name' => 'settings_encrypted',        'type' => 'bool',   'internal' => 'isEncrypted'],
    ];

    /**
     * Model to use by the mapper.
     *
     * @var class-string<T>
     * @since 1.0.0
     */
    public const MODEL = Setting::class;

    /**
     * Primary table.
     *
     * @var string
     * @since 1.0.0
     */
    public const TABLE = 'settings';

    /**
     * Primary field name.
     *
     * @var string
     * @since 1.0.0
     */
    public const PRIMARYFIELD = 'settings_id';

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
        $query->update(self::TABLE)
            ->set(['settings_content' => $option->content]);

        if (!empty($option->getId())) {
            $query->where('settings_id', '=', $option->getId());
        } else {
            if (!empty($option->name)) {
                $query->where('settings_name', '=', $option->name);
            }

            if (!empty($option->unit)) {
                $query->andWhere('settings_unit', '=', $option->unit);
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
        $query = self::getQuery();

        if (!empty($where['ids'])) {
            $query->where('settings_id', 'in', $where['ids']);
        } else {
            if (isset($where['names'])) {
                $query->where('settings_name', 'in', $where['names']);
            }

            if (isset($where['unit'])) {
                $query->andWhere('settings_unit', '=', $where['unit']);
            }

            if (isset($where['app'])) {
                $query->andWhere('settings_app', '=', $where['app']);
            }

            if (isset($where['module'])) {
                $query->andWhere('settings_module', '=', $where['module']);
            }

            if (isset($where['group'])) {
                $query->andWhere('settings_group', '=', $where['group']);
            }

            if (isset($where['account'])) {
                $query->andWhere('settings_account', '=', $where['account']);
            }
        }

        var_dump($query->toSql());

        return self::getAll()->execute($query);
    }
}
