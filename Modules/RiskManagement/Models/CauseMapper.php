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

use phpOMS\DataStorage\Database\DataMapperAbstract;
use phpOMS\DataStorage\Database\Query\Builder;
use phpOMS\DataStorage\Database\Query\Column;
use phpOMS\DataStorage\Database\RelationType;

class CauseMapper extends DataMapperAbstract
{
    /**
     * Columns.
     *
     * @var array
     * @since 1.0.0
     */
    protected static $columns = [
        'riskmngmt_cause_id'         => ['name' => 'riskmngmt_cause_id', 'type' => 'int', 'internal' => 'id'],
        'riskmngmt_cause_name'     => ['name' => 'riskmngmt_cause_name', 'type' => 'string', 'internal' => 'title'],
        'riskmngmt_cause_description'     => ['name' => 'riskmngmt_cause_description', 'type' => 'string', 'internal' => 'description'],
        'riskmngmt_cause_descriptionraw'     => ['name' => 'riskmngmt_cause_descriptionraw', 'type' => 'string', 'internal' => 'descriptionRaw'],
        'riskmngmt_cause_department'     => ['name' => 'riskmngmt_cause_department', 'type' => 'int', 'internal' => 'department'],
        'riskmngmt_cause_category'     => ['name' => 'riskmngmt_cause_category', 'type' => 'int', 'internal' => 'category'],
        'riskmngmt_cause_risk'     => ['name' => 'riskmngmt_cause_risk', 'type' => 'int', 'internal' => 'risk'],
        'riskmngmt_cause_probability'     => ['name' => 'riskmngmt_cause_probability', 'type' => 'int', 'internal' => 'probability'],
    ];

    protected static $belongsTo = [
        'risk' => [
            'mapper'         => RiskMapper::class,
            'dest'            => 'riskmngmt_cause_risk',
        ],
        'category' => [
            'mapper'         => CategoryMapper::class,
            'dest'            => 'riskmngmt_cause_category',
        ],
        'department' => [
            'mapper'         => DepartmentMapper::class,
            'dest'            => 'riskmngmt_cause_department',
        ],
    ];

    /**
     * Primary table.
     *
     * @var string
     * @since 1.0.0
     */
    protected static $table = 'riskmngmt_cause';

    /**
     * Primary field name.
     *
     * @var string
     * @since 1.0.0
     */
    protected static $primaryField = 'riskmngmt_cause_id';

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
     * @return Cause
     *
     * @since  1.0.0
     */
    public static function get($primaryKey, int $relations = RelationType::ALL, $fill = null)
    {
        return parent::get($primaryKey, $relations, $fill);
    }
}
