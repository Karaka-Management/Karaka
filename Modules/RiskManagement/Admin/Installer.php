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
namespace Modules\RiskManagement\Admin;

use phpOMS\DataStorage\Database\DatabaseType;
use phpOMS\DataStorage\Database\DatabasePool;
use phpOMS\Module\InfoManager;
use phpOMS\Module\InstallerAbstract;

/**
 * Risk Management install class.
 *
 * @category   Modules
 * @package    Modules\RiskManagement
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
                    'CREATE TABLE if NOT EXISTS `' . $dbPool->get()->prefix . 'riskmngmt_category` (
                            `riskmngmt_category_id` int(11) NOT NULL AUTO_INCREMENT,
                            `riskmngmt_category_name` varchar(50) NOT NULL,
                            `riskmngmt_category_description` text NOT NULL,
                            `riskmngmt_category_descriptionraw` text NOT NULL,
                            `riskmngmt_category_parent` int(11) DEFAULT NULL,
                            `riskmngmt_category_responsible` int(11) DEFAULT NULL,
                            `riskmngmt_category_deputy` int(11) DEFAULT NULL,
                            PRIMARY KEY (`riskmngmt_category_id`),
                            KEY `riskmngmt_category_parent` (`riskmngmt_category_parent`),
                            KEY `riskmngmt_category_responsible` (`riskmngmt_category_responsible`),
                            KEY `riskmngmt_category_deputy` (`riskmngmt_category_deputy`)
                        )ENGINE=InnoDB  DEFAULT CHARSET=utf8;'
                )->execute();

                $dbPool->get()->con->prepare(
                    'ALTER TABLE `' . $dbPool->get()->prefix . 'riskmngmt_category`
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'riskmngmt_category_ibfk_1` FOREIGN KEY (`riskmngmt_category_parent`) REFERENCES `' . $dbPool->get()->prefix . 'riskmngmt_category` (`riskmngmt_category_id`),
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'riskmngmt_category_ibfk_2` FOREIGN KEY (`riskmngmt_category_responsible`) REFERENCES `' . $dbPool->get()->prefix . 'account` (`account_id`),
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'riskmngmt_category_ibfk_3` FOREIGN KEY (`riskmngmt_category_deputy`) REFERENCES `' . $dbPool->get()->prefix . 'account` (`account_id`);'
                )->execute();

                // TODO: more (media, start, end etc...)
                $dbPool->get()->con->prepare(
                    'CREATE TABLE if NOT EXISTS `' . $dbPool->get()->prefix . 'riskmngmt_process` (
                            `riskmngmt_process_id` int(11) NOT NULL AUTO_INCREMENT,
                            `riskmngmt_process_name` text NOT NULL,
                            `riskmngmt_process_description` text NOT NULL,
                            `riskmngmt_process_descriptionraw` text NOT NULL,
                            `riskmngmt_process_department` int(11) DEFAULT NULL,
                            `riskmngmt_process_unit` int(11) NOT NULL,
                            `riskmngmt_process_responsible` int(11) DEFAULT NULL,
                            `riskmngmt_process_deputy` int(11) DEFAULT NULL,
                            PRIMARY KEY (`riskmngmt_process_id`),
                            KEY `riskmngmt_process_unit` (`riskmngmt_process_unit`),
                            KEY `riskmngmt_process_department` (`riskmngmt_process_department`),
                            KEY `riskmngmt_process_responsible` (`riskmngmt_process_responsible`),
                            KEY `riskmngmt_process_deputy` (`riskmngmt_process_deputy`)
                        )ENGINE=InnoDB  DEFAULT CHARSET=utf8;'
                )->execute();

                $dbPool->get()->con->prepare(
                    'ALTER TABLE `' . $dbPool->get()->prefix . 'riskmngmt_process`
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'riskmngmt_process_ibfk_1` FOREIGN KEY (`riskmngmt_process_unit`) REFERENCES `' . $dbPool->get()->prefix . 'organization_unit` (`organization_unit_id`),
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'riskmngmt_process_ibfk_2` FOREIGN KEY (`riskmngmt_process_department`) REFERENCES `' . $dbPool->get()->prefix . 'organization_department` (`organization_department_id`),
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'riskmngmt_process_ibfk_3` FOREIGN KEY (`riskmngmt_process_responsible`) REFERENCES `' . $dbPool->get()->prefix . 'account` (`account_id`),
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'riskmngmt_process_ibfk_4` FOREIGN KEY (`riskmngmt_process_deputy`) REFERENCES `' . $dbPool->get()->prefix . 'account` (`account_id`);'
                )->execute();

                // todo: only install if projectmanagement exists
                $dbPool->get()->con->prepare(
                    'CREATE TABLE if NOT EXISTS `' . $dbPool->get()->prefix . 'riskmngmt_project` (
                            `riskmngmt_project_id` int(11) NOT NULL AUTO_INCREMENT,
                            `riskmngmt_project_project` int(11) NOT NULL,
                            `riskmngmt_project_responsible` int(11) DEFAULT NULL,
                            `riskmngmt_project_deputy` int(11) DEFAULT NULL,
                            PRIMARY KEY (`riskmngmt_project_id`),
                            KEY `riskmngmt_project_project` (`riskmngmt_project_project`),
                            KEY `riskmngmt_project_responsible` (`riskmngmt_project_responsible`),
                            KEY `riskmngmt_project_deputy` (`riskmngmt_project_deputy`)
                        )ENGINE=InnoDB  DEFAULT CHARSET=utf8;'
                )->execute();

                $dbPool->get()->con->prepare(
                    'ALTER TABLE `' . $dbPool->get()->prefix . 'riskmngmt_project`
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'riskmngmt_project_ibfk_1` FOREIGN KEY (`riskmngmt_project_project`) REFERENCES `' . $dbPool->get()->prefix . 'projectmanagement_project` (`projectmanagement_project_id`),
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'riskmngmt_project_ibfk_2` FOREIGN KEY (`riskmngmt_project_responsible`) REFERENCES `' . $dbPool->get()->prefix . 'account` (`account_id`),
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'riskmngmt_project_ibfk_3` FOREIGN KEY (`riskmngmt_project_deputy`) REFERENCES `' . $dbPool->get()->prefix . 'account` (`account_id`);'
                )->execute();

                $dbPool->get()->con->prepare(
                    'CREATE TABLE if NOT EXISTS `' . $dbPool->get()->prefix . 'riskmngmt_department` (
                            `riskmngmt_department_id` int(11) NOT NULL AUTO_INCREMENT,
                            `riskmngmt_department_department` int(11) NOT NULL,
                            `riskmngmt_department_responsible` int(11) DEFAULT NULL,
                            `riskmngmt_department_deputy` int(11) DEFAULT NULL,
                            PRIMARY KEY (`riskmngmt_department_id`),
                            KEY `riskmngmt_department_department` (`riskmngmt_department_department`),
                            KEY `riskmngmt_department_responsible` (`riskmngmt_department_responsible`),
                            KEY `riskmngmt_department_deputy` (`riskmngmt_department_deputy`)
                        )ENGINE=InnoDB  DEFAULT CHARSET=utf8;'
                )->execute();

                $dbPool->get()->con->prepare(
                    'ALTER TABLE `' . $dbPool->get()->prefix . 'riskmngmt_department`
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'riskmngmt_department_ibfk_1` FOREIGN KEY (`riskmngmt_department_department`) REFERENCES `' . $dbPool->get()->prefix . 'organization_department` (`organization_department_id`),
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'riskmngmt_department_ibfk_2` FOREIGN KEY (`riskmngmt_department_responsible`) REFERENCES `' . $dbPool->get()->prefix . 'account` (`account_id`),
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'riskmngmt_department_ibfk_3` FOREIGN KEY (`riskmngmt_department_deputy`) REFERENCES `' . $dbPool->get()->prefix . 'account` (`account_id`);'
                )->execute();

                $dbPool->get()->con->prepare(
                    'CREATE TABLE if NOT EXISTS `' . $dbPool->get()->prefix . 'riskmngmt_risk` (
                            `riskmngmt_risk_id` int(11) NOT NULL AUTO_INCREMENT,
                            `riskmngmt_risk_name` varchar(255) NOT NULL,
                            `riskmngmt_risk_description` text NOT NULL,
                            `riskmngmt_risk_descriptionraw` text NOT NULL,
                            `riskmngmt_risk_unit` int(11) NOT NULL,
                            `riskmngmt_risk_department` int(11) DEFAULT NULL,
                            `riskmngmt_risk_category` int(11) DEFAULT NULL,
                            `riskmngmt_risk_project` int(11) DEFAULT NULL,
                            `riskmngmt_risk_process` int(11) DEFAULT NULL,
                            `riskmngmt_risk_responsible` int(11) DEFAULT NULL,
                            `riskmngmt_risk_deputy` int(11) DEFAULT NULL,
                            `riskmngmt_risk_created_at` datetime DEFAULT NULL,
                            PRIMARY KEY (`riskmngmt_risk_id`),
                            KEY `riskmngmt_risk_unit` (`riskmngmt_risk_unit`),
                            KEY `riskmngmt_risk_responsible` (`riskmngmt_risk_responsible`),
                            KEY `riskmngmt_risk_deputy` (`riskmngmt_risk_deputy`)
                        )ENGINE=InnoDB  DEFAULT CHARSET=utf8;'
                )->execute();

                $dbPool->get()->con->prepare(
                    'ALTER TABLE `' . $dbPool->get()->prefix . 'riskmngmt_risk`
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'riskmngmt_risk_ibfk_1` FOREIGN KEY (`riskmngmt_risk_unit`) REFERENCES `' . $dbPool->get()->prefix . 'organization_unit` (`organization_unit_id`),
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'riskmngmt_risk_ibfk_2` FOREIGN KEY (`riskmngmt_risk_responsible`) REFERENCES `' . $dbPool->get()->prefix . 'account` (`account_id`),
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'riskmngmt_risk_ibfk_3` FOREIGN KEY (`riskmngmt_risk_deputy`) REFERENCES `' . $dbPool->get()->prefix . 'account` (`account_id`);'
                )->execute();

                $dbPool->get()->con->prepare(
                    'CREATE TABLE if NOT EXISTS `' . $dbPool->get()->prefix . 'riskmngmt_risk_eval` (
                            `riskmngmt_risk_eval_id` int(11) NOT NULL AUTO_INCREMENT,
                            `riskmngmt_risk_eval_gross_probability` int(11) NOT NULL,
                            `riskmngmt_risk_eval_gross_risk` int(11) NOT NULL,
                            `riskmngmt_risk_eval_gross_score` int(11) NOT NULL,
                            `riskmngmt_risk_eval_net_probability` int(11) NOT NULL,
                            `riskmngmt_risk_eval_net_risk` int(11) NOT NULL,
                            `riskmngmt_risk_eval_net_score` int(11) NOT NULL,
                            `riskmngmt_risk_eval_risk` int(11) NOT NULL,
                            `riskmngmt_risk_eval_date` datetime NOT NULL,
                            PRIMARY KEY (`riskmngmt_risk_eval_id`),
                            KEY `riskmngmt_risk_eval_risk` (`riskmngmt_risk_eval_risk`)
                        )ENGINE=InnoDB  DEFAULT CHARSET=utf8;'
                )->execute();

                $dbPool->get()->con->prepare(
                    'ALTER TABLE `' . $dbPool->get()->prefix . 'riskmngmt_risk_eval`
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'riskmngmt_risk_eval_ibfk_1` FOREIGN KEY (`riskmngmt_risk_eval_risk`) REFERENCES `' . $dbPool->get()->prefix . 'riskmngmt_risk` (`riskmngmt_risk_id`);'
                )->execute();

                $dbPool->get()->con->prepare(
                    'CREATE TABLE if NOT EXISTS `' . $dbPool->get()->prefix . 'riskmngmt_risk_object` (
                            `riskmngmt_risk_object_id` int(11) NOT NULL AUTO_INCREMENT,
                            `riskmngmt_risk_object_name` varchar(50) NOT NULL,
                            `riskmngmt_risk_object_description` text NOT NULL,
                            `riskmngmt_risk_object_descriptionraw` text NOT NULL,
                            `riskmngmt_risk_object_risk` int(11) NOT NULL,
                            PRIMARY KEY (`riskmngmt_risk_object_id`)
                        )ENGINE=InnoDB  DEFAULT CHARSET=utf8;'
                )->execute();

                $dbPool->get()->con->prepare(
                    'ALTER TABLE `' . $dbPool->get()->prefix . 'riskmngmt_risk_object`
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'riskmngmt_risk_object_ibfk_1` FOREIGN KEY (`riskmngmt_risk_object_risk`) REFERENCES `' . $dbPool->get()->prefix . 'riskmngmt_risk` (`riskmngmt_risk_id`);'
                )->execute();

                $dbPool->get()->con->prepare(
                    'CREATE TABLE if NOT EXISTS `' . $dbPool->get()->prefix . 'riskmngmt_risk_object_eval` (
                            `riskmngmt_risk_object_eval_id` int(11) NOT NULL AUTO_INCREMENT,
                            `riskmngmt_risk_object_eval_val` decimal(11,4) NOT NULL,
                            `riskmngmt_risk_object_eval_object` int(11) NOT NULL,
                            `riskmngmt_risk_object_eval_date` datetime NOT NULL,
                            PRIMARY KEY (`riskmngmt_risk_object_eval_id`),
                            KEY `riskmngmt_risk_object_eval_object` (`riskmngmt_risk_object_eval_object`)
                        )ENGINE=InnoDB  DEFAULT CHARSET=utf8;'
                )->execute();

                $dbPool->get()->con->prepare(
                    'ALTER TABLE `' . $dbPool->get()->prefix . 'riskmngmt_risk_object_eval`
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'riskmngmt_risk_object_eval_ibfk_1` FOREIGN KEY (`riskmngmt_risk_object_eval_object`) REFERENCES `' . $dbPool->get()->prefix . 'riskmngmt_risk_object` (`riskmngmt_risk_object_id`);'
                )->execute();

                $dbPool->get()->con->prepare(
                    'CREATE TABLE if NOT EXISTS `' . $dbPool->get()->prefix . 'riskmngmt_risk_media` (
                            `riskmngmt_risk_media_id` int(11) NOT NULL AUTO_INCREMENT,
                            `riskmngmt_risk_media_risk` int(11) NOT NULL,
                            `riskmngmt_risk_media_media` int(11) NOT NULL,
                            PRIMARY KEY (`riskmngmt_risk_media_id`),
                            KEY `riskmngmt_risk_media_risk` (`riskmngmt_risk_media_risk`),
                            KEY `riskmngmt_risk_media_media` (`riskmngmt_risk_media_media`)
                        )ENGINE=InnoDB  DEFAULT CHARSET=utf8;'
                )->execute();

                $dbPool->get()->con->prepare(
                    'ALTER TABLE `' . $dbPool->get()->prefix . 'riskmngmt_risk_media`
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'riskmngmt_risk_media_ibfk_1` FOREIGN KEY (`riskmngmt_risk_media_risk`) REFERENCES `' . $dbPool->get()->prefix . 'riskmngmt_risk` (`riskmngmt_risk_id`),
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'riskmngmt_risk_media_ibfk_2` FOREIGN KEY (`riskmngmt_risk_media_media`) REFERENCES `' . $dbPool->get()->prefix . 'media` (`media_id`);'
                )->execute();

                $dbPool->get()->con->prepare(
                    'CREATE TABLE if NOT EXISTS `' . $dbPool->get()->prefix . 'riskmngmt_cause` (
                            `riskmngmt_cause_id` int(11) NOT NULL AUTO_INCREMENT,
                            `riskmngmt_cause_name` varchar(50) NOT NULL,
                            `riskmngmt_cause_description` text NOT NULL,
                            `riskmngmt_cause_descriptionraw` text NOT NULL,
                            `riskmngmt_cause_probability` smallint(6) NOT NULL,
                            `riskmngmt_cause_department` int(11) DEFAULT NULL,
                            `riskmngmt_cause_category` int(11) DEFAULT NULL,
                            `riskmngmt_cause_risk` int(11) DEFAULT NULL,
                            PRIMARY KEY (`riskmngmt_cause_id`),
                            KEY `riskmngmt_cause_department` (`riskmngmt_cause_department`),
                            KEY `riskmngmt_cause_category` (`riskmngmt_cause_category`),
                            KEY `riskmngmt_cause_risk` (`riskmngmt_cause_risk`)
                        )ENGINE=InnoDB  DEFAULT CHARSET=utf8;'
                )->execute();

                $dbPool->get()->con->prepare(
                    'ALTER TABLE `' . $dbPool->get()->prefix . 'riskmngmt_cause`
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'riskmngmt_cause_ibfk_1` FOREIGN KEY (`riskmngmt_cause_risk`) REFERENCES `' . $dbPool->get()->prefix . 'riskmngmt_risk` (`riskmngmt_risk_id`),
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'riskmngmt_cause_ibfk_2` FOREIGN KEY (`riskmngmt_cause_category`) REFERENCES `' . $dbPool->get()->prefix . 'riskmngmt_category` (`riskmngmt_category_id`),
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'riskmngmt_cause_ibfk_3` FOREIGN KEY (`riskmngmt_cause_department`) REFERENCES `' . $dbPool->get()->prefix . 'riskmngmt_department` (`riskmngmt_department_id`);'
                )->execute();

                $dbPool->get()->con->prepare(
                    'CREATE TABLE if NOT EXISTS `' . $dbPool->get()->prefix . 'riskmngmt_solution` (
                            `riskmngmt_solution_id` int(11) NOT NULL AUTO_INCREMENT,
                            `riskmngmt_solution_name` varchar(50) NOT NULL,
                            `riskmngmt_solution_description` text NOT NULL,
                            `riskmngmt_solution_descriptionraw` text NOT NULL,
                            `riskmngmt_solution_probability` smallint(6) NOT NULL,
                            `riskmngmt_solution_effect` decimal(11,4) DEFAULT NULL,
                            `riskmngmt_solution_cause` int(11) DEFAULT NULL,
                            `riskmngmt_solution_risk` int(11) DEFAULT NULL,
                            PRIMARY KEY (`riskmngmt_solution_id`),
                            KEY `riskmngmt_solution_cause` (`riskmngmt_solution_cause`),
                            KEY `riskmngmt_solution_risk` (`riskmngmt_solution_risk`)
                        )ENGINE=InnoDB  DEFAULT CHARSET=utf8;'
                )->execute();

                $dbPool->get()->con->prepare(
                    'ALTER TABLE `' . $dbPool->get()->prefix . 'riskmngmt_solution`
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'riskmngmt_solution_ibfk_1` FOREIGN KEY (`riskmngmt_solution_cause`) REFERENCES `' . $dbPool->get()->prefix . 'riskmngmt_cause` (`riskmngmt_cause_id`),
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'riskmngmt_solution_ibfk_2` FOREIGN KEY (`riskmngmt_solution_risk`) REFERENCES `' . $dbPool->get()->prefix . 'riskmngmt_risk` (`riskmngmt_risk_id`);'
                )->execute();
                break;
        }
    }
}
