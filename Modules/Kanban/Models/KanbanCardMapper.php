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
use Modules\Media\Models\MediaMapper;
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
class KanbanCardMapper extends DataMapperAbstract
{

    /**
     * Columns.
     *
     * @var array
     * @since 1.0.0
     */
    protected static $columns = [
        'kanban_card_id'      => ['name' => 'kanban_card_id', 'type' => 'int', 'internal' => 'id'],
        'kanban_card_name'   => ['name' => 'kanban_card_name', 'type' => 'string', 'internal' => 'name'],
        'kanban_card_description'   => ['name' => 'kanban_card_description', 'type' => 'string', 'internal' => 'description'],
        'kanban_card_type'    => ['name' => 'kanban_card_type', 'type' => 'int', 'internal' => 'type'],
        'kanban_card_status'    => ['name' => 'kanban_card_status', 'type' => 'int', 'internal' => 'status'],
        'kanban_card_order'    => ['name' => 'kanban_card_order', 'type' => 'int', 'internal' => 'order'],
        'kanban_card_ref'    => ['name' => 'kanban_card_ref', 'type' => 'int', 'internal' => 'ref'],
        'kanban_card_column'    => ['name' => 'kanban_card_column', 'type' => 'int', 'internal' => 'column'],
        'kanban_card_created_at'  => ['name' => 'kanban_card_created_at', 'type' => 'DateTime', 'internal' => 'createdAt'],
        'kanban_card_created_by'  => ['name' => 'kanban_card_created_by', 'type' => 'int', 'internal' => 'createdBy'],
    ];

    static protected $belongsTo = [
        'createdBy' => [
            'mapper' => AccountMapper::class,
            'src'    => 'kanban_card_created_by',
        ],
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
            'table'          => 'kanban_card_media',
            'dst'            => 'kanban_card_media_dst',
            'src'            => 'kanban_card_media_src',
        ],
        'labels' => [
            'mapper'         => KanbanLabelMapper::class,
            'table'          => 'kanban_label_relation',
            'dst'            => 'kanban_label_relation_card',
            'src'            => 'kanban_label_relation_label',
        ],
        'comments' => [
            'mapper'         => KanbanCardCommentMapper::class,
            'table'          => 'kanban_card_comment',
            'dst'            => 'kanban_card_comment_card',
            'src'            => null,
        ],
    ];

    /**
     * Primary table.
     *
     * @var string
     * @since 1.0.0
     */
    protected static $table = 'kanban_card';

    /**
     * Created at.
     *
     * @var string
     * @since 1.0.0
     */
    protected static $createdAt = 'kanban_card_created_at';

    /**
     * Primary field name.
     *
     * @var string
     * @since 1.0.0
     */
    protected static $primaryField = 'kanban_card_id';

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
