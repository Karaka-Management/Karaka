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
namespace Modules\Admin\Models;

use phpOMS\DataStorage\Database\DataMapperAbstract;
use phpOMS\DataStorage\Database\RelationType;

class GroupPermissionMapper extends DataMapperAbstract
{

    /**
     * Columns.
     *
     * @var array
     * @since 1.0.0
     */
    protected static $columns = [
        'group_permission_id'      => ['name' => 'group_permission_id', 'type' => 'int', 'internal' => 'id'],
        'group_permission_group'      => ['name' => 'group_permission_group', 'type' => 'int', 'internal' => 'group'],
        'group_permission_unit'      => ['name' => 'group_permission_unit', 'type' => 'int', 'internal' => 'unit'],
        'group_permission_app'      => ['name' => 'group_permission_app', 'type' => 'string', 'internal' => 'app'],
        'group_permission_module'      => ['name' => 'group_permission_module', 'type' => 'int', 'internal' => 'module'],
        'group_permission_from'      => ['name' => 'group_permission_from', 'type' => 'int', 'internal' => 'from'],
        'group_permission_type'      => ['name' => 'group_permission_type', 'type' => 'int', 'internal' => 'type'],
        'group_permission_element'      => ['name' => 'group_permission_element', 'type' => 'int', 'internal' => 'element'],
        'group_permission_component'      => ['name' => 'group_permission_component', 'type' => 'int', 'internal' => 'component'],
        'group_permission_permission'      => ['name' => 'group_permission_permission', 'type' => 'int', 'internal' => 'permission'],
    ];

    /**
     * Primary table.
     *
     * @var string
     * @since 1.0.0
     */
    protected static $table = 'group_permission';

    /**
     * Primary field name.
     *
     * @var string
     * @since 1.0.0
     */
    protected static $primaryField = 'group_permission_id';
}
