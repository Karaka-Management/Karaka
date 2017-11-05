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
namespace Modules\HumanResourceManagement\Models;

use Modules\Admin\Models\AccountMapper;
use Modules\Organization\Models\UnitMapper;
use Modules\Organization\Models\DepartmentMapper;
use Modules\Organization\Models\PositionMapper;
use phpOMS\DataStorage\Database\DataMapperAbstract;

class EmployeeMapper extends DataMapperAbstract
{

    /**
     * Columns.
     *
     * @var array
     * @since 1.0.0
     */
    protected static $columns = [
        'hr_staff_id'         => ['name' => 'hr_staff_id', 'type' => 'int', 'internal' => 'id'],
        'hr_staff_account'     => ['name' => 'hr_staff_account', 'type' => 'int', 'internal' => 'account'],
        'hr_staff_unit'     => ['name' => 'hr_staff_unit', 'type' => 'int', 'internal' => 'unit'],
        'hr_staff_department'     => ['name' => 'hr_staff_department', 'type' => 'int', 'internal' => 'department'],
        'hr_staff_position'     => ['name' => 'hr_staff_position', 'type' => 'int', 'internal' => 'position'],
        'hr_staff_active'     => ['name' => 'hr_staff_active', 'type' => 'bool', 'internal' => 'isActive'],
    ];

    static protected $belongsTo = [
        'account' => [
            'mapper' => AccountMapper::class,
            'src'    => 'hr_staff_account',
        ],
        'unit' => [
            'mapper' => UnitMapper::class,
            'src'    => 'hr_staff_unit',
        ],
        'department' => [
            'mapper' => DepartmentMapper::class,
            'src'    => 'hr_staff_department',
        ],
        'position' => [
            'mapper' => PositionMapper::class,
            'src'    => 'hr_staff_position',
        ],
    ];

    /**
     * Primary table.
     *
     * @var string
     * @since 1.0.0
     */
    protected static $table = 'hr_staff';

    /**
     * Primary field name.
     *
     * @var string
     * @since 1.0.0
     */
    protected static $primaryField = 'hr_staff_id';
}
