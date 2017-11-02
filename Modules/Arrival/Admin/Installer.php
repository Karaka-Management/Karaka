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
namespace Modules\Arrival\Admin;

use phpOMS\DataStorage\Database\DatabaseType;
use phpOMS\DataStorage\Database\DatabasePool;
use phpOMS\Module\InfoManager;
use phpOMS\Module\InstallerAbstract;

/**
 * Arrival install class.
 *
 * @category   Modules
 * @package    Modules\Admin
 * @license    OMS License 1.0
 * @link       http://orange-management.com
 * @since      1.0.0
 */
class Installer extends InstallerAbstract
{

    /**
     * {@inheritdoc}
     */
    public static function install(string $path, DatabasePool $dbPool, InfoManager $info)
    {
        parent::install(__DIR__ . '/..', $dbPool, $info);

        switch ($dbPool->get()->getType()) {
            case DatabaseType::MYSQL:
                $dbPool->get()->con->prepare(
                    'CREATE TABLE if NOT EXISTS `' . $dbPool->get()->prefix . 'arrival` (
                            `arrival_id` int(11) NOT NULL AUTO_INCREMENT,
                            `arrival_date` datetime NOT NULL,
                            `arrival_carrier` int(11) NOT NULL,
                            `arrival_responsible` int(11) NOT NULL,
                            `arrival_media` int(11) NOT NULL,
                            PRIMARY KEY (`arrival_id`),
                            KEY `arrival_carrier` (`arrival_carrier`),
                            KEY `arrival_responsible` (`arrival_responsible`)
                        )ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;'
                )->execute();

                $dbPool->get()->con->prepare(
                    'ALTER TABLE `' . $dbPool->get()->prefix . 'arrival`
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'arrival_ibfk_1` FOREIGN KEY (`arrival_carrier`) REFERENCES `' . $dbPool->get()->prefix . 'account` (`account_id`),
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'arrival_ibfk_2` FOREIGN KEY (`arrival_responsible`) REFERENCES `' . $dbPool->get()->prefix . 'account` (`account_id`);'
                )->execute();

                $dbPool->get()->con->prepare(
                    'CREATE TABLE if NOT EXISTS `' . $dbPool->get()->prefix . 'arrival_status` (
                            `arrival_status_id` int(11) NOT NULL AUTO_INCREMENT,
                            `arrival_status_amount` tinyint(1) NOT NULL,
                            `arrival_status_condition` tinyint(1) NOT NULL,
                            `arrival_status_arrival` int(11) NOT NULL,
                            PRIMARY KEY (`arrival_status_id`),
                            KEY `arrival_status_arrival` (`arrival_status_arrival`)
                        )ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;'
                )->execute();

                $dbPool->get()->con->prepare(
                    'ALTER TABLE `' . $dbPool->get()->prefix . 'arrival_status`
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'arrival_status_ibfk_1` FOREIGN KEY (`arrival_status_arrival`) REFERENCES `' . $dbPool->get()->prefix . 'arrival` (`arrival_id`);'
                )->execute();
                break;
        }
    }
}
