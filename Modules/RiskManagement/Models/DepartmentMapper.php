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
namespace Modules\RiskManagement\Models;

use Modules\Media\Models\MediaMapper;
use phpOMS\DataStorage\Database\DataMapperAbstract;
use phpOMS\DataStorage\Database\Query\Builder;
use phpOMS\DataStorage\Database\Query\Column;
use phpOMS\DataStorage\Database\RelationType;

class DepartmentMapper extends DataMapperAbstract
{
    /**
     * Columns.
     *
     * @var array
     * @since 1.0.0
     */
    protected static $columns = [
        'riskmngmt_department_id'         => ['name' => 'riskmngmt_department_id', 'type' => 'int', 'internal' => 'id'],
        'riskmngmt_department_department'     => ['name' => 'riskmngmt_department_department', 'type' => 'int', 'internal' => 'department'],
        'riskmngmt_department_responsible'     => ['name' => 'riskmngmt_department_responsible', 'type' => 'int', 'internal' => 'responsible'],
        'riskmngmt_department_deputy'     => ['name' => 'riskmngmt_department_deputy', 'type' => 'int', 'internal' => 'deputy'],
    ];

    /**
     * Primary table.
     *
     * @var string
     * @since 1.0.0
     */
    protected static $table = 'riskmngmt_department';

    /**
     * Primary field name.
     *
     * @var string
     * @since 1.0.0
     */
    protected static $primaryField = 'riskmngmt_department_id';

    /**
     * Has one relation.
     *
     * @var array
     * @since 1.0.0
     */
    protected static $belongsTo = [
        'department' => [
            'mapper' => \Modules\Organization\Models\DepartmentMapper::class,
            'dest'    => 'riskmngmt_department_department',
        ],
    ];

}
