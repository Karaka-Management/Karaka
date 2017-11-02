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
namespace Modules\QA\Models;

use phpOMS\DataStorage\Database\DataMapperAbstract;
use phpOMS\DataStorage\Database\Query\Builder;
use phpOMS\DataStorage\Database\Query\Column;
use phpOMS\DataStorage\Database\RelationType;

/**
 * Mapper class.
 *
 * @category   QA
 * @package    Modules
 * @license    OMS License 1.0
 * @link       http://orange-management.com
 * @since      1.0.0
 */
class QAQuestionMapper extends DataMapperAbstract
{

    /**
     * Columns.
     *
     * @var array
     * @since 1.0.0
     */
    protected static $columns = [
        'qa_question_id'      => ['name' => 'qa_question_id', 'type' => 'int', 'internal' => 'id'],
        'qa_question_title'   => ['name' => 'qa_question_title', 'type' => 'string', 'internal' => 'name'],
        'qa_question_language'   => ['name' => 'qa_question_language', 'type' => 'string', 'internal' => 'language'],
        'qa_question_question'    => ['name' => 'qa_question_question', 'type' => 'string', 'internal' => 'question'],
        'qa_question_status'  => ['name' => 'qa_question_status', 'type' => 'int', 'internal' => 'status'],
        'qa_question_category'  => ['name' => 'qa_question_category', 'type' => 'int', 'internal' => 'category'],
        'qa_question_created_by' => ['name' => 'qa_question_created_by', 'type' => 'int', 'internal' => 'createdBy'],
        'qa_question_created_at' => ['name' => 'qa_question_created_at', 'type' => 'DateTime', 'internal' => 'createdAt'],
    ];

    /**
     * Has many relation.
     *
     * @var array
     * @since 1.0.0
     */
    protected static $hasMany = [
        'badges' => [
            'mapper'         => QABadgeMapper::class,
            'table'          => 'qa_question_badge',
            'src'            => 'qa_question_badge_badge',
            'dst'            => 'qa_question_badge_question',
        ],
        'answers' => [
            'mapper'         => QAAnswerMapper::class,
            'table'          => 'qa_answer',
            'dst'            => 'qa_answer_question',
            'src'            => null,
        ],
    ];

    /**
     * Has many relation.
     *
     * @var array
     * @since 1.0.0
     */
    protected static $ownsOne = [
        'category' => [
            'mapper'         => QACategoryMapper::class,
            'dst'            => 'qa_question_category',
        ],
    ];

    /**
     * Primary table.
     *
     * @var string
     * @since 1.0.0
     */
    protected static $table = 'qa_question';

    /**
     * Created at.
     *
     * @var string
     * @since 1.0.0
     */
    protected static $createdAt = 'qa_question_created_at';

    /**
     * Primary field name.
     *
     * @var string
     * @since 1.0.0
     */
    protected static $primaryField = 'qa_question_id';

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
