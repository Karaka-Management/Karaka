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
namespace Tests\PHPUnit\phpOMS\DataStorage\Database\TestModel;

require_once __DIR__ . '/../../../../../../phpOMS/Autoloader.php';

use phpOMS\DataStorage\Database\DataMapperAbstract;
use phpOMS\DataStorage\Database\Query\Builder;
use phpOMS\DataStorage\Database\Query\Column;
use phpOMS\DataStorage\Database\RelationType;

class BelongsToModelMapper extends DataMapperAbstract
{

    /**
     * Columns.
     *
     * @var array
     * @since 1.0.0
     */
    protected static $columns = [
        'test_belongs_to_one_id'          => ['name' => 'test_belongs_to_one_id', 'type' => 'int', 'internal' => 'id'],
        'test_belongs_to_one_string'        => ['name' => 'test_belongs_to_one_string', 'type' => 'string', 'internal' => 'string'],
    ];

    protected static $table = 'test_belongs_to_one';

    protected static $primaryField = 'test_belongs_to_one_id';
}
