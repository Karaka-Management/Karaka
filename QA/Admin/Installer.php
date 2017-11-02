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
namespace Modules\QA\Admin;

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
                    'CREATE TABLE if NOT EXISTS `' . $dbPool->get()->prefix . 'qa_category` (
                            `qa_category_id` int(11) NOT NULL AUTO_INCREMENT,
                            `qa_category_name` varchar(255) NOT NULL,
                            `qa_category_parent` int(11) DEFAULT NULL,
                            PRIMARY KEY (`qa_category_id`),
                            KEY `qa_category_parent` (`qa_category_parent`)
                        )ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;'
                )->execute();

                $dbPool->get()->con->prepare(
                    'ALTER TABLE `' . $dbPool->get()->prefix . 'qa_category`
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'qa_category_ibfk_1` FOREIGN KEY (`qa_category_parent`) REFERENCES `' . $dbPool->get()->prefix . 'qa_category` (`qa_category_id`)'
                )->execute();

                $dbPool->get()->con->prepare(
                    'CREATE TABLE if NOT EXISTS `' . $dbPool->get()->prefix . 'qa_badge` (
                            `qa_badge_id` int(11) NOT NULL AUTO_INCREMENT,
                            `qa_badge_name` varchar(255) NOT NULL,
                            PRIMARY KEY (`qa_badge_id`)
                        )ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;'
                )->execute();

                $dbPool->get()->con->prepare(
                    'CREATE TABLE if NOT EXISTS `' . $dbPool->get()->prefix . 'qa_question` (
                            `qa_question_id` int(11) NOT NULL AUTO_INCREMENT,
                            `qa_question_status` int(11) NOT NULL,
                            `qa_question_title` varchar(255) NOT NULL,
                            `qa_question_language` varchar(3) NOT NULL,
                            `qa_question_question` text NOT NULL,
                            `qa_question_created_by` int(11) NOT NULL,
                            `qa_question_created_at` datetime NOT NULL,
                            `qa_question_category` int(11) DEFAULT NULL,
                            PRIMARY KEY (`qa_question_id`),
                            KEY `qa_question_created_by` (`qa_question_created_by`),
                            KEY `qa_question_category` (`qa_question_category`)
                        )ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;'
                )->execute();

                $dbPool->get()->con->prepare(
                    'ALTER TABLE `' . $dbPool->get()->prefix . 'qa_question`
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'qa_question_ibfk_1` FOREIGN KEY (`qa_question_created_by`) REFERENCES `' . $dbPool->get()->prefix . 'account` (`account_id`),
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'qa_question_ibfk_2` FOREIGN KEY (`qa_question_category`) REFERENCES `' . $dbPool->get()->prefix . 'qa_category` (`qa_category_id`);'
                )->execute();

                $dbPool->get()->con->prepare(
                    'CREATE TABLE if NOT EXISTS `' . $dbPool->get()->prefix . 'qa_question_badge` (
                            `qa_question_badge_id` int(11) NOT NULL AUTO_INCREMENT,
                            `qa_question_badge_question` int(11) NOT NULL,
                            `qa_question_badge_badge` int(11) DEFAULT NULL,
                            PRIMARY KEY (`qa_question_badge_id`),
                            KEY `qa_question_badge_question` (`qa_question_badge_question`),
                            KEY `qa_question_badge_badge` (`qa_question_badge_badge`)
                        )ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;'
                )->execute();

                $dbPool->get()->con->prepare(
                    'ALTER TABLE `' . $dbPool->get()->prefix . 'qa_question_badge`
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'qa_question_badge_ibfk_1` FOREIGN KEY (`qa_question_badge_question`) REFERENCES `' . $dbPool->get()->prefix . 'qa_question` (`qa_question_id`),
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'qa_question_badge_ibfk_2` FOREIGN KEY (`qa_question_badge_badge`) REFERENCES `' . $dbPool->get()->prefix . 'qa_badge` (`qa_badge_id`)'
                )->execute();

                $dbPool->get()->con->prepare(
                    'CREATE TABLE if NOT EXISTS `' . $dbPool->get()->prefix . 'qa_answer` (
                            `qa_answer_id` int(11) NOT NULL AUTO_INCREMENT,
                            `qa_answer_status` int(11) NOT NULL,
                            `qa_answer_accepted` tinyint(1) NOT NULL,
                            `qa_answer_answer` text NOT NULL,
                            `qa_answer_created_by` int(11) NOT NULL,
                            `qa_answer_created_at` datetime NOT NULL,
                            `qa_answer_question` int(11) DEFAULT NULL,
                            PRIMARY KEY (`qa_answer_id`),
                            KEY `qa_answer_created_by` (`qa_answer_created_by`),
                            KEY `qa_answer_question` (`qa_answer_question`)
                        )ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;'
                )->execute();

                $dbPool->get()->con->prepare(
                    'ALTER TABLE `' . $dbPool->get()->prefix . 'qa_answer`
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'qa_answer_ibfk_1` FOREIGN KEY (`qa_answer_created_by`) REFERENCES `' . $dbPool->get()->prefix . 'account` (`account_id`),
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'qa_answer_ibfk_2` FOREIGN KEY (`qa_answer_question`) REFERENCES `' . $dbPool->get()->prefix . 'qa_question` (`qa_question_id`);'
                )->execute();
                break;
        }
    }
}
