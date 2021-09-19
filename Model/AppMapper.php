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

/**
 * Account mapper class.
 *
 * @package Model
 * @license OMS License 1.0
 * @link    https://orange-management.org
 * @since   1.0.0
 */
final class AppMapper extends DataMapperAbstract
{
    /**
     * Columns.
     *
     * @var array<string, array<string, bool|string|array>>
     * @since 1.0.0
     */
    protected static array $columns = [
        'app_id'             => ['name' => 'app_id',           'type' => 'int',      'internal' => 'id'],
        'app_name'           => ['name' => 'app_name',        'type' => 'string',   'internal' => 'name'],
        'app_theme'           => ['name' => 'app_theme',        'type' => 'string',   'internal' => 'theme'],
        'app_status'         => ['name' => 'app_status',        'type' => 'int',   'internal' => 'status'],
    ];

    /**
     * Model to use by the mapper.
     *
     * @var string
     * @since 1.0.0
     */
    protected static string $model = App::class;

    /**
     * Primary table.
     *
     * @var string
     * @since 1.0.0
     */
    protected static string $table = 'app';

    /**
     * Primary field name.
     *
     * @var string
     * @since 1.0.0
     */
    protected static string $primaryField = 'app_id';
}
