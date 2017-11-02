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
namespace Modules\Reporter\Models;

use Modules\Admin\Models\AccountMapper;
use phpOMS\DataStorage\Database\DataMapperAbstract;
use phpOMS\DataStorage\Database\Query\Builder;
use phpOMS\DataStorage\Database\Query\Column;
use phpOMS\DataStorage\Database\RelationType;

class ReportMapper extends DataMapperAbstract
{

    /**
     * Columns.
     *
     * @var array
     * @since 1.0.0
     */
    static protected $columns = [
        'reporter_report_id'       => ['name' => 'reporter_report_id', 'type' => 'int', 'internal' => 'id'],
        'reporter_report_status'   => ['name' => 'reporter_report_status', 'type' => 'int', 'internal' => 'status'],
        'reporter_report_title'    => ['name' => 'reporter_report_title', 'type' => 'string', 'internal' => 'title'],
        'reporter_report_desc'     => ['name'     => 'reporter_report_desc', 'type' => 'string',
                                       'internal' => 'description'],
        'reporter_report_media'    => ['name' => 'reporter_report_media', 'type' => 'int', 'internal' => 'source'],
        'reporter_report_template' => ['name' => 'reporter_report_template', 'type' => 'int', 'internal' => 'template'],
        'reporter_report_creator'  => ['name' => 'reporter_report_creator', 'type' => 'int', 'internal' => 'createdBy'],
        'reporter_report_created'  => ['name'     => 'reporter_report_created', 'type' => 'DateTime',
                                       'internal' => 'createdAt'],
    ];

    /**
     * Has one relation.
     *
     * @var array
     * @since 1.0.0
     */
    protected static $ownsOne = [
        'source' => [
            'mapper' => \Modules\Media\Models\CollectionMapper::class,
            'src'    => 'reporter_report_media',
        ],
        'template' => [
            'mapper' => \Modules\Reporter\Models\TemplateMapper::class,
            'src'    => 'reporter_report_template',
        ]
    ];

    static protected $belongsTo = [
        'createdBy' => [
            'mapper' => AccountMapper::class,
            'src'    => 'reporter_report_creator',
        ],
    ];

    /**
     * Primary table.
     *
     * @var string
     * @since 1.0.0
     */
    protected static $table = 'reporter_report';

    /**
     * Primary field name.
     *
     * @var string
     * @since 1.0.0
     */
    protected static $primaryField = 'reporter_report_id';

    /**
     * Created at.
     *
     * @var string
     * @since 1.0.0
     */
    protected static $createdAt = 'reporter_report_created';

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
            echo $e->getMessage();

            return false;
        }

        return $objId;
    }

}
