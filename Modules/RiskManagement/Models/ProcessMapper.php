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

use Modules\Organization\Models\UnitMapper;
use Modules\Media\Models\MediaMapper;
use phpOMS\DataStorage\Database\DataMapperAbstract;
use phpOMS\DataStorage\Database\Query\Builder;
use phpOMS\DataStorage\Database\Query\Column;
use phpOMS\DataStorage\Database\RelationType;

class ProcessMapper extends DataMapperAbstract
{
    /**
     * Columns.
     *
     * @var array
     * @since 1.0.0
     */
    protected static $columns = [
        'riskmngmt_process_id'         => ['name' => 'riskmngmt_process_id', 'type' => 'int', 'internal' => 'id'],
        'riskmngmt_process_name'     => ['name' => 'riskmngmt_process_name', 'type' => 'string', 'internal' => 'title'],
        'riskmngmt_process_description'     => ['name' => 'riskmngmt_process_description', 'type' => 'string', 'internal' => 'description'],
        'riskmngmt_process_descriptionraw'     => ['name' => 'riskmngmt_process_descriptionraw', 'type' => 'string', 'internal' => 'descriptionRaw'],
        'riskmngmt_process_department'     => ['name' => 'riskmngmt_process_department', 'type' => 'int', 'internal' => 'department'],
        'riskmngmt_process_unit'     => ['name' => 'riskmngmt_process_unit', 'type' => 'int', 'internal' => 'unit'],
        'riskmngmt_process_responsible'     => ['name' => 'riskmngmt_process_responsible', 'type' => 'int', 'internal' => 'responsible'],
        'riskmngmt_process_deputy'     => ['name' => 'riskmngmt_process_deputy', 'type' => 'int', 'internal' => 'deputy'],
    ];

    protected static $belongsTo = [
        'unit' => [
            'mapper'         => UnitMapper::class,
            'dest'            => 'riskmngmt_cause_risk',
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
    protected static $table = 'riskmngmt_process';

    /**
     * Primary field name.
     *
     * @var string
     * @since 1.0.0
     */
    protected static $primaryField = 'riskmngmt_process_id';

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
            var_dump($e->getMessage());

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
