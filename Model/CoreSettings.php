<?php
/**
 * Orange Management
 *
 * PHP Version 7.2
 *
 * @package    Model
 * @copyright  Dennis Eichhorn
 * @license    OMS License 1.0
 * @version    1.0.0
 * @link       http://website.orange-management.de
 */
declare(strict_types=1);

namespace Model;

use phpOMS\Config\SettingsAbstract;
use phpOMS\DataStorage\Database\Connection\ConnectionAbstract;

/**
 * Core settings class.
 *
 * This is used in order to manage global Framework and Module settings
 *
 * @package    Model
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
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
