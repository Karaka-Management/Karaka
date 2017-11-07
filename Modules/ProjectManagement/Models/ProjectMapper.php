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
namespace Modules\ProjectManagement\Models;

use Modules\Calendar\Models\CalendarMapper;
use phpOMS\DataStorage\Database\DataMapperAbstract;
use phpOMS\DataStorage\Database\Query\Builder;
use phpOMS\DataStorage\Database\Query\Column;
use phpOMS\DataStorage\Database\RelationType;
use Modules\Tasks\Models\TaskMapper;
use Modules\Media\Models\MediaMapper;

/**
 * Mapper class.
 *
 * @category   Calendar
 * @package    Modules
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
class ProjectMapper extends DataMapperAbstract
{

    /**
     * Columns.
     *
     * @var array
     * @since 1.0.0
     */
    protected static $columns = [
        'projectmanagement_project_id'          => ['name' => 'projectmanagement_project_id', 'type' => 'int', 'internal' => 'id'],
        'projectmanagement_project_name'        => ['name' => 'projectmanagement_project_name', 'type' => 'string', 'internal' => 'name'],
        'projectmanagement_project_description' => ['name' => 'projectmanagement_project_description', 'type' => 'string', 'internal' => 'description'],
        'projectmanagement_project_calendar'    => ['name' => 'projectmanagement_project_calendar', 'type' => 'int', 'internal' => 'calendar'],
        'projectmanagement_project_costs'       => ['name' => 'projectmanagement_project_costs', 'type' => 'Serializable', 'internal' => 'costs'],
        'projectmanagement_project_budget'      => ['name' => 'projectmanagement_project_budget', 'type' => 'Serializable', 'internal' => 'budget'],
        'projectmanagement_project_earnings'    => ['name' => 'projectmanagement_project_earnings', 'type' => 'Serializable', 'internal' => 'earnings'],
        'projectmanagement_project_start'       => ['name' => 'projectmanagement_project_start', 'type' => 'DateTime', 'internal' => 'start'],
        'projectmanagement_project_end'         => ['name' => 'projectmanagement_project_end', 'type' => 'DateTime', 'internal' => 'end'],
        'projectmanagement_project_progress'         => ['name' => 'projectmanagement_project_progress', 'type' => 'int', 'internal' => 'progress'],
        'projectmanagement_project_progress_type'         => ['name' => 'projectmanagement_project_progress_type', 'type' => 'int', 'internal' => 'progressType'],
        'projectmanagement_project_created_by' => ['name' => 'projectmanagement_project_created_by', 'type' => 'int', 'internal' => 'createdBy'],
        'projectmanagement_project_created_at'  => ['name' => 'projectmanagement_project_created_at', 'type' => 'DateTime', 'internal' => 'createdAt'],
    ];

    /**
     * Has many relation.
     *
     * @var array
     * @since 1.0.0
     */
    protected static $hasMany = [
        'tasks' => [
            'mapper'         => TaskMapper::class,
            'table'          => 'projectmanagement_task_relation',
            'dst'            => 'projectmanagement_task_relation_dst',
            'src'            => 'projectmanagement_task_relation_src',
        ],
        'media' => [ // todo: maybe make this a has one and then link to collection instead of single media files!
            'mapper'         => MediaMapper::class,
            'table'          => 'projectmanagement_project_media',
            'dst'            => 'projectmanagement_project_media_src',
            'src'            => 'projectmanagement_project_media_dst',
        ],
    ];

    /**
     * Has one relation.
     *
     * @var array
     * @since 1.0.0
     */
    protected static $ownsOne = [
        'calendar' => [
            'mapper' => CalendarMapper::class,
            'src'    => 'projectmanagement_project_calendar',
        ],
    ];

    /**
     * Primary table.
     *
     * @var string
     * @since 1.0.0
     */
    protected static $table = 'projectmanagement_project';

    /**
     * Created at.
     *
     * @var string
     * @since 1.0.0
     */
    protected static $createdAt = 'projectmanagement_project_created_at';

    /**
     * Primary field name.
     *
     * @var string
     * @since 1.0.0
     */
    protected static $primaryField = 'projectmanagement_project_id';

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
}
