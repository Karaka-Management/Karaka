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
namespace Modules\Messages\Admin;

use phpOMS\DataStorage\Database\DatabaseType;
use phpOMS\DataStorage\Database\DatabasePool;
use phpOMS\Module\InfoManager;
use phpOMS\Module\InstallerAbstract;

/**
 * Messages install class.
 *
 * @category   Modules
 * @package    Modules\Messages
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
                    'CREATE TABLE if NOT EXISTS `' . $dbPool->get()->prefix . 'message` (
                            `message_id` int(11) NOT NULL AUTO_INCREMENT,
                            `message_type`  tinyint(11) NOT NULL,
                            `message_account` int(11) DEFAULT NULL,
                            `message_email` varchar(256) NULL,
                            `message_sent` datetime NULL,
                            `message_cc` varchar(256) DEFAULT NULL,
                            `message_bcc` varchar(256) DEFAULT NULL,
                            `message_content` text DEFAULT NULL,
                            `message_reference` int(11) DEFAULT NULL,
                            PRIMARY KEY (`message_id`),
                            KEY `message_account` (`message_account`),
                            KEY `message_reference` (`message_reference`)
                        )ENGINE=InnoDB  DEFAULT CHARSET=utf8;'
                )->execute();

                $dbPool->get()->con->prepare(
                    'ALTER TABLE `' . $dbPool->get()->prefix . 'message`
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'message_ibfk_1` FOREIGN KEY (`message_account`) REFERENCES `' . $dbPool->get()->prefix . 'account` (`account_id`),
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'message_ibfk_2` FOREIGN KEY (`message_reference`) REFERENCES `' . $dbPool->get()->prefix . 'message` (`message_id`);'
                )->execute();

                $dbPool->get()->con->prepare(
                    'CREATE TABLE if NOT EXISTS `' . $dbPool->get()->prefix . 'messages_attachment` (
                            `messages_attachment_id` int(11) NOT NULL AUTO_INCREMENT,
                            `messages_attachment_media` int(11) DEFAULT NULL,
                            `messages_attachment_message` int(11) NULL,
                            PRIMARY KEY (`messages_attachment_id`),
                            KEY `messages_attachment_media` (`messages_attachment_media`),
                            KEY `messages_attachment_message` (`messages_attachment_message`)
                        )ENGINE=InnoDB  DEFAULT CHARSET=utf8;'
                )->execute();

                $dbPool->get()->con->prepare(
                    'ALTER TABLE `' . $dbPool->get()->prefix . 'messages_attachment`
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'messages_attachment_ibfk_1` FOREIGN KEY (`messages_attachment_media`) REFERENCES `' . $dbPool->get()->prefix . 'media` (`media_id`),
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'messages_attachment_ibfk_2` FOREIGN KEY (`messages_attachment_message`) REFERENCES `' . $dbPool->get()->prefix . 'message` (`message_id`);'
                )->execute();
                break;
        }
    }
}
