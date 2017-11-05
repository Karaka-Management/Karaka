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
namespace Modules\News\Admin;

use phpOMS\DataStorage\Database\DatabaseType;
use phpOMS\DataStorage\Database\DatabasePool;
use phpOMS\Module\InfoManager;
use phpOMS\Module\InstallerAbstract;

/**
 * News install class.
 *
 * @category   Modules
 * @package    Modules\News
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
                    'CREATE TABLE if NOT EXISTS `' . $dbPool->get()->prefix . 'news` (
                            `news_id` int(11) NOT NULL AUTO_INCREMENT,
                            `news_title` varchar(250) NOT NULL,
                            `news_featured` tinyint(1) DEFAULT NULL,
                            `news_content` text NOT NULL,
                            `news_plain` text NOT NULL,
                            `news_type` tinyint(2) NOT NULL,
                            `news_status` tinyint(1) NOT NULL,
                            `news_lang` varchar(2) NOT NULL,
                            `news_publish` datetime NOT NULL,
                            `news_created_at` datetime NOT NULL,
                            `news_created_by` int(11) NOT NULL,
                            PRIMARY KEY (`news_id`),
                            KEY `news_created_by` (`news_created_by`)
                        )ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;'
                )->execute();

                $dbPool->get()->con->prepare(
                    'ALTER TABLE `' . $dbPool->get()->prefix . 'news`
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'news_ibfk_1` FOREIGN KEY (`news_created_by`) REFERENCES `' . $dbPool->get()->prefix . 'account` (`account_id`);'
                )->execute();

                $dbPool->get()->con->prepare(
                    'CREATE TABLE if NOT EXISTS `' . $dbPool->get()->prefix . 'news_badge` (
                            `news_badge_id` int(11) NOT NULL AUTO_INCREMENT,
                            `news_badge_title` varchar(20) NOT NULL,
                            PRIMARY KEY (`news_badge_id`)
                        )ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;'
                )->execute();

                $dbPool->get()->con->prepare(
                    'CREATE TABLE if NOT EXISTS `' . $dbPool->get()->prefix . 'news_badge_relation` (
                            `news_badge_relation_id` int(11) NOT NULL AUTO_INCREMENT,
                            `news_badge_relation_news` int(11) NOT NULL,
                            `news_badge_relation_badge` int(11) NOT NULL,
                            PRIMARY KEY (`news_badge_relation_id`),
                            KEY `news_badge_relation_news` (`news_badge_relation_news`),
                            KEY `news_badge_relation_badge` (`news_badge_relation_badge`)
                        )ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;'
                )->execute();

                $dbPool->get()->con->prepare(
                    'ALTER TABLE `' . $dbPool->get()->prefix . 'news_badge_relation`
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'news_badge_relation_ibfk_1` FOREIGN KEY (`news_badge_relation_news`) REFERENCES `' . $dbPool->get()->prefix . 'news` (`news_id`),
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'news_badge_relation_ibfk_2` FOREIGN KEY (`news_badge_relation_badge`) REFERENCES `' . $dbPool->get()->prefix . 'news_badge` (`news_badge_id`);'
                )->execute();
                break;
        }
    }
}
