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

use phpOMS\DataStorage\Database\DataMapperAbstract;

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
}
