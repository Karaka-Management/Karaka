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

use Modules\Media\Models\MediaMapper;
use phpOMS\DataStorage\Database\Query\Builder;
use phpOMS\DataStorage\Database\Query\Column;

class CollectionMapper extends MediaMapper
{
    protected static $hasMany = [
        'sources' => [
            'mapper'         => MediaMapper::class, /* mapper of the related object */
            'table'          => 'media_relation', /* table of the related object, null if no relation table is used (many->1) */
            'dst'            => 'media_relation_dst',
            'src'            => 'media_relation_src',
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
