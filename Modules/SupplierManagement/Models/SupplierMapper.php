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
namespace Modules\SupplierManagement\Models;

use Modules\Media\Models\MediaMapper;
use Modules\Profile\Models\ProfileMapper;
use Modules\Profile\Models\ContactElement;
use Modules\Profile\Models\ContactElementMapper;
use Modules\Profile\Models\ContactMapper;
use phpOMS\DataStorage\Database\DataMapperAbstract;
use phpOMS\DataStorage\Database\Query\Builder;
use phpOMS\DataStorage\Database\Query\Column;
use phpOMS\DataStorage\Database\RelationType;

class SupplierMapper extends DataMapperAbstract
{
    /**
     * Columns.
     *
     * @var array
     * @since 1.0.0
     */
    protected static $columns = [
        'suppliermgmt_supplier_id'         => ['name' => 'suppliermgmt_supplier_id', 'type' => 'int', 'internal' => 'id'],
        'suppliermgmt_supplier_no'     => ['name' => 'suppliermgmt_supplier_no', 'type' => 'int', 'internal' => 'number'],
        'suppliermgmt_supplier_no_reverse'       => ['name' => 'suppliermgmt_supplier_no_reverse', 'type' => 'string', 'internal' => 'numberReverse'],
        'suppliermgmt_supplier_status'    => ['name' => 'suppliermgmt_supplier_status', 'type' => 'int', 'internal' => 'status'],
        'suppliermgmt_supplier_type'    => ['name' => 'suppliermgmt_supplier_type', 'type' => 'int', 'internal' => 'type'],
        'suppliermgmt_supplier_taxid'      => ['name' => 'suppliermgmt_supplier_taxid', 'type' => 'string', 'internal' => 'taxId'],
        'suppliermgmt_supplier_info'      => ['name' => 'suppliermgmt_supplier_info', 'type' => 'string', 'internal' => 'info'],
        'suppliermgmt_supplier_created_at' => ['name' => 'suppliermgmt_supplier_created_at', 'type' => 'DateTime', 'internal' => 'createdAt'],
        'suppliermgmt_supplier_account' => ['name' => 'suppliermgmt_supplier_account', 'type' => 'int', 'internal' => 'profile'],
    ];

    /**
     * Primary table.
     *
     * @var string
     * @since 1.0.0
     */
    protected static $table = 'suppliermgmt_supplier';

    /**
     * Primary field name.
     *
     * @var string
     * @since 1.0.0
     */
    protected static $primaryField = 'suppliermgmt_supplier_id';

    /**
     * Created at column
     *
     * @var string
     * @since 1.0.0
     */
    protected static $createdAt = 'suppliermgmt_supplier_created_at';

    /**
     * Has one relation.
     *
     * @var array
     * @since 1.0.0
     */
    protected static $ownsOne = [
        'profile' => [
            'mapper'         => ProfileMapper::class,
            'src'            => 'suppliermgmt_supplier_account',
        ],
    ];

    protected static $hasMany = [
        'files' => [
            'mapper'         => MediaMapper::class, /* mapper of the related object */
            'table'          => 'suppliermgmt_supplier_media', /* table of the related object, null if no relation table is used (many->1) */
            'dst'            => 'suppliermgmt_supplier_media_dst',
            'src'            => 'suppliermgmt_supplier_media_src',
        ],
        'contactElements' => [
            'mapper'         => ContactElementMapper::class,
            'table'          => 'suppliermgmt_supplier_contactelement',
            'dst'            => 'suppliermgmt_supplier_contactelement_dst',
            'src'            => 'suppliermgmt_supplier_contactelement_src',
        ],
    ];

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

    /**
     * Get object.
     *
     * @param mixed $primaryKey Key
     * @param int   $relations  Load relations
     * @param mixed $fill       Object to fill
     *
     * @return supplier
     *
     * @since  1.0.0
     */
    public static function get($primaryKey, int $relations = RelationType::ALL, $fill = null)
    {
        return parent::get($primaryKey, $relations, $fill);
    }
}
