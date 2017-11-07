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
use Modules\RiskManagement\Models\Risk;
use phpOMS\DataStorage\Database\DataMapperAbstract;
use phpOMS\DataStorage\Database\Query\Builder;
use phpOMS\DataStorage\Database\Query\Column;
use phpOMS\DataStorage\Database\RelationType;

class RiskObjectMapper extends DataMapperAbstract
{
    /**
     * Columns.
     *
     * @var array
     * @since 1.0.0
     */
    protected static $columns = [
        'riskmngmt_risk_object_id'         => ['name' => 'riskmngmt_risk_object_id', 'type' => 'int', 'internal' => 'id'],
        'riskmngmt_risk_object_name'     => ['name' => 'riskmngmt_risk_object_name', 'type' => 'string', 'internal' => 'title'],
        'riskmngmt_risk_object_description'     => ['name' => 'riskmngmt_risk_object_description', 'type' => 'string', 'internal' => 'description'],
        'riskmngmt_risk_object_descriptionraw'     => ['name' => 'riskmngmt_risk_object_descriptionraw', 'type' => 'string', 'internal' => 'descriptionRaw'],
        'riskmngmt_risk_object_risk'     => ['name' => 'riskmngmt_risk_object_risk', 'type' => 'int', 'internal' => 'risk'],
    ];

    protected static $belongsTo = [
        'unit' => [
            'mapper'         => RiskMapper::class,
            'dest'            => 'riskmngmt_risk_object_risk',
        ],
    ];

    /**
     * Primary table.
     *
     * @var string
     * @since 1.0.0
     */
    protected static $table = 'riskmngmt_risk_object';

    /**
     * Primary field name.
     *
     * @var string
     * @since 1.0.0
     */
    protected static $primaryField = 'riskmngmt_risk_object_id';

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
