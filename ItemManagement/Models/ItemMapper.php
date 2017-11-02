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
namespace Modules\ItemManagement\Models;

use Modules\Media\Models\MediaMapper;
use Modules\Profile\Models\ContactElement;
use Modules\Profile\Models\ContactElementMapper;
use Modules\Profile\Models\ContactMapper;
use phpOMS\DataStorage\Database\DataMapperAbstract;
use phpOMS\DataStorage\Database\Query\Builder;
use phpOMS\DataStorage\Database\Query\Column;
use phpOMS\DataStorage\Database\RelationType;

class ItemMapper extends DataMapperAbstract
{
    /**
     * Columns.
     *
     * @var array
     * @since 1.0.0
     */
    protected static $columns = [
        'itemmgmt_item_id'         => ['name' => 'itemmgmt_item_id', 'type' => 'int', 'internal' => 'id'],
        'itemmgmt_item_no'     => ['name' => 'itemmgmt_item_no', 'type' => 'int', 'internal' => 'number'],
        'itemmgmt_item_segment'    => ['name' => 'itemmgmt_item_segment', 'type' => 'int', 'internal' => 'segment'],
        'itemmgmt_item_productgroup'    => ['name' => 'itemmgmt_item_productgroup', 'type' => 'int', 'internal' => 'productGroup'],
        'itemmgmt_item_salesgroup'      => ['name' => 'itemmgmt_item_salesgroup', 'type' => 'int', 'internal' => 'salesGroup'],
        'itemmgmt_item_articlegroup'      => ['name' => 'itemmgmt_item_articlegroup', 'type' => 'int', 'internal' => 'articleGroup'],
        'itemmgmt_item_successor' => ['name' => 'itemmgmt_item_successor', 'type' => 'int', 'internal' => 'successor'],
        'itemmgmt_item_info' => ['name' => 'itemmgmt_item_info', 'type' => 'string', 'internal' => 'info'],
    ];

    /**
     * Primary table.
     *
     * @var string
     * @since 1.0.0
     */
    protected static $table = 'itemmgmt_item';

    /**
     * Primary field name.
     *
     * @var string
     * @since 1.0.0
     */
    protected static $primaryField = 'itemmgmt_item_id';

    protected static $hasMany = [
        'media' => [
            'mapper'         => MediaMapper::class, /* mapper of the related object */
            'table'          => 'itemmgmt_item_media', /* table of the related object, null if no relation table is used (many->1) */
            'dst'            => 'itemmgmt_item_media_dst',
            'src'            => 'itemmgmt_item_media_src',
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
