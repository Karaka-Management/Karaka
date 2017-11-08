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

class ProjectMapper extends DataMapperAbstract
{
    /**
     * Columns.
     *
     * @var array
     * @since 1.0.0
     */
    protected static $columns = [
        'riskmngmt_project_id'         => ['name' => 'riskmngmt_project_id', 'type' => 'int', 'internal' => 'id'],
        'riskmngmt_project_project'     => ['name' => 'riskmngmt_project_project', 'type' => 'int', 'internal' => 'project'],
        'riskmngmt_project_responsible'     => ['name' => 'riskmngmt_project_responsible', 'type' => 'int', 'internal' => 'responsible'],
        'riskmngmt_project_deputy'     => ['name' => 'riskmngmt_project_deputy', 'type' => 'int', 'internal' => 'deputy'],
    ];

    /**
     * Primary table.
     *
     * @var string
     * @since 1.0.0
     */
    protected static $table = 'riskmngmt_project';

    /**
     * Primary field name.
     *
     * @var string
     * @since 1.0.0
     */
    protected static $primaryField = 'riskmngmt_project_id';

    /**
     * Has one relation.
     *
     * @var array
     * @since 1.0.0
     */
    protected static $belongsTo = [
        'project' => [
            'mapper' => \Modules\ProjectManagement\Models\ProjectMapper::class,
            'dest'    => 'riskmngmt_project_project',
        ],
    ];

}
