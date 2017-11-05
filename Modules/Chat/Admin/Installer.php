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
namespace Modules\Chat\Admin;

use phpOMS\DataStorage\Database\DatabaseType;
use phpOMS\DataStorage\Database\DatabasePool;
use phpOMS\Module\InfoManager;
use phpOMS\Module\InstallerAbstract;

/**
 * Chat install class.
 *
 * @category   Modules
 * @package    Modules\Chat
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
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
                    'CREATE TABLE if NOT EXISTS `' . $dbPool->get()->prefix . 'chat_room` (
                            `chat_room_id` int(11) NOT NULL AUTO_INCREMENT,
                            `chat_room_name` varchar(25) NOT NULL,
                            `chat_room_password` varchar(64) NOT NULL,
                            `chat_room_description` varchar(255) NOT NULL,
                            `chat_room_creator` int(11) NOT NULL,
                            `chat_room_created` datetime NOT NULL,
                            PRIMARY KEY (`chat_room_id`),
                            KEY `chat_room_creator` (`chat_room_creator`)
                        )ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;'
                )->execute();

                $dbPool->get()->con->prepare(
                    'ALTER TABLE `' . $dbPool->get()->prefix . 'chat_room`
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'chat_room_ibfk_1` FOREIGN KEY (`chat_room_creator`) REFERENCES `' . $dbPool->get()->prefix . 'account` (`account_id`);'
                )->execute();

                $dbPool->get()->con->prepare(
                    'CREATE TABLE if NOT EXISTS `' . $dbPool->get()->prefix . 'chat_room_permission` (
                            `chat_room_permission_id` int(11) NOT NULL AUTO_INCREMENT,
                            `chat_room_permission_account` int(11) NOT NULL,
                            `chat_room_permission_room` int(11) NOT NULL,
                            `chat_room_permission_permission` tinyint(1) NOT NULL,
                            PRIMARY KEY (`chat_room_permission_id`),
                            KEY `chat_room_permission_account` (`chat_room_permission_account`),
                            KEY `chat_room_permission_room` (`chat_room_permission_room`)
                        )ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;'
                )->execute();

                $dbPool->get()->con->prepare(
                    'ALTER TABLE `' . $dbPool->get()->prefix . 'chat_room_permission`
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'chat_room_permission_ibfk_1` FOREIGN KEY (`chat_room_permission_account`) REFERENCES `' . $dbPool->get()->prefix . 'account` (`account_id`),
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'chat_room_permission_ibfk_2` FOREIGN KEY (`chat_room_permission_room`) REFERENCES `' . $dbPool->get()->prefix . 'chat_room` (`chat_room_id`);'
                )->execute();
                break;
        }
    }
}
