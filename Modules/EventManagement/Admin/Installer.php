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
namespace Modules\EventManagement\Admin;

use phpOMS\DataStorage\Database\DatabaseType;
use phpOMS\DataStorage\Database\DatabasePool;
use phpOMS\Module\InfoManager;
use phpOMS\Module\InstallerAbstract;

/**
 * Event Management install class.
 *
 * @category   Modules
 * @package    Modules\EventManagement
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
                    'CREATE TABLE if NOT EXISTS `' . $dbPool->get()->prefix . 'eventmanagement_event` (
                            `eventmanagement_event_id` int(11) NOT NULL AUTO_INCREMENT,
                            `eventmanagement_event_name` varchar(255) NOT NULL,
                            `eventmanagement_event_description` text NOT NULL,
                            `eventmanagement_event_type` tinyint(2) NOT NULL,
                            `eventmanagement_event_calendar` int(11) NOT NULL,
                            `eventmanagement_event_start` datetime NOT NULL,
                            `eventmanagement_event_end` datetime NOT NULL,
                            `eventmanagement_event_progress` int NOT NULL,
                            `eventmanagement_event_progress_type` int NOT NULL,
                            `eventmanagement_event_costs` int(11) NOT NULL,
                            `eventmanagement_event_budget` int(11) NOT NULL,
                            `eventmanagement_event_earnings` int(11) NOT NULL,
                            `eventmanagement_event_created_by` int(11) NOT NULL,
                            `eventmanagement_event_created_at` datetime NOT NULL,
                            PRIMARY KEY (`eventmanagement_event_id`),
                            KEY `eventmanagement_event_calendar` (`eventmanagement_event_calendar`),
                            KEY `eventmanagement_event_created_by` (`eventmanagement_event_created_by`)
                        )ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;'
                )->execute();

                $dbPool->get()->con->prepare(
                    'ALTER TABLE `' . $dbPool->get()->prefix . 'eventmanagement_event`
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'eventmanagement_event_ibfk_1` FOREIGN KEY (`eventmanagement_event_calendar`) REFERENCES `' . $dbPool->get()->prefix . 'calendar` (`calendar_id`),
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'eventmanagement_event_ibfk_2` FOREIGN KEY (`eventmanagement_event_created_by`) REFERENCES `' . $dbPool->get()->prefix . 'account` (`account_id`);'
                )->execute();

                $dbPool->get()->con->prepare(
                    'CREATE TABLE if NOT EXISTS `' . $dbPool->get()->prefix . 'eventmanagement_event_media` (
                            `eventmanagement_event_media_id` int(11) NOT NULL AUTO_INCREMENT,
                            `eventmanagement_event_media_src`  int(11) NULL,
                            `eventmanagement_event_media_dst` int(11) NULL,
                            PRIMARY KEY (`eventmanagement_event_media_id`),
                            KEY `eventmanagement_event_media_src` (`eventmanagement_event_media_src`),
                            KEY `eventmanagement_event_media_dst` (`eventmanagement_event_media_dst`)
                        )ENGINE=InnoDB  DEFAULT CHARSET=utf8;'
                )->execute();

                $dbPool->get()->con->prepare(
                    'ALTER TABLE `' . $dbPool->get()->prefix . 'eventmanagement_event_media`
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'eventmanagement_event_media_ibfk_1` FOREIGN KEY (`eventmanagement_event_media_src`) REFERENCES `' . $dbPool->get()->prefix . 'eventmanagement_event` (`eventmanagement_event_id`),
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'eventmanagement_event_media_ibfk_2` FOREIGN KEY (`eventmanagement_event_media_dst`) REFERENCES `' . $dbPool->get()->prefix . 'media` (`media_id`);'
                )->execute();

                $dbPool->get()->con->prepare(
                    'CREATE TABLE if NOT EXISTS `' . $dbPool->get()->prefix . 'eventmanagement_task_relation` (
                            `eventmanagement_task_relation_id` int(11) NOT NULL AUTO_INCREMENT,
                            `eventmanagement_task_relation_src`  int(11) NULL,
                            `eventmanagement_task_relation_dst` int(11) NULL,
                            PRIMARY KEY (`eventmanagement_task_relation_id`),
                            KEY `eventmanagement_task_relation_src` (`eventmanagement_task_relation_src`),
                            KEY `eventmanagement_task_relation_dst` (`eventmanagement_task_relation_dst`)
                        )ENGINE=InnoDB  DEFAULT CHARSET=utf8;'
                )->execute();

                $dbPool->get()->con->prepare(
                    'ALTER TABLE `' . $dbPool->get()->prefix . 'eventmanagement_task_relation`
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'eventmanagement_task_relation_ibfk_1` FOREIGN KEY (`eventmanagement_task_relation_src`) REFERENCES `' . $dbPool->get()->prefix . 'task` (`task_id`),
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'eventmanagement_task_relation_ibfk_2` FOREIGN KEY (`eventmanagement_task_relation_dst`) REFERENCES `' . $dbPool->get()->prefix . 'eventmanagement_event` (`eventmanagement_event_id`);'
                )->execute();
                break;
        }
    }
}
