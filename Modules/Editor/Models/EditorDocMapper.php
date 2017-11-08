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
namespace Modules\Editor\Models;

use Modules\Admin\Models\AccountMapper;
use phpOMS\DataStorage\Database\DataMapperAbstract;
use phpOMS\DataStorage\Database\Query\Builder;
use phpOMS\DataStorage\Database\Query\Column;
use phpOMS\DataStorage\Database\RelationType;

class EditorDocMapper extends DataMapperAbstract
{

    /**
     * Columns.
     *
     * @var array
     * @since 1.0.0
     */
    static protected $columns = [
        'editor_doc_id'         => ['name' => 'editor_doc_id', 'type' => 'int', 'internal' => 'id'],
        'editor_doc_created_by' => ['name' => 'editor_doc_created_by', 'type' => 'int', 'internal' => 'createdBy'],
        'editor_doc_title'      => ['name' => 'editor_doc_title', 'type' => 'string', 'internal' => 'title'],
        'editor_doc_plain'    => ['name' => 'editor_doc_plain', 'type' => 'string', 'internal' => 'plain'],
        'editor_doc_content'    => ['name' => 'editor_doc_content', 'type' => 'string', 'internal' => 'content'],
        'editor_doc_path'       => ['name' => 'editor_doc_path', 'type' => 'string', 'internal' => 'path'],
        'editor_doc_created_at' => ['name' => 'editor_doc_created_at', 'type' => 'DateTime', 'internal' => 'createdAt'],
    ];

    static protected $belongsTo = [
        'createdBy' => [
            'mapper' => AccountMapper::class,
            'src'    => 'editor_doc_created_by',
        ],
    ];

    /**
     * Primary table.
     *
     * @var string
     * @since 1.0.0
     */
    protected static $table = 'editor_doc';

    /**
     * Primary field name.
     *
     * @var string
     * @since 1.0.0
     */
    protected static $primaryField = 'editor_doc_id';

    /**
     * Created at.
     *
     * @var string
     * @since 1.0.0
     */
    protected static $createdAt = 'editor_doc_created_at';
}
