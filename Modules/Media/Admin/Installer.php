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
namespace Modules\Media\Admin;

use phpOMS\DataStorage\Database\DatabaseType;
use phpOMS\DataStorage\Database\DatabasePool;
use phpOMS\Module\InfoManager;
use phpOMS\Module\InstallerAbstract;

/**
 * Media install class.
 *
 * @category   Modules
 * @package    Modules\Media
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
                    'CREATE TABLE if NOT EXISTS `' . $dbPool->get()->prefix . 'media` (
                            `media_id` int(11) NOT NULL AUTO_INCREMENT,
                            `media_name`  varchar(100) DEFAULT NULL,
                            `media_description` text DEFAULT NULL,
                            `media_versioned`  tinyint(1) NOT NULL,
                            `media_file` varchar(255) NOT NULL,
                            `media_absolute` tinyint(1) NOT NULL,
                            `media_extension` varchar(10) DEFAULT NULL,
                            `media_collection` tinyint(1) DEFAULT NULL,
                            `media_size` int(11) DEFAULT NULL,
                            `media_created_by` int(11) DEFAULT NULL,
                            `media_created_at` datetime DEFAULT NULL,
                            PRIMARY KEY (`media_id`),
                            KEY `media_created_by` (`media_created_by`)
                        )ENGINE=InnoDB  DEFAULT CHARSET=utf8;'
                )->execute();

                $dbPool->get()->con->prepare(
                    'ALTER TABLE `' . $dbPool->get()->prefix . 'media`
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'media_ibfk_1` FOREIGN KEY (`media_created_by`) REFERENCES `' . $dbPool->get()->prefix . 'account` (`account_id`);'
                )->execute();

                $dbPool->get()->con->prepare(
                    'CREATE TABLE if NOT EXISTS `' . $dbPool->get()->prefix . 'media_relation` (
                            `media_relation_id` int(11) NOT NULL AUTO_INCREMENT,
                            `media_relation_src`  int(11) NULL,
                            `media_relation_dst` int(11) NULL,
                            PRIMARY KEY (`media_relation_id`),
                            KEY `media_relation_src` (`media_relation_src`),
                            KEY `media_relation_dst` (`media_relation_dst`)
                        )ENGINE=InnoDB  DEFAULT CHARSET=utf8;'
                )->execute();

                $dbPool->get()->con->prepare(
                    'ALTER TABLE `' . $dbPool->get()->prefix . 'media_relation`
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'media_relation_ibfk_1` FOREIGN KEY (`media_relation_src`) REFERENCES `' . $dbPool->get()->prefix . 'media` (`media_id`),
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'media_relation_ibfk_2` FOREIGN KEY (`media_relation_dst`) REFERENCES `' . $dbPool->get()->prefix . 'media` (`media_id`);'
                )->execute();

                $dbPool->get()->con->prepare(
                    'CREATE TABLE if NOT EXISTS `' . $dbPool->get()->prefix . 'media_permission` (
                            `media_permission_id` int(11) NOT NULL AUTO_INCREMENT,
                            `media_permission_type`  tinyint(1) NOT NULL,
                            `media_permission_reference` int(11) NOT NULL,
                            `media_permission_permission` tinyint(2) NOT NULL,
                            `media_permission_media` int(11) NOT NULL,
                            PRIMARY KEY (`media_permission_id`),
                            KEY `media_permission_media` (`media_permission_media`)
                        )ENGINE=InnoDB  DEFAULT CHARSET=utf8;'
                )->execute();

                $dbPool->get()->con->prepare(
                    'ALTER TABLE `' . $dbPool->get()->prefix . 'media_permission`
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'media_permission_ibfk_1` FOREIGN KEY (`media_permission_media`) REFERENCES `' . $dbPool->get()->prefix . 'media` (`media_id`);'
                )->execute();
                break;
        }
    }
}
