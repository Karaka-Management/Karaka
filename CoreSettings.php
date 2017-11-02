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

namespace Model;

use phpOMS\Config\SettingsAbstract;
use phpOMS\DataStorage\Database\Connection\ConnectionAbstract;

/**
 * Core settings class.
 *
 * This is used in order to manage global Framework and Module settings
 *
 * @category   Modules
 * @package    Model
 * @since      1.0.0
 *
 * @todo       : maybe move this \Web
 */
class CoreSettings extends SettingsAbstract
{

    /**
     * Settings table.
     *
     * @var string
     * @since 1.0.0
     */
    protected static $table = 'settings';

    /**
     * Columns.
     *
     * @var string[]
     * @since 1.0.0
     */
    protected static $columns = [
        'settings_id',
        'settings_content',
    ];

    /**
     * Constructor.
     *
     * @param ConnectionAbstract $connection Database connection
     *
     * @since  1.0.0
     */
    public function __construct(ConnectionAbstract $connection)
    {
        $this->connection = $connection;
    }
}
