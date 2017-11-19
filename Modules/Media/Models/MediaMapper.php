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
namespace Modules\Media\Models;

use phpOMS\DataStorage\Database\DataMapperAbstract;
use phpOMS\DataStorage\Database\Query\Builder;
use phpOMS\DataStorage\Database\Query\Column;
use phpOMS\DataStorage\Database\RelationType;
use Modules\Admin\Models\AccountMapper;

class MediaMapper extends DataMapperAbstract
{

    /**
     * Columns.
     *
     * @var array
     * @since 1.0.0
     */
    protected static $columns = [
        'media_id'          => ['name' => 'media_id', 'type' => 'int', 'internal' => 'id'],
        'media_name'        => ['name' => 'media_name', 'type' => 'string', 'internal' => 'name'],
        'media_description'        => ['name' => 'media_description', 'type' => 'string', 'internal' => 'description'],
        'media_versioned'   => ['name' => 'media_versioned', 'type' => 'bool', 'internal' => 'versioned'],
        'media_file'        => ['name' => 'media_file', 'type' => 'string', 'internal' => 'path'],
        'media_absolute'        => ['name' => 'media_absolute', 'type' => 'bool', 'internal' => 'isAbsolute'],
        'media_extension'   => ['name' => 'media_extension', 'type' => 'string', 'internal' => 'extension'],
        'media_size'        => ['name' => 'media_size', 'type' => 'int', 'internal' => 'size'],
        'media_created_by'  => ['name' => 'media_created_by', 'type' => 'int', 'internal' => 'createdBy'],
        'media_created_at'  => ['name' => 'media_created_at', 'type' => 'DateTime', 'internal' => 'createdAt'],
    ];

    protected static $belongsTo = [
        'createdBy' => [
            'mapper'         => AccountMapper::class,
            'dest'            => 'media_created_by',
        ],
    ];

    /**
     * Primary table.
     *
     * @var string
     * @since 1.0.0
     */
    protected static $table = 'media';

    /**
     * Created at.
     *
     * @var string
     * @since 1.0.0
     */
    protected static $createdAt = 'media_created_at';

    /**
     * Primary field name.
     *
     * @var string
     * @since 1.0.0
     */
    protected static $primaryField = 'media_id';
}
