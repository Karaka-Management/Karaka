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
use Modules\Organization\Models\UnitMapper;
use Modules\RiskManagement\Models\RiskObject;
use phpOMS\DataStorage\Database\DataMapperAbstract;
use phpOMS\DataStorage\Database\Query\Builder;
use phpOMS\DataStorage\Database\Query\Column;
use phpOMS\DataStorage\Database\RelationType;

class RiskMapper extends DataMapperAbstract
{
    /**
     * Columns.
     *
     * @var array
     * @since 1.0.0
     */
    protected static $columns = [
        'riskmngmt_risk_id'         => ['name' => 'riskmngmt_risk_id', 'type' => 'int', 'internal' => 'id'],
        'riskmngmt_risk_name'     => ['name' => 'riskmngmt_risk_name', 'type' => 'string', 'internal' => 'name'],
        'riskmngmt_risk_description'     => ['name' => 'riskmngmt_risk_description', 'type' => 'string', 'internal' => 'description'],
        'riskmngmt_risk_descriptionraw'     => ['name' => 'riskmngmt_risk_descriptionraw', 'type' => 'string', 'internal' => 'descriptionRaw'],
        'riskmngmt_risk_unit' => ['name' => 'riskmngmt_risk_unit', 'type' => 'int', 'internal' => 'unit'],
        'riskmngmt_risk_department' => ['name' => 'riskmngmt_risk_department', 'type' => 'int', 'internal' => 'department'],
        'riskmngmt_risk_category' => ['name' => 'riskmngmt_risk_category', 'type' => 'int', 'internal' => 'category'],
        'riskmngmt_risk_project' => ['name' => 'riskmngmt_risk_project', 'type' => 'int', 'internal' => 'project'],
        'riskmngmt_risk_process' => ['name' => 'riskmngmt_risk_process', 'type' => 'int', 'internal' => 'process'],
        'riskmngmt_risk_responsible' => ['name' => 'riskmngmt_risk_responsible', 'type' => 'int', 'internal' => 'responsible'],
        'riskmngmt_risk_deputy' => ['name' => 'riskmngmt_risk_deputy', 'type' => 'int', 'internal' => 'deputy'],
    ];

    /**
     * Has many relation.
     *
     * @var array
     * @since 1.0.0
     */
    protected static $hasMany = [
        'media' => [ 
            'mapper'         => MediaMapper::class,
            'table'          => 'riskmngmt_risk_media',
            'dst'            => 'riskmngmt_risk_media_risk',
            'src'            => 'riskmngmt_risk_media_media',
        ],
        'riskObjects' => [ 
            'mapper'         => RiskObjectMapper::class,
            'table'          => 'riskmngmt_risk_object',
            'dst'            => 'riskmngmt_risk_object_risk',
            'src'            => null,
        ],
        'causes' => [ 
            'mapper'         => CauseMapper::class,
            'table'          => 'riskmngmt_cause',
            'dst'            => 'riskmngmt_cause_risk',
            'src'            => null,
        ],
        'solutions' => [ 
            'mapper'         => SolutionMapper::class,
            'table'          => 'riskmngmt_solution',
            'dst'            => 'riskmngmt_solution_risk',
            'src'            => null,
        ],
    ];

    protected static $belongsTo = [
        'project' => [
            'mapper'         => ProjectMapper::class,
            'dest'            => 'riskmngmt_risk_project',
        ],
        'process' => [
            'mapper'         => ProcessMapper::class,
            'dest'            => 'riskmngmt_risk_process',
        ],
        'category' => [
            'mapper'         => CategoryMapper::class,
            'dest'            => 'riskmngmt_risk_category',
        ],
        'department' => [
            'mapper'         => DepartmentMapper::class,
            'dest'            => 'riskmngmt_risk_department',
        ],
        'unit' => [
            'mapper'         => UnitMapper::class,
            'dest'            => 'riskmngmt_risk_unit',
        ],
    ];

    /**
     * Primary table.
     *
     * @var string
     * @since 1.0.0
     */
    protected static $table = 'riskmngmt_risk';

    /**
     * Primary field name.
     *
     * @var string
     * @since 1.0.0
     */
    protected static $primaryField = 'riskmngmt_risk_id';

    /**
     * Create object.
     *
     * @param mixed $obj       Object
     * @param int   $relations Behavior for relations creation
     *
     * @return mixed
     *
     * @since  1.0.0
     */
    public static function create($obj, int $relations = RelationType::ALL)
    {
        try {
            $objId = parent::create($obj, $relations);

            if ($objId === null || !is_scalar($objId)) {
                return $objId;
            }
        } catch (\Exception $e) {
            return false;
        }

        return $objId;
    }

    /**
     * Get object.
     *
     * @param mixed $primaryKey Key
     * @param int   $relations  Load relations
     * @param mixed $fill       Object to fill
     *
     * @return supplier
     *
     * @since  1.0.0
     */
    public static function get($primaryKey, int $relations = RelationType::ALL, $fill = null)
    {
        return parent::get($primaryKey, $relations, $fill);
    }
}
