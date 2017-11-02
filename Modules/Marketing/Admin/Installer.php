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
namespace Modules\Marketing\Admin;

use phpOMS\DataStorage\Database\DatabaseType;
use phpOMS\DataStorage\Database\DatabasePool;
use phpOMS\Module\InfoManager;
use phpOMS\Module\InstallerAbstract;

/**
 * Marketing install class.
 *
 * @category   Modules
 * @package    Modules\Marketing
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
                'CREATE TABLE if NOT EXISTS `' . $dbPool->get()->prefix . 'marketing_promotion` (
                        `marketing_promotion_id` int(11) NOT NULL AUTO_INCREMENT,
                        `marketing_promotion_name` varchar(255) NOT NULL,
                        `marketing_promotion_description` text NOT NULL,
                        `marketing_promotion_calendar` int(11) NOT NULL,
                        `marketing_promotion_costs` int(11) NOT NULL,
                        `marketing_promotion_budget` int(11) NOT NULL,
                        `marketing_promotion_earnings` int(11) NOT NULL,
                        `marketing_promotion_start` datetime NOT NULL,
                        `marketing_promotion_end` datetime NOT NULL,
                        `marketing_promotion_created_at` datetime NOT NULL,
                        `marketing_promotion_created_by` int(11) NOT NULL,
                        PRIMARY KEY (`marketing_promotion_id`),
                        KEY `marketing_promotion_calendar` (`marketing_promotion_calendar`),
                        KEY `marketing_promotion_created_by` (`marketing_promotion_created_by`)
                    )ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;'
            )->execute();

            $dbPool->get()->con->prepare(
                'ALTER TABLE `' . $dbPool->get()->prefix . 'marketing_promotion`
                        ADD CONSTRAINT `' . $dbPool->get()->prefix . 'marketing_promotion_ibfk_1` FOREIGN KEY (`marketing_promotion_calendar`) REFERENCES `' . $dbPool->get()->prefix . 'calendar` (`calendar_id`),
                        ADD CONSTRAINT `' . $dbPool->get()->prefix . 'marketing_promotion_ibfk_2` FOREIGN KEY (`marketing_promotion_created_by`) REFERENCES `' . $dbPool->get()->prefix . 'account` (`account_id`);'
            )->execute();

            $dbPool->get()->con->prepare(
                    'CREATE TABLE if NOT EXISTS `' . $dbPool->get()->prefix . 'marketing_promotion_media` (
                            `marketing_promotion_media_id` int(11) NOT NULL AUTO_INCREMENT,
                            `marketing_promotion_media_src`  int(11) NULL,
                            `marketing_promotion_media_dst` int(11) NULL,
                            PRIMARY KEY (`marketing_promotion_media_id`),
                            KEY `marketing_promotion_media_src` (`marketing_promotion_media_src`),
                            KEY `marketing_promotion_media_dst` (`marketing_promotion_media_dst`)
                        )ENGINE=InnoDB  DEFAULT CHARSET=utf8;'
                )->execute();

                $dbPool->get()->con->prepare(
                    'ALTER TABLE `' . $dbPool->get()->prefix . 'marketing_promotion_media`
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'marketing_promotion_media_ibfk_1` FOREIGN KEY (`marketing_promotion_media_src`) REFERENCES `' . $dbPool->get()->prefix . 'marketing_promotion` (`marketing_promotion_id`),
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'marketing_promotion_media_ibfk_2` FOREIGN KEY (`marketing_promotion_media_dst`) REFERENCES `' . $dbPool->get()->prefix . 'media` (`media_id`);'
                )->execute();

            $dbPool->get()->con->prepare(
                'CREATE TABLE if NOT EXISTS `' . $dbPool->get()->prefix . 'marketing_promotion_task_relation` (
                        `marketing_promotion_task_relation_id` int(11) NOT NULL AUTO_INCREMENT,
                        `marketing_promotion_task_relation_src`  int(11) NULL,
                        `marketing_promotion_task_relation_dst` int(11) NULL,
                        PRIMARY KEY (`marketing_promotion_task_relation_id`),
                        KEY `marketing_promotion_task_relation_src` (`marketing_promotion_task_relation_src`),
                        KEY `marketing_promotion_task_relation_dst` (`marketing_promotion_task_relation_dst`)
                    )ENGINE=InnoDB  DEFAULT CHARSET=utf8;'
            )->execute();

            $dbPool->get()->con->prepare(
                'ALTER TABLE `' . $dbPool->get()->prefix . 'marketing_promotion_task_relation`
                        ADD CONSTRAINT `' . $dbPool->get()->prefix . 'marketing_promotion_task_relation_ibfk_1` FOREIGN KEY (`marketing_promotion_task_relation_src`) REFERENCES `' . $dbPool->get()->prefix . 'task` (`task_id`),
                        ADD CONSTRAINT `' . $dbPool->get()->prefix . 'marketing_promotion_task_relation_ibfk_2` FOREIGN KEY (`marketing_promotion_task_relation_dst`) REFERENCES `' . $dbPool->get()->prefix . 'marketing_promotion` (`marketing_promotion_id`);'
            )->execute();
                break;
        }
    }
}
