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
namespace Modules\Comments\Admin;

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
                    'CREATE TABLE if NOT EXISTS `' . $dbPool->get()->prefix . 'comments_list` (
                            `comments_list_id` int(11) NOT NULL AUTO_INCREMENT,
                            PRIMARY KEY (`comments_list_id`)
                        )ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;'
                )->execute();

                $dbPool->get()->con->prepare(
                    'CREATE TABLE if NOT EXISTS `' . $dbPool->get()->prefix . 'comments_comment` (
                            `comments_comment_id` int(11) NOT NULL AUTO_INCREMENT,
                            `comments_comment_title` varchar(250) NOT NULL,
                            `comments_comment_content` text NOT NULL,
                            `comments_comment_list` int(11) DEFAULT NULL,
                            `comments_comment_ref` int(11) DEFAULT NULL,
                            `comments_comment_created_at` datetime NOT NULL,
                            `comments_comment_created_by` int(11) NOT NULL,
                            PRIMARY KEY (`comments_comment_id`),
                            KEY `comments_comment_ref` (`comments_comment_ref`),
                            KEY `comments_comment_created_by` (`comments_comment_created_by`)
                        )ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;'
                )->execute();

                $dbPool->get()->con->prepare(
                    'ALTER TABLE `' . $dbPool->get()->prefix . 'comments_comment`
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'comments_comment_ibfk_1` FOREIGN KEY (`comments_comment_list`) REFERENCES `' . $dbPool->get()->prefix . 'comments_list` (`comments_list_id`),
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'comments_comment_ibfk_2` FOREIGN KEY (`comments_comment_ref`) REFERENCES `' . $dbPool->get()->prefix . 'comments_comment` (`comments_comment_id`),
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'comments_comment_ibfk_3` FOREIGN KEY (`comments_comment_created_by`) REFERENCES `' . $dbPool->get()->prefix . 'account` (`account_id`);'
                )->execute();
                break;
        }
    }
}
