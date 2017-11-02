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
namespace Modules\Admin\Models;

use phpOMS\DataStorage\Database\DataMapperAbstract;
use phpOMS\DataStorage\Database\RelationType;

class GroupMapper extends DataMapperAbstract
{

    /**
     * Columns.
     *
     * @var array
     * @since 1.0.0
     */
    protected static $columns = [
        'group_id'      => ['name' => 'group_id', 'type' => 'int', 'internal' => 'id'],
        'group_name'    => ['name' => 'group_name', 'type' => 'string', 'internal' => 'name'],
        'group_status'    => ['name' => 'group_status', 'type' => 'int', 'internal' => 'status'],
        'group_desc'    => ['name' => 'group_desc', 'type' => 'string', 'internal' => 'description'],
        'group_created' => ['name' => 'group_created', 'type' => 'DateTime', 'internal' => 'createdAt'],
    ];

    /**
     * Primary table.
     *
     * @var string
     * @since 1.0.0
     */
    protected static $table = 'group';

    /**
     * Primary field name.
     *
     * @var string
     * @since 1.0.0
     */
    protected static $primaryField = 'group_id';

    /**
     * Created at column
     *
     * @var string
     * @since 1.0.0
     */
    protected static $createdAt = 'group_created';

    /**
     * Get object.
     *
     * @param mixed $primaryKey Key
     * @param int   $relations  Load relations
     * @param mixed $fill       Object to fill
     *
     * @return Group
     *
     * @since  1.0.0
     */
    public static function get($primaryKey, int $relations = RelationType::ALL, $fill = null)
    {
        return parent::get($primaryKey, $relations, $fill);
    }
}
