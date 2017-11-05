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
namespace Modules\ClientManagement\Models;

use Modules\Media\Models\MediaMapper;
use Modules\Profile\Models\ProfileMapper;
use Modules\Profile\Models\ContactElement;
use Modules\Profile\Models\ContactElementMapper;
use Modules\Profile\Models\ContactMapper;
use phpOMS\DataStorage\Database\DataMapperAbstract;
use phpOMS\DataStorage\Database\Query\Builder;
use phpOMS\DataStorage\Database\Query\Column;
use phpOMS\DataStorage\Database\RelationType;

class ClientMapper extends DataMapperAbstract
{
    /**
     * Columns.
     *
     * @var array
     * @since 1.0.0
     */
    protected static $columns = [
        'clientmgmt_client_id'         => ['name' => 'clientmgmt_client_id', 'type' => 'int', 'internal' => 'id'],
        'clientmgmt_client_no'     => ['name' => 'clientmgmt_client_no', 'type' => 'int', 'internal' => 'number'],
        'clientmgmt_client_no_reverse'       => ['name' => 'clientmgmt_client_no_reverse', 'type' => 'string', 'internal' => 'numberReverse'],
        'clientmgmt_client_status'    => ['name' => 'clientmgmt_client_status', 'type' => 'int', 'internal' => 'status'],
        'clientmgmt_client_type'    => ['name' => 'clientmgmt_client_type', 'type' => 'int', 'internal' => 'type'],
        'clientmgmt_client_taxid'      => ['name' => 'clientmgmt_client_taxid', 'type' => 'string', 'internal' => 'taxId'],
        'clientmgmt_client_info'      => ['name' => 'clientmgmt_client_info', 'type' => 'string', 'internal' => 'info'],
        'clientmgmt_client_created_at' => ['name' => 'clientmgmt_client_created_at', 'type' => 'DateTime', 'internal' => 'createdAt'],
        'clientmgmt_client_account' => ['name' => 'clientmgmt_client_account', 'type' => 'int', 'internal' => 'profile'],
    ];

    /**
     * Primary table.
     *
     * @var string
     * @since 1.0.0
     */
    protected static $table = 'clientmgmt_client';

    /**
     * Primary field name.
     *
     * @var string
     * @since 1.0.0
     */
    protected static $primaryField = 'clientmgmt_client_id';

    /**
     * Created at column
     *
     * @var string
     * @since 1.0.0
     */
    protected static $createdAt = 'clientmgmt_client_created_at';

    /**
     * Has one relation.
     *
     * @var array
     * @since 1.0.0
     */
    protected static $ownsOne = [
        'profile' => [
            'mapper'         => ProfileMapper::class,
            'src'            => 'clientmgmt_client_account',
        ],
    ];

    protected static $hasMany = [
        'files' => [
            'mapper'         => MediaMapper::class, /* mapper of the related object */
            'table'          => 'clientmgmt_client_media', /* table of the related object, null if no relation table is used (many->1) */
            'dst'            => 'clientmgmt_client_media_dst',
            'src'            => 'clientmgmt_client_media_src',
        ],
        'contactElements' => [
            'mapper'         => ContactElementMapper::class,
            'table'          => 'clientmgmt_client_contactelement',
            'dst'            => 'clientmgmt_client_contactelement_dst',
            'src'            => 'clientmgmt_client_contactelement_src',
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
     * @return Client
     *
     * @since  1.0.0
     */
    public static function get($primaryKey, int $relations = RelationType::ALL, $fill = null)
    {
        return parent::get($primaryKey, $relations, $fill);
    }
}
