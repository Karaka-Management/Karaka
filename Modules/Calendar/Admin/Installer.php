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
namespace Modules\Calendar\Admin;

use phpOMS\DataStorage\Database\DatabaseType;
use phpOMS\DataStorage\Database\DatabasePool;
use phpOMS\Module\InfoManager;
use phpOMS\Module\InstallerAbstract;

/**
 * Calendar install class.
 *
 * @category   Modules
 * @package    Modules\Calendar
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
                    'CREATE TABLE if NOT EXISTS `' . $dbPool->get()->prefix . 'calendar` (
                            `calendar_id` int(11) NOT NULL AUTO_INCREMENT,
                            `calendar_name` varchar(255) NOT NULL,
                            `calendar_description` varchar(255) NOT NULL,
                            `calendar_created_at` datetime NOT NULL,
                            PRIMARY KEY (`calendar_id`)
                        )ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;'
                )->execute();

                $dbPool->get()->con->prepare(
                    'CREATE TABLE if NOT EXISTS `' . $dbPool->get()->prefix . 'calendar_permission` (
                            `calendar_permission_id` int(11) NOT NULL AUTO_INCREMENT,
                            `calendar_permission_type` tinyint(1) NOT NULL,
                            `calendar_permission_ref` int(11) NOT NULL,
                            `calendar_permission_calendar` int(11) NOT NULL,
                            `calendar_permission_permission` tinyint(2) NOT NULL,
                            PRIMARY KEY (`calendar_permission_id`),
                            KEY `calendar_permission_calendar` (`calendar_permission_calendar`)
                        )ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;'
                )->execute();

                $dbPool->get()->con->prepare(
                    'ALTER TABLE `' . $dbPool->get()->prefix . 'calendar_permission`
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'calendar_permission_ibfk_1` FOREIGN KEY (`calendar_permission_calendar`) REFERENCES `' . $dbPool->get()->prefix . 'calendar` (`calendar_id`);'
                )->execute();

                $dbPool->get()->con->prepare(
                    'CREATE TABLE if NOT EXISTS `' . $dbPool->get()->prefix . 'schedule` (
                            `schedule_id` int(11) NOT NULL AUTO_INCREMENT,
                            `schedule_uid` varchar(255) NOT NULL,
                            `schedule_status` tinyint(1) NOT NULL,
                            `schedule_freq_type` tinyint(1) NOT NULL,
                            `schedule_freq_interval` smallint(4) NOT NULL,
                            `schedule_freq_interval_type` tinyint(1) NOT NULL,
                            `schedule_freq_relative_interval` tinyint(3) NOT NULL,
                            `schedule_freq_recurrence_factor` int(11) NOT NULL,
                            `schedule_start` datetime NOT NULL,
                            `schedule_duration` int(11) NOT NULL,
                            `schedule_end` datetime DEFAULT NULL,
                            `schedule_created_at` datetime NOT NULL,
                            `schedule_created_by` int(11) NOT NULL,
                            PRIMARY KEY (`schedule_id`),
                            KEY `schedule_created_by` (`schedule_created_by`)
                        )ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;'
                )->execute();

                $dbPool->get()->con->prepare(
                    'ALTER TABLE `' . $dbPool->get()->prefix . 'schedule`
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'schedule_ibfk_1` FOREIGN KEY (`schedule_created_by`) REFERENCES `' . $dbPool->get()->prefix . 'account` (`account_id`);'
                )->execute();

                $dbPool->get()->con->prepare(
                    'CREATE TABLE if NOT EXISTS `' . $dbPool->get()->prefix . 'calendar_event` (
                            `calendar_event_id` int(11) NOT NULL AUTO_INCREMENT,
                            `calendar_event_name` varchar(25) NOT NULL,
                            `calendar_event_description` varchar(255) NOT NULL,
                            `calendar_event_status` tinyint(1) NOT NULL,
                            `calendar_event_type` tinyint(1) NOT NULL,
                            `calendar_event_location` varchar(511) NOT NULL,
                            `calendar_event_created_by` int(11) NOT NULL,
                            `calendar_event_created_at` datetime NOT NULL,
                            `calendar_event_schedule` int(11) NOT NULL,
                            `calendar_event_calendar` int(11) DEFAULT NULL,
                            PRIMARY KEY (`calendar_event_id`),
                            KEY `calendar_event_created_by` (`calendar_event_created_by`),
                            KEY `calendar_event_schedule` (`calendar_event_schedule`),
                            KEY `calendar_event_calendar` (`calendar_event_calendar`)
                        )ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;'
                )->execute();

                $dbPool->get()->con->prepare(
                    'ALTER TABLE `' . $dbPool->get()->prefix . 'calendar_event`
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'calendar_event_ibfk_1` FOREIGN KEY (`calendar_event_created_by`) REFERENCES `' . $dbPool->get()->prefix . 'account` (`account_id`),
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'calendar_event_ibfk_2` FOREIGN KEY (`calendar_event_schedule`) REFERENCES `' . $dbPool->get()->prefix . 'schedule` (`schedule_id`),
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'calendar_event_ibfk_3` FOREIGN KEY (`calendar_event_calendar`) REFERENCES `' . $dbPool->get()->prefix . 'calendar` (`calendar_id`);'
                )->execute();

                $dbPool->get()->con->prepare(
                    'CREATE TABLE if NOT EXISTS `' . $dbPool->get()->prefix . 'calendar_event_participant` (
                            `calendar_event_participant_id` int(11) NOT NULL AUTO_INCREMENT,
                            `calendar_event_participant_event` int(11) NOT NULL,
                            `calendar_event_participant_person` int(11) NOT NULL,
                            `calendar_event_participant_status` tinyint(1) NOT NULL,
                            PRIMARY KEY (`calendar_event_participant_id`),
                            KEY `calendar_event_participant_event` (`calendar_event_participant_event`),
                            KEY `calendar_event_participant_person` (`calendar_event_participant_person`)
                        )ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;'
                )->execute();

                $dbPool->get()->con->prepare(
                    'ALTER TABLE `' . $dbPool->get()->prefix . 'calendar_event_participant`
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'calendar_event_participant_ibfk_1` FOREIGN KEY (`calendar_event_participant_event`) REFERENCES `' . $dbPool->get()->prefix . 'calendar_event` (`calendar_event_id`),
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'calendar_event_participant_ibfk_2` FOREIGN KEY (`calendar_event_participant_person`) REFERENCES `' . $dbPool->get()->prefix . 'account` (`account_id`);'
                )->execute();
                break;
        }
    }
}
