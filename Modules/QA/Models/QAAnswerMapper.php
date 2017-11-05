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
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
class QAAnswerMapper extends DataMapperAbstract
{

    /**
     * Columns.
     *
     * @var array
     * @since 1.0.0
     */
    protected static $columns = [
        'qa_answer_id'      => ['name' => 'qa_answer_id', 'type' => 'int', 'internal' => 'id'],
        'qa_answer_answer'    => ['name' => 'qa_answer_answer', 'type' => 'string', 'internal' => 'answer'],
        'qa_answer_question'    => ['name' => 'qa_answer_question', 'type' => 'int', 'internal' => 'question'],
        'qa_answer_status'  => ['name' => 'qa_answer_status', 'type' => 'int', 'internal' => 'status'],
        'qa_answer_accepted'  => ['name' => 'qa_answer_accepted', 'type' => 'bool', 'internal' => 'isAccepted'],
        'qa_answer_created_by' => ['name' => 'qa_answer_created_by', 'type' => 'int', 'internal' => 'createdBy'],
        'qa_answer_created_at' => ['name' => 'qa_answer_created_at', 'type' => 'DateTime', 'internal' => 'createdAt'],
    ];

    /**
     * Primary table.
     *
     * @var string
     * @since 1.0.0
     */
    protected static $table = 'qa_answer';

    /**
     * Created at.
     *
     * @var string
     * @since 1.0.0
     */
    protected static $createdAt = 'qa_answer_created_at';

    /**
     * Primary field name.
     *
     * @var string
     * @since 1.0.0
     */
    protected static $primaryField = 'qa_answer_id';

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
