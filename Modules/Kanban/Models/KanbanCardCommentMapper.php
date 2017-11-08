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

/**
 * Mapper class.
 *
 * @category   Tasks
 * @package    Modules
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
class KanbanCardCommentMapper extends DataMapperAbstract
{

    /**
     * Columns.
     *
     * @var array
     * @since 1.0.0
     */
    protected static $columns = [
        'kanban_card_comment_id'      => ['name' => 'kanban_card_comment_id', 'type' => 'int', 'internal' => 'id'],
        'kanban_card_comment_description'   => ['name' => 'kanban_card_comment_description', 'type' => 'string', 'internal' => 'description'],
        'kanban_card_comment_card'    => ['name' => 'kanban_card_comment_card', 'type' => 'int', 'internal' => 'card'],
        'kanban_card_comment_created_at'  => ['name' => 'kanban_card_comment_created_at', 'type' => 'DateTime', 'internal' => 'createdAt'],
        'kanban_card_comment_created_by'  => ['name' => 'kanban_card_comment_created_by', 'type' => 'int', 'internal' => 'createdBy'],
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
            'table'          => 'kanban_card_comment_media',
            'dst'            => 'kanban_card_comment_media_dst',
            'src'            => 'kanban_card_comment_media_src',
        ],
    ];

    /**
     * Primary table.
     *
     * @var string
     * @since 1.0.0
     */
    protected static $table = 'kanban_card_comment';

    /**
     * Created at.
     *
     * @var string
     * @since 1.0.0
     */
    protected static $createdAt = 'kanban_card_comment_created_at';

    /**
     * Primary field name.
     *
     * @var string
     * @since 1.0.0
     */
    protected static $primaryField = 'kanban_card_comment_id';
}
