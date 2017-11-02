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
namespace Modules\Auditor\Admin;

use phpOMS\DataStorage\Database\DatabaseType;
use phpOMS\DataStorage\Database\DatabasePool;
use phpOMS\Module\InfoManager;
use phpOMS\Module\InstallerAbstract;

/**
 * Auditor install class.
 *
 * @category   Modules
 * @package    Modules\Auditor
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
                    'CREATE TABLE if NOT EXISTS `' . $dbPool->get()->prefix . 'auditor_audit` (
                        `auditor_audit_id` int(11) NOT NULL AUTO_INCREMENT,
                        `auditor_audit_module` int(11) NOT NULL,
                        `auditor_audit_ref` int(11) NOT NULL,
                        `auditor_audit_type` smallint(3) NOT NULL,
                        `auditor_audit_subtype` smallint(3) NOT NULL,
                        `auditor_audit_content` text NOT NULL,
                        `auditor_audit_old` text NOT NULL,
                        `auditor_audit_new` text NOT NULL,
                        `auditor_audit_created_at` datetime NOT NULL,
                        `auditor_audit_created_by` int(11) NOT NULL,
                        `auditor_audit_ip` int(11) NOT NULL,
                        PRIMARY KEY (`auditor_audit_id`),
                        KEY `auditor_audit_created_by` (`auditor_audit_created_by`)
                    )ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;'
                )->execute();

                $dbPool->get()->con->prepare(
                    'ALTER TABLE `' . $dbPool->get()->prefix . 'auditor_audit`
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'auditor_audit_ibfk_1` FOREIGN KEY (`auditor_audit_created_by`) REFERENCES `' . $dbPool->get()->prefix . 'account` (`account_id`);'
                )->execute();
                break;
        }
    }
}
