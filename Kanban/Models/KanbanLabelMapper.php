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
namespace Modules\Kanban\Models;

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
class KanbanLabelMapper extends DataMapperAbstract
{

    /**
     * Columns.
     *
     * @var array
     * @since 1.0.0
     */
    protected static $columns = [
        'kanban_label_id'      => ['name' => 'kanban_label_id', 'type' => 'int', 'internal' => 'id'],
        'kanban_label_name'   => ['name' => 'kanban_label_name', 'type' => 'string', 'internal' => 'name'],
        'kanban_label_color'    => ['name' => 'kanban_label_color', 'type' => 'int', 'internal' => 'color'],
        'kanban_label_board'  => ['name' => 'kanban_label_board', 'type' => 'int', 'internal' => 'board'],
    ];

    /**
     * Primary table.
     *
     * @var string
     * @since 1.0.0
     */
    protected static $table = 'kanban_label';

    /**
     * Primary field name.
     *
     * @var string
     * @since 1.0.0
     */
    protected static $primaryField = 'kanban_label_id';

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
