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
namespace Modules\ProjectManagement\Admin;

use phpOMS\DataStorage\Database\DatabaseType;
use phpOMS\DataStorage\Database\DatabasePool;
use phpOMS\Module\InfoManager;
use phpOMS\Module\InstallerAbstract;

/**
 * Project Management install class.
 *
 * @category   Modules
 * @package    Modules\ProjectManagement
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
                    'CREATE TABLE if NOT EXISTS `' . $dbPool->get()->prefix . 'projectmanagement_project` (
                            `projectmanagement_project_id` int(11) NOT NULL AUTO_INCREMENT,
                            `projectmanagement_project_name` varchar(255) NOT NULL,
                            `projectmanagement_project_description` text NOT NULL,
                            `projectmanagement_project_calendar` int(11) NOT NULL,
                            `projectmanagement_project_costs` int(11) NOT NULL,
                            `projectmanagement_project_budget` int(11) NOT NULL,
                            `projectmanagement_project_earnings` int(11) NOT NULL,
                            `projectmanagement_project_start` datetime NOT NULL,
                            `projectmanagement_project_end` datetime NOT NULL,
                            `projectmanagement_project_progress` int NOT NULL,
                            `projectmanagement_project_progress_type` int NOT NULL,
                            `projectmanagement_project_created_at` datetime NOT NULL,
                            `projectmanagement_project_created_by` int(11) NOT NULL,
                            PRIMARY KEY (`projectmanagement_project_id`),
                            KEY `projectmanagement_project_calendar` (`projectmanagement_project_calendar`),
                            KEY `projectmanagement_project_created_by` (`projectmanagement_project_created_by`)
                        )ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;'
                )->execute();

                $dbPool->get()->con->prepare(
                    'ALTER TABLE `' . $dbPool->get()->prefix . 'projectmanagement_project`
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'projectmanagement_project_ibfk_1` FOREIGN KEY (`projectmanagement_project_calendar`) REFERENCES `' . $dbPool->get()->prefix . 'calendar` (`calendar_id`),
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'projectmanagement_project_ibfk_2` FOREIGN KEY (`projectmanagement_project_created_by`) REFERENCES `' . $dbPool->get()->prefix . 'account` (`account_id`);'
                )->execute();

                $dbPool->get()->con->prepare(
                    'CREATE TABLE if NOT EXISTS `' . $dbPool->get()->prefix . 'projectmanagement_project_media` (
                            `projectmanagement_project_media_id` int(11) NOT NULL AUTO_INCREMENT,
                            `projectmanagement_project_media_src`  int(11) NULL,
                            `projectmanagement_project_media_dst` int(11) NULL,
                            PRIMARY KEY (`projectmanagement_project_media_id`),
                            KEY `projectmanagement_project_media_src` (`projectmanagement_project_media_src`),
                            KEY `projectmanagement_project_media_dst` (`projectmanagement_project_media_dst`)
                        )ENGINE=InnoDB  DEFAULT CHARSET=utf8;'
                )->execute();

                $dbPool->get()->con->prepare(
                    'ALTER TABLE `' . $dbPool->get()->prefix . 'projectmanagement_project_media`
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'projectmanagement_project_media_ibfk_1` FOREIGN KEY (`projectmanagement_project_media_src`) REFERENCES `' . $dbPool->get()->prefix . 'projectmanagement_project` (`projectmanagement_project_id`),
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'projectmanagement_project_media_ibfk_2` FOREIGN KEY (`projectmanagement_project_media_dst`) REFERENCES `' . $dbPool->get()->prefix . 'media` (`media_id`);'
                )->execute();

                $dbPool->get()->con->prepare(
                    'CREATE TABLE if NOT EXISTS `' . $dbPool->get()->prefix . 'projectmanagement_task_relation` (
                            `projectmanagement_task_relation_id` int(11) NOT NULL AUTO_INCREMENT,
                            `projectmanagement_task_relation_src`  int(11) NULL,
                            `projectmanagement_task_relation_dst` int(11) NULL,
                            PRIMARY KEY (`projectmanagement_task_relation_id`),
                            KEY `projectmanagement_task_relation_src` (`projectmanagement_task_relation_src`),
                            KEY `projectmanagement_task_relation_dst` (`projectmanagement_task_relation_dst`)
                        )ENGINE=InnoDB  DEFAULT CHARSET=utf8;'
                )->execute();

                $dbPool->get()->con->prepare(
                    'ALTER TABLE `' . $dbPool->get()->prefix . 'projectmanagement_task_relation`
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'projectmanagement_task_relation_ibfk_1` FOREIGN KEY (`projectmanagement_task_relation_src`) REFERENCES `' . $dbPool->get()->prefix . 'task` (`task_id`),
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'projectmanagement_task_relation_ibfk_2` FOREIGN KEY (`projectmanagement_task_relation_dst`) REFERENCES `' . $dbPool->get()->prefix . 'projectmanagement_project` (`projectmanagement_project_id`);'
                )->execute();
                break;
        }
    }
}
