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
namespace Modules\News\Models;

use Modules\Admin\Models\AccountMapper;
use phpOMS\DataStorage\Database\DataMapperAbstract;
use phpOMS\DataStorage\Database\Query\Builder;
use phpOMS\DataStorage\Database\Query\Column;
use phpOMS\DataStorage\Database\RelationType;

class NewsArticleMapper extends DataMapperAbstract
{

    /**
     * Columns.
     *
     * @var array
     * @since 1.0.0
     */
    static protected $columns = [
        'news_id'         => ['name' => 'news_id', 'type' => 'int', 'internal' => 'id'],
        'news_created_by' => ['name' => 'news_created_by', 'type' => 'int', 'internal' => 'createdBy'],
        'news_publish'    => ['name' => 'news_publish', 'type' => 'DateTime', 'internal' => 'publish'],
        'news_title'      => ['name' => 'news_title', 'type' => 'string', 'internal' => 'title'],
        'news_plain'    => ['name' => 'news_plain', 'type' => 'string', 'internal' => 'plain'],
        'news_content'    => ['name' => 'news_content', 'type' => 'string', 'internal' => 'content'],
        'news_lang'       => ['name' => 'news_lang', 'type' => 'string', 'internal' => 'language'],
        'news_status'     => ['name' => 'news_status', 'type' => 'int', 'internal' => 'status'],
        'news_type'       => ['name' => 'news_type', 'type' => 'int', 'internal' => 'type'],
        'news_featured'   => ['name' => 'news_featured', 'type' => 'bool', 'internal' => 'featured'],
        'news_created_at' => ['name' => 'news_created_at', 'type' => 'DateTime', 'internal' => 'createdAt'],
    ];

    static protected $belongsTo = [
        'createdBy' => [
            'mapper' => AccountMapper::class,
            'src'    => 'news_created_by',
        ],
    ];

    /**
     * Primary table.
     *
     * @var string
     * @since 1.0.0
     */
    protected static $table = 'news';

    /**
     * Primary field name.
     *
     * @var string
     * @since 1.0.0
     */
    protected static $primaryField = 'news_id';

    /**
     * Created at.
     *
     * @var string
     * @since 1.0.0
     */
    protected static $createdAt = 'news_created_at';

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
