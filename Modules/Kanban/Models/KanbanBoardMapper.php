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
namespace Modules\Kanban\Models;

use phpOMS\DataStorage\Database\DataMapperAbstract;
use phpOMS\DataStorage\Database\Query\Builder;
use phpOMS\DataStorage\Database\Query\Column;
use phpOMS\DataStorage\Database\RelationType;
use Modules\Admin\Models\AccountMapper;

/**
 * Mapper class.
 *
 * @category   Tasks
 * @package    Modules
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
class KanbanBoardMapper extends DataMapperAbstract
{

    /**
     * Columns.
     *
     * @var array
     * @since 1.0.0
     */
    protected static $columns = [
        'kanban_board_id'      => ['name' => 'kanban_board_id', 'type' => 'int', 'internal' => 'id'],
        'kanban_board_name'   => ['name' => 'kanban_board_name', 'type' => 'string', 'internal' => 'name'],
        'kanban_board_desc'    => ['name' => 'kanban_board_desc', 'type' => 'string', 'internal' => 'description'],
        'kanban_board_status'  => ['name' => 'kanban_board_status', 'type' => 'int', 'internal' => 'status'],
        'kanban_board_order'  => ['name' => 'kanban_board_order', 'type' => 'int', 'internal' => 'order'],
        'kanban_board_created_by' => ['name' => 'kanban_board_created_by', 'type' => 'int', 'internal' => 'createdBy'],
        'kanban_board_created_at' => ['name' => 'kanban_board_created_at', 'type' => 'DateTime', 'internal' => 'createdAt'],
    ];

    /**
     * Has many relation.
     *
     * @var array
     * @since 1.0.0
     */
    protected static $hasMany = [
        'columns' => [
            'mapper'         => KanbanColumnMapper::class,
            'table'          => 'kanban_column',
            'dst'            => 'kanban_column_board',
            'src'            => null,
        ],
    ];

    static protected $belongsTo = [
        'createdBy' => [
            'mapper' => AccountMapper::class,
            'src'    => 'kanban_board_created_by',
        ],
    ];

    /**
     * Primary table.
     *
     * @var string
     * @since 1.0.0
     */
    protected static $table = 'kanban_board';

    /**
     * Created at.
     *
     * @var string
     * @since 1.0.0
     */
    protected static $createdAt = 'kanban_board_created_at';

    /**
     * Primary field name.
     *
     * @var string
     * @since 1.0.0
     */
    protected static $primaryField = 'kanban_board_id';

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

}
