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
namespace Modules\Profile\Models;

use Modules\Media\Models\MediaMapper;
use phpOMS\DataStorage\Database\DataMapperAbstract;
use phpOMS\DataStorage\Database\Query\Builder;
use phpOMS\DataStorage\Database\Query\Column;
use phpOMS\DataStorage\Database\RelationType;
use Modules\Admin\Models\Account;
use Modules\Admin\Models\AccountMapper;
use Modules\Calendar\Models\CalendarMapper;

class ProfileMapper extends DataMapperAbstract
{
    /**
     * Columns.
     *
     * @var array
     * @since 1.0.0
     */
    protected static $columns = [
        'profile_account_id'         => ['name' => 'profile_account_id', 'type' => 'int', 'internal' => 'id'],
        'profile_account_image'         => ['name' => 'profile_account_image', 'type' => 'int', 'internal' => 'image'],
        'profile_account_birthday'         => ['name' => 'profile_account_birthday', 'type' => 'DateTime', 'internal' => 'birthday'],
        'profile_account_account'         => ['name' => 'profile_account_account', 'type' => 'int', 'internal' => 'account'],
        'profile_account_calendar'         => ['name' => 'profile_account_calendar', 'type' => 'int', 'internal' => 'calendar'],
    ];

    /**
     * Has one relation.
     *
     * @var array
     * @since 1.0.0
     */
    protected static $ownsOne = [
        'account' => [
            'mapper'         => AccountMapper::class,
            'src'            => 'profile_account_account',
        ],
        'image' => [
            'mapper'         => MediaMapper::class,
            'src'            => 'profile_account_image',
        ],
        'calendar' => [
            'mapper'         => CalendarMapper::class,
            'src'            => 'profile_account_calendar',
        ],
    ];

    /**
     * Has many relation.
     *
     * @var array
     * @since 1.0.0
     */
    protected static $hasMany = [
        'location' => [
            'mapper'         => AddressMapper::class,
            'table'          => 'profile_address',
            'dst'            => 'profile_address_account',
            'src'            => null,
        ],
    ];

    /**
     * Primary table.
     *
     * @var string
     * @since 1.0.0
     */
    protected static $table = 'profile_account';

    /**
     * Primary field name.
     *
     * @var string
     * @since 1.0.0
     */
    protected static $primaryField = 'profile_account_id';

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

    /**
     * Get object.
     *
     * @param mixed $primaryKey Key
     * @param int   $relations  Load relations
     * @param mixed $fill       Object to fill
     *
     * @return Account
     *
     * @since  1.0.0
     */
    public static function get($primaryKey, int $relations = RelationType::ALL, $fill = null)
    {
        return parent::get($primaryKey, $relations, $fill);
    }
}
