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

class SolutionMapper extends DataMapperAbstract
{
    /**
     * Columns.
     *
     * @var array
     * @since 1.0.0
     */
    protected static $columns = [
        'riskmngmt_solution_id'         => ['name' => 'riskmngmt_solution_id', 'type' => 'int', 'internal' => 'id'],
        'riskmngmt_solution_name'     => ['name' => 'riskmngmt_solution_name', 'type' => 'string', 'internal' => 'title'],
        'riskmngmt_solution_description'     => ['name' => 'riskmngmt_solution_description', 'type' => 'string', 'internal' => 'description'],
        'riskmngmt_solution_descriptionraw'     => ['name' => 'riskmngmt_solution_descriptionraw', 'type' => 'string', 'internal' => 'descriptionRaw'],
        'riskmngmt_solution_probability'     => ['name' => 'riskmngmt_solution_probability', 'type' => 'int', 'internal' => 'probability'],
        'riskmngmt_solution_cause'     => ['name' => 'riskmngmt_solution_cause', 'type' => 'int', 'internal' => 'cause'],
        'riskmngmt_solution_risk'     => ['name' => 'riskmngmt_solution_risk', 'type' => 'int', 'internal' => 'risk'],
    ];

    protected static $belongsTo = [
        'risk' => [
            'mapper'         => RiskMapper::class,
            'dest'            => 'riskmngmt_solution_risk',
        ],
        'cause' => [
            'mapper'         => CauseMapper::class,
            'dest'            => 'riskmngmt_solution_cause',
        ],
    ];

    /**
     * Primary table.
     *
     * @var string
     * @since 1.0.0
     */
    protected static $table = 'riskmngmt_solution';

    /**
     * Primary field name.
     *
     * @var string
     * @since 1.0.0
     */
    protected static $primaryField = 'riskmngmt_solution_id';

}
