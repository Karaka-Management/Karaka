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
namespace Modules\Auditor\Models;

use Modules\Admin\Models\AccountMapper;
use phpOMS\DataStorage\Database\DataMapperAbstract;
use phpOMS\DataStorage\Database\Query\Builder;
use phpOMS\DataStorage\Database\Query\Column;
use phpOMS\DataStorage\Database\RelationType;

class AuditMapper extends DataMapperAbstract
{

    /**
     * Columns.
     *
     * @var array
     * @since 1.0.0
     */
    static protected $columns = [
        'auditor_audit_id'         => ['name' => 'auditor_audit_id', 'type' => 'int', 'internal' => 'id'],
        'auditor_audit_created_by' => ['name' => 'auditor_audit_created_by', 'type' => 'int', 'internal' => 'createdBy'],
        'auditor_audit_created_at' => ['name' => 'auditor_audit_created_at', 'type' => 'DateTime', 'internal' => 'createdAt'],
        'auditor_audit_ip'    => ['name' => 'auditor_audit_ip', 'type' => 'int', 'internal' => 'ip'],
        'auditor_audit_module'    => ['name' => 'auditor_audit_module', 'type' => 'int', 'internal' => 'module'],
        'auditor_audit_ref'    => ['name' => 'auditor_audit_ref', 'type' => 'string', 'internal' => 'ref'],
        'auditor_audit_type'    => ['name' => 'auditor_audit_type', 'type' => 'int', 'internal' => 'type'],
        'auditor_audit_subtype'    => ['name' => 'auditor_audit_subtype', 'type' => 'int', 'internal' => 'subtype'],
        'auditor_audit_content'    => ['name' => 'auditor_audit_content', 'type' => 'string', 'internal' => 'content'],
        'auditor_audit_old'    => ['name' => 'auditor_audit_old', 'type' => 'string', 'internal' => 'old'],
        'auditor_audit_new'    => ['name' => 'auditor_audit_new', 'type' => 'string', 'internal' => 'new'],
    ];

    static protected $belongsTo = [
        'createdBy' => [
            'mapper' => AccountMapper::class,
            'src'    => 'auditor_audit_created_by',
        ],
    ];

    /**
     * Primary table.
     *
     * @var string
     * @since 1.0.0
     */
    protected static $table = 'auditor_audit';

    /**
     * Primary field name.
     *
     * @var string
     * @since 1.0.0
     */
    protected static $primaryField = 'auditor_audit';

    /**
     * Created at.
     *
     * @var string
     * @since 1.0.0
     */
    protected static $createdAt = 'auditor_audit_created_at';

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
