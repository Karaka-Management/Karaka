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
 * @link       http://orange-management.com
 */
declare(strict_types = 1);
namespace Modules\Comments\Models;

use phpOMS\DataStorage\Database\DataMapperAbstract;
use phpOMS\DataStorage\Database\Query\Builder;
use phpOMS\DataStorage\Database\Query\Column;
use phpOMS\DataStorage\Database\RelationType;

/**
 * Mapper class.
 *
 * @category   Tasks
 * @package    Modules
 * @license    OMS License 1.0
 * @link       http://orange-management.com
 * @since      1.0.0
 */
class CommentMapper extends DataMapperAbstract
{

    /**
     * Columns.
     *
     * @var array
     * @since 1.0.0
     */
    protected static $columns = [
        'comments_comment_id'      => ['name' => 'comments_comment_id', 'type' => 'int', 'internal' => 'id'],
        'comments_comment_title'   => ['name' => 'comments_comment_title', 'type' => 'string', 'internal' => 'title'],
        'comments_comment_content'    => ['name' => 'comments_comment_content', 'type' => 'string', 'internal' => 'content'],
        'comments_comment_list'    => ['name' => 'comments_comment_list', 'type' => 'int', 'internal' => 'list'],
        'comments_comment_ref'    => ['name' => 'comments_comment_ref', 'type' => 'int', 'internal' => 'ref'],
        'comments_comment_created_by' => ['name' => 'comments_comment_created_by', 'type' => 'int', 'internal' => 'createdBy'],
        'comments_comment_created_at' => ['name' => 'comments_comment_created_at', 'type' => 'DateTime', 'internal' => 'createdAt'],
    ];

    /**
     * Primary table.
     *
     * @var string
     * @since 1.0.0
     */
    protected static $table = 'comments_comment';

    /**
     * Created at.
     *
     * @var string
     * @since 1.0.0
     */
    protected static $createdAt = 'comments_comment_created_at';

    /**
     * Primary field name.
     *
     * @var string
     * @since 1.0.0
     */
    protected static $primaryField = 'comments_comment_id';

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
