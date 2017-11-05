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
namespace Modules\Kanban\Admin;

use phpOMS\DataStorage\Database\DatabaseType;
use phpOMS\DataStorage\Database\DatabasePool;
use phpOMS\Module\InfoManager;
use phpOMS\Module\InstallerAbstract;

/**
 * Tasks install class.
 *
 * @category   Modules
 * @package    Modules\Tasks
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
                    'CREATE TABLE if NOT EXISTS `' . $dbPool->get()->prefix . 'kanban_board` (
                            `kanban_board_id` int(11) NOT NULL AUTO_INCREMENT,
                            `kanban_board_name` varchar(255) NOT NULL,
                            `kanban_board_status` int(11) NOT NULL,
                            `kanban_board_order` int(11) NOT NULL,
                            `kanban_board_desc` text DEFAULT NULL,
                            `kanban_board_created_at` datetime DEFAULT NULL,
                            `kanban_board_created_by` int(11) DEFAULT NULL,
                            PRIMARY KEY (`kanban_board_id`),
                            KEY `kanban_board_created_by` (`kanban_board_created_by`)
                        )ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;'
                )->execute();

                $dbPool->get()->con->prepare(
                    'ALTER TABLE `' . $dbPool->get()->prefix . 'kanban_board`
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'kanban_board_ibfk_1` FOREIGN KEY (`kanban_board_created_by`) REFERENCES `' . $dbPool->get()->prefix . 'account` (`account_id`);'
                )->execute();

                $dbPool->get()->con->prepare(
                    'CREATE TABLE if NOT EXISTS `' . $dbPool->get()->prefix . 'kanban_column` (
                            `kanban_column_id` int(11) NOT NULL AUTO_INCREMENT,
                            `kanban_column_name` varchar(255) NOT NULL,
                            `kanban_column_order` int(11) NOT NULL,
                            `kanban_column_board` int(11) NOT NULL,
                            PRIMARY KEY (`kanban_column_id`),
                            KEY `kanban_column_board` (`kanban_column_board`)
                        )ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;'
                )->execute();

                $dbPool->get()->con->prepare(
                    'ALTER TABLE `' . $dbPool->get()->prefix . 'kanban_column`
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'kanban_column_ibfk_1` FOREIGN KEY (`kanban_column_board`) REFERENCES `' . $dbPool->get()->prefix . 'kanban_board` (`kanban_board_id`);'
                )->execute();

                $dbPool->get()->con->prepare(
                    'CREATE TABLE if NOT EXISTS `' . $dbPool->get()->prefix . 'kanban_card` (
                            `kanban_card_id` int(11) NOT NULL AUTO_INCREMENT,
                            `kanban_card_name` varchar(255) NOT NULL,
                            `kanban_card_description` text NOT NULL,
                            `kanban_card_type` int(2) NOT NULL,
                            `kanban_card_status` int(2) NOT NULL,
                            `kanban_card_order` int(11) NOT NULL,
                            `kanban_card_ref` int(11) DEFAULT NULL,
                            `kanban_card_column` int(11) NOT NULL,
                            `kanban_card_created_at` datetime DEFAULT NULL,
                            `kanban_card_created_by` int(11) DEFAULT NULL,
                            PRIMARY KEY (`kanban_card_id`),
                            KEY `kanban_card_column` (`kanban_card_column`),
                            KEY `kanban_card_created_by` (`kanban_card_created_by`)
                        )ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;'
                )->execute();

                $dbPool->get()->con->prepare(
                    'ALTER TABLE `' . $dbPool->get()->prefix . 'kanban_card`
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'kanban_card_ibfk_1` FOREIGN KEY (`kanban_card_column`) REFERENCES `' . $dbPool->get()->prefix . 'kanban_column` (`kanban_column_id`),
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'kanban_card_ibfk_2` FOREIGN KEY (`kanban_card_created_by`) REFERENCES `' . $dbPool->get()->prefix . 'account` (`account_id`);'
                )->execute();

                $dbPool->get()->con->prepare(
                    'CREATE TABLE if NOT EXISTS `' . $dbPool->get()->prefix . 'kanban_card_media` (
                            `kanban_card_media_id` int(11) NOT NULL AUTO_INCREMENT,
                            `kanban_card_media_dst` int(11) NOT NULL,
                            `kanban_card_media_src` int(11) NOT NULL,
                            PRIMARY KEY (`kanban_card_media_id`),
                            KEY `kanban_card_media_dst` (`kanban_card_media_dst`),
                            KEY `kanban_card_media_src` (`kanban_card_media_src`)
                        )ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;'
                )->execute();

                $dbPool->get()->con->prepare(
                    'ALTER TABLE `' . $dbPool->get()->prefix . 'kanban_card_media`
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'kanban_card_media_ibfk_1` FOREIGN KEY (`kanban_card_media_dst`) REFERENCES `' . $dbPool->get()->prefix . 'media` (`media_id`),
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'kanban_card_media_ibfk_2` FOREIGN KEY (`kanban_card_media_src`) REFERENCES `' . $dbPool->get()->prefix . 'kanban_card` (`kanban_card_id`);'
                )->execute();

                // Task comments and these comments need to be merged which is bad but not every kanban card is a task and task info should be here as well.
                $dbPool->get()->con->prepare(
                    'CREATE TABLE if NOT EXISTS `' . $dbPool->get()->prefix . 'kanban_card_comment` (
                            `kanban_card_comment_id` int(11) NOT NULL AUTO_INCREMENT,
                            `kanban_card_comment_description` text NOT NULL,
                            `kanban_card_comment_card` int(11) NOT NULL,
                            `kanban_card_comment_created_at` datetime DEFAULT NULL,
                            `kanban_card_comment_created_by` int(11) DEFAULT NULL,
                            PRIMARY KEY (`kanban_card_comment_id`),
                            KEY `kanban_card_comment_card` (`kanban_card_comment_card`),
                            KEY `kanban_card_comment_created_by` (`kanban_card_comment_created_by`)
                        )ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;'
                )->execute();

                $dbPool->get()->con->prepare(
                    'ALTER TABLE `' . $dbPool->get()->prefix . 'kanban_card_comment`
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'kanban_card_comment_ibfk_1` FOREIGN KEY (`kanban_card_comment_card`) REFERENCES `' . $dbPool->get()->prefix . 'kanban_card` (`kanban_card_id`),
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'kanban_card_comment_ibfk_2` FOREIGN KEY (`kanban_card_comment_created_by`) REFERENCES `' . $dbPool->get()->prefix . 'account` (`account_id`);'
                )->execute();

                $dbPool->get()->con->prepare(
                    'CREATE TABLE if NOT EXISTS `' . $dbPool->get()->prefix . 'kanban_card_comment_media` (
                            `kanban_card_comment_media_id` int(11) NOT NULL AUTO_INCREMENT,
                            `kanban_card_comment_media_dst` int(11) NOT NULL,
                            `kanban_card_comment_media_src` int(11) NOT NULL,
                            PRIMARY KEY (`kanban_card_comment_media_id`),
                            KEY `kanban_card_comment_media_dst` (`kanban_card_comment_media_dst`),
                            KEY `kanban_card_comment_media_src` (`kanban_card_comment_media_src`)
                        )ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;'
                )->execute();

                $dbPool->get()->con->prepare(
                    'ALTER TABLE `' . $dbPool->get()->prefix . 'kanban_card_comment_media`
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'kanban_card_comment_media_ibfk_1` FOREIGN KEY (`kanban_card_comment_media_dst`) REFERENCES `' . $dbPool->get()->prefix . 'media` (`media_id`),
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'kanban_card_comment_media_ibfk_2` FOREIGN KEY (`kanban_card_comment_media_src`) REFERENCES `' . $dbPool->get()->prefix . 'kanban_card_comment` (`kanban_card_comment_id`);'
                )->execute();

                $dbPool->get()->con->prepare(
                    'CREATE TABLE if NOT EXISTS `' . $dbPool->get()->prefix . 'kanban_activity` (
                            `kanban_activity_id` int(11) NOT NULL AUTO_INCREMENT,
                            `kanban_activity_type` varchar(50) NOT NULL,
                            `kanban_activity_subtype` int(2) NOT NULL,
                            `kanban_activity_board` int(11) NOT NULL,
                            `kanban_activity_old` varchar(255) NOT NULL,
                            `kanban_activity_new` varchar(255) NOT NULL,
                            `kanban_activity_by` int(11) DEFAULT NULL,
                            PRIMARY KEY (`kanban_activity_id`),
                            KEY `kanban_activity_by` (`kanban_activity_by`)
                        )ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;'
                )->execute();

                $dbPool->get()->con->prepare(
                    'ALTER TABLE `' . $dbPool->get()->prefix . 'kanban_activity`
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'kanban_activity_ibfk_1` FOREIGN KEY (`kanban_activity_by`) REFERENCES `' . $dbPool->get()->prefix . 'account` (`account_id`);'
                )->execute();

                $dbPool->get()->con->prepare(
                    'CREATE TABLE if NOT EXISTS `' . $dbPool->get()->prefix . 'kanban_label` (
                            `kanban_label_id` int(11) NOT NULL AUTO_INCREMENT,
                            `kanban_label_name` varchar(255) NOT NULL,
                            `kanban_label_color` int(11) NOT NULL,
                            `kanban_label_board` int(11) NOT NULL,
                            PRIMARY KEY (`kanban_label_id`),
                            KEY `kanban_label_board` (`kanban_label_board`)
                        )ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;'
                )->execute();

                $dbPool->get()->con->prepare(
                    'CREATE TABLE if NOT EXISTS `' . $dbPool->get()->prefix . 'kanban_label_relation` (
                            `kanban_label_relation_id` int(11) NOT NULL AUTO_INCREMENT,
                            `kanban_label_relation_card` int(11) NOT NULL,
                            `kanban_label_relation_label` int(11) NOT NULL,
                            PRIMARY KEY (`kanban_label_relation_id`),
                            KEY `kanban_label_relation_card` (`kanban_label_relation_card`),
                            KEY `kanban_label_relation_label` (`kanban_label_relation_label`)
                        )ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;'
                )->execute();

                $dbPool->get()->con->prepare(
                    'CREATE TABLE if NOT EXISTS `' . $dbPool->get()->prefix . 'kanban_permission` (
                            `kanban_permission_id` int(11) NOT NULL AUTO_INCREMENT,
                            `kanban_permission_permission` int(11) NOT NULL,
                            `kanban_permission_board` int(11) NOT NULL,
                            `kanban_permission_account` int(11) NOT NULL,
                            PRIMARY KEY (`kanban_permission_id`),
                            KEY `kanban_permission_board` (`kanban_permission_board`),
                            KEY `kanban_permission_account` (`kanban_permission_account`)
                        )ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;'
                )->execute();
                break;
        }
    }
}
