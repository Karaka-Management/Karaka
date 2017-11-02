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

class ModuleMapper extends DataMapperAbstract
{

    /**
     * Columns.
     *
     * @var array
     * @since 1.0.0
     */
    protected static $columns = [
        'module_id'      => ['name' => 'module_id', 'type' => 'string', 'internal' => 'id'],
        'module_active'    => ['name' => 'module_active', 'type' => 'int', 'internal' => 'status'],
    ];

    /**
     * Primary table.
     *
     * @var string
     * @since 1.0.0
     */
    protected static $table = 'module';

    /**
     * Primary field name.
     *
     * @var string
     * @since 1.0.0
     */
    protected static $primaryField = 'module_id';

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
