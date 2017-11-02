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

namespace phpOMS\Module;

use phpOMS\DataStorage\Database\DatabaseType;
use phpOMS\DataStorage\Database\DatabasePool;

/**
 * Installer Abstract class.
 *
 * @category   Framework
 * @package    phpOMS\Module
 * @license    OMS License 1.0
 * @link       http://orange-management.com
 * @since      1.0.0
 */
class DeactivateAbstract
{

    /**
     * Deactivate module.
     *
     * @param DatabasePool        $dbPool Database instance
     * @param InfoManager $info   Module info
     *
     * @return void
     *
     * @since  1.0.0
     */
    public static function deactivate(DatabasePool $dbPool, InfoManager $info) /* : void */
    {
        self::deactivateRoutes(__DIR__ . '/../../Web/Routes.php', __DIR__ . '/../../Modules/' . $info->getDirectory() . '/Admin/Routes/http.php');
        self::deactivateInDatabase($dbPool, $info);
    }

    /**
     * Install routes.
     *
     * @param string $destRoutePath Destination route path
     * @param string $srcRoutePath  Source route path
     *
     * @return void
     *
     * @since  1.0.0
     */
    private static function deactivateRoutes(string $destRoutePath, string $srcRoutePath) /* : void */
    {
        // todo: remove route
    }

    /**
     * Deactivate module in database.
     *
     * @param DatabasePool        $dbPool Database instance
     * @param InfoManager $info   Module info
     *
     * @return void
     *
     * @since  1.0.0
     */
    public static function deactivateInDatabase(DatabasePool $dbPool, InfoManager $info) /* : void */
    {
        switch ($dbPool->get()->getType()) {
            case DatabaseType::MYSQL:
                $dbPool->get()->con->beginTransaction();

                $sth = $dbPool->get()->con->prepare(
                    'UPDATE `' . $dbPool->get()->prefix . 'module` SET `module_active` = :active WHERE `module_id` = :internal;'
                );

                $sth->bindValue(':internal', $info->getInternalName(), \PDO::PARAM_INT);
                $sth->bindValue(':active', 0, \PDO::PARAM_INT);
                $sth->execute();

                $dbPool->get()->con->commit();

                break;
        }
    }
}
