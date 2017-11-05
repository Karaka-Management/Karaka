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
namespace Modules\HumanResourceManagement\Models;

use phpOMS\DataStorage\Database\DatabaseType;

/**
 * Staff list class.
 *
 * @category   Modules
 * @package    HumanResources
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
class StaffList
{

    /**
     * Database instance.
     *
     * @var \phpOMS\DataStorage\Database\Pool
     * @since 1.0.0
     */
    private $dbPool = null;

    /**
     * Constructor.
     *
     * @param \phpOMS\DataStorage\Database\DatabasePool $dbPool Database pool instance
     *
     * @since  1.0.0
     */
    public function __construct($dbPool)
    {
        $this->dbPool = $dbPool;
    }

    /**
     * Get all staff members.
     *
     * This function gets all accounts in a range
     *
     * @param array $filter Filter for search results
     * @param int  $offset Offset for first account
     * @param int  $limit  Limit for results
     *
     * @return array
     *
     * @since  1.0.0
     */
    public function getList($filter = null, $offset = 0, $limit = 100)
    {
        $result = null;

        switch ($this->dbPool->get()->getType()) {
            case DatabaseType::MYSQL:
                $search = $this->dbPool->get()->generate_sql_filter($filter, true);

                $sth = $this->dbPool->get()->con->prepare('SELECT
                            `' . $this->dbPool->get()->prefix . 'hr_staff`.*
                        FROM
                            `' . $this->dbPool->get()->prefix . 'hr_staff` '
                                                                . $search . 'LIMIT ' . $offset . ',' . $limit);
                $sth->execute();

                $result['list'] = $sth->fetchAll();

                $sth = $this->dbPool->get()->con->prepare('SELECT FOUND_ROWS();');
                $sth->execute();

                $result['count'] = $sth->fetchAll()[0][0];
                break;
        }

        return $result;
    }

    /**
     * Get task stats.
     *
     * @return array
     *
     * @since  1.0.0
     */
    public function getStats()
    {
    }
}
