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
namespace Install;

use phpOMS\Account\GroupStatus;
use phpOMS\ApplicationAbstract;
use phpOMS\DataStorage\Database\DatabaseType;
use phpOMS\DataStorage\Database\DatabasePool;
use phpOMS\Module\ModuleManager;
use phpOMS\Account\PermissionType;

/**
 * Installer class.
 *
 * @category   Install
 * @package    Framework
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
class Installer extends ApplicationAbstract
{

    /**
     * Database object.
     *
     * @var DatabasePool
     * @since 1.0.0
     */
    public $dbPool = null;

    /**
     * Constructor.
     *
     * @param DatabasePool $dbPool Database instance
     *
     * @since  1.0.0
     */
    public function __construct(DatabasePool $dbPool)
    {
        $this->dbPool = $dbPool;
    }

    public function cleanupPrevious()
    {
        if (file_exists($path = __DIR__ . '/../Web/Backend/Routes.php')) {
            unlink($path);
        }

        file_put_contents($path, '<?php return [];');

        if (file_exists($path = __DIR__ . '/../Web/Api/Routes.php')) {
            unlink($path);
        }

        file_put_contents($path, '<?php return [];');
    }

    /**
     * Install core tables.
     *
     * @since  1.0.0
     */
    public function installCore()
    {
        try {
            /* Create module table */
            $this->dbPool->get()->con->prepare(
                'CREATE TABLE if NOT EXISTS `' . $this->dbPool->get()->prefix . 'module` (
                            `module_id` varchar(255) NOT NULL,
                            `module_theme` varchar(100) DEFAULT NULL,
                            `module_path` varchar(50) NOT NULL,
                            `module_active` tinyint(1) NOT NULL DEFAULT 1,
                            `module_version` varchar(10) DEFAULT NULL,
                            PRIMARY KEY (`module_id`)
                        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;'
            )->execute();

            /* Create module load table */
            $this->dbPool->get()->con->prepare(
                'CREATE TABLE if NOT EXISTS `' . $this->dbPool->get()->prefix . 'module_load` (
                            `module_load_id` int(11) NOT NULL AUTO_INCREMENT,
                            `module_load_pid` varchar(40) NOT NULL,
                            `module_load_type` tinyint(1) NOT NULL,
                            `module_load_from` varchar(255) DEFAULT NULL,
                            `module_load_for` varchar(255) DEFAULT NULL,
                            `module_load_file` varchar(255) NOT NULL,
                            PRIMARY KEY (`module_load_id`),
                            KEY `module_load_from` (`module_load_from`)
                        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;'
            )->execute();

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Install the core module.
     *
     * @param array $modules Array of all module to install
     *
     * @return bool
     *
     * @since  1.0.0
     */
    public function installModules($modules)
    {
        try {
            $moduleManager = new ModuleManager($this, __DIR__ . '/../Modules');

            foreach ($modules as $module) {
                try {
                    $moduleManager->install($module);
                } catch (\Exception $e) {
                    echo $e->getMessage();
                }
            }

            return true;
        } catch (\Exception $e) {
            echo $e->getMessage();
            
            return false;
        }
    }

    /**
     * Setup the core group.
     *
     * @since  1.0.0
     */
    public function installGroups()
    {
        try {
            $date = new \DateTime('NOW', new \DateTimeZone('UTC'));

            switch ($this->dbPool->get()->getType()) {
                case DatabaseType::MYSQL:
                    $this->dbPool->get()->con->beginTransaction();

                    $this->dbPool->get()->con->prepare(
                        'INSERT INTO `' . $this->dbPool->get()->prefix . 'group` (`group_id`, `group_name`, `group_desc`, `group_status`, `group_created`) VALUES
                            (1000000000, \'guest\', NULL, ' . GroupStatus::ACTIVE . ', \'' . $date->format('Y-m-d H:i:s') . '\'),
                            (1000101000, \'user\', NULL, ' . GroupStatus::ACTIVE . ', \'' . $date->format('Y-m-d H:i:s') . '\'),
                            (1000102000, \'admin\', NULL, ' . GroupStatus::ACTIVE . ', \'' . $date->format('Y-m-d H:i:s') . '\'),
                            (1000103000, \'support\', NULL, ' . GroupStatus::ACTIVE . ', \'' . $date->format('Y-m-d H:i:s') . '\'),
                            (1000104000, \'backend\', NULL, ' . GroupStatus::ACTIVE . ', \'' . $date->format('Y-m-d H:i:s') . '\'),
                            (1000105000, \'suspended\', NULL, ' . GroupStatus::ACTIVE . ', \'' . $date->format('Y-m-d H:i:s') . '\');'
                    )->execute();

                    $this->dbPool->get()->con->prepare(
                        'INSERT INTO `' . $this->dbPool->get()->prefix . 'group_permission` (`group_permission_group`, `group_permission_unit`, `group_permission_app`, `group_permission_module`, `group_permission_from`, `group_permission_type`, `group_permission_element`, `group_permission_component`, `group_permission_permission`) VALUES
                            (1000102000, 1, \'backend\', NULL, NULL, NULL, NULL, NULL, ' . (PermissionType::READ | PermissionType::CREATE | PermissionType::MODIFY | PermissionType::DELETE | PermissionType::PERMISSION) . ');'
                    )->execute();

                    $this->dbPool->get()->con->commit();
                    break;
            }

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Setup the admin user.
     *
     * @since  1.0.0
     */
    public function installUsers()
    {
        try {
            $date = new \DateTime('NOW', new \DateTimeZone('UTC'));

            switch ($this->dbPool->get()->getType()) {
                case DatabaseType::MYSQL:
                    $this->dbPool->get()->con->beginTransaction();
                    $this->dbPool->get()->con->prepare(
                        'INSERT INTO `' . $this->dbPool->get()->prefix . 'l11n` (`l11n_country`, `l11n_language`, `l11n_currency`, `l11n_number_thousand`, `l11n_number_decimal`, `l11n_angle`, `l11n_temperature`, `l11n_weight_very_light`, `l11n_weight_light`, `l11n_weight_medium`, `l11n_weight_heavy`, `l11n_weight_very_heavy`, `l11n_speed_very_slow`, `l11n_speed_slow`, `l11n_speed_medium`, `l11n_speed_fast`, `l11n_speed_very_fast`, `l11n_speed_sea`, `l11n_length_very_short`, `l11n_length_short`, `l11n_length_medium`, `l11n_length_long`, `l11n_length_very_long`, `l11n_length_sea`, `l11n_area_very_small`, `l11n_area_small`, `l11n_area_medium`, `l11n_area_large`, `l11n_area_very_large`, `l11n_volume_very_small`, `l11n_volume_small`, `l11n_volume_medium`, `l11n_volume_large`, `l11n_volume_very_large`, `l11n_volume_teaspoon`, `l11n_volume_tablespoon`, `l11n_volume_glass`) VALUES
                            (\'DE\', \'EN\', \'EUR\', \',\', \'.\', \'degree\', \'celsius\', \'mg\', \'g\', \'kg\', \'t\', \'t\', \'ms\', \'ms\', \'kph\', \'kph\', \'kph\', \'knot\', \'mm\', \'cm\', \'m\', \'km\', \'km\', \'mile\', \'mm\', \'cm\', \'m\', \'km\', \'km\', \'ml\', \'cl\', \'l\', \'l\', \'l\', \'metric teaspoon\', \'metric tablespoon\', \'metric glass\'), (\'DE\', \'EN\', \'EUR\', \',\', \'.\', \'degree\', \'celsius\', \'mg\', \'g\', \'kg\', \'t\', \'t\', \'ms\', \'ms\', \'kph\', \'kph\', \'kph\', \'knot\', \'mm\', \'cm\', \'m\', \'km\', \'km\', \'mile\', \'mm\', \'cm\', \'m\', \'km\', \'km\', \'ml\', \'cl\', \'l\', \'l\', \'l\', \'metric teaspoon\', \'metric tablespoon\', \'metric glass\');'
                    )->execute();

                    $this->dbPool->get()->con->prepare(
                        'INSERT INTO `' . $this->dbPool->get()->prefix . 'account` (`account_status`, `account_type`, `account_login`, `account_name1`, `account_name2`, `account_name3`, `account_password`, `account_email`, `account_tries`, `account_lactive`, `account_localization`, `account_created_at`) VALUES
                            (0, 0, \'admin\', \'Cherry\', \'Orange\', \'Orange Management\', \'' . password_hash('orange', PASSWORD_DEFAULT) . '\', \'admin@email.com\', 5, \'1000-01-01 00:00:00\', 2, \'' . $date->format('Y-m-d H:i:s') . '\');'
                    )->execute();

                    $this->dbPool->get()->con->prepare(
                        'INSERT INTO `' . $this->dbPool->get()->prefix . 'account_group` (`account_group_group`, `account_group_account`) VALUES
                            (1000101000, 1),
                            (1000102000, 1),
                            (1000104000, 1);'
                    )->execute();

                    $this->dbPool->get()->con->commit();
                    break;
            }

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Set all settings.
     *
     * @since  1.0.0
     */
    public function installSettings()
    {
        try {
            switch ($this->dbPool->get()->getType()) {
                case DatabaseType::MYSQL:
                    $this->dbPool->get()->con->beginTransaction();

                    $this->dbPool->get()->con->prepare(
                        'INSERT INTO `' . $this->dbPool->get()->prefix . 'settings` (`settings_id`, `settings_module`, `settings_name`, `settings_content`, `settings_group`) VALUES
                            (1000000001, NULL, \'username_length_max\', \'20\', NULL),
                            (1000000002, NULL, \'username_length_min\', \'5\', NULL),
                            (1000000003, NULL, \'password_length_max\', \'50\', NULL),
                            (1000000004, NULL, \'password_length_min\', \'5\', NULL),
                            (1000000005, NULL, \'login_tries\', \'3\', NULL),
                            (1000000006, NULL, \'pass_special\', \'1\', NULL),
                            (1000000007, NULL, \'pass_upper\', \'0\', NULL),
                            (1000000008, NULL, \'pass_numeric\', \'1\', NULL),
                            (1000000009, NULL, \'oname\', \'Orange Management\', NULL),
                            (1000000010, NULL, \'theme\', \'oms-slim\', NULL),
                            (1000000011, NULL, \'theme_path\', \'/oms-slim\', NULL),
                            (1000000012, NULL, \'changed\', \'1\', NULL),
                            (1000000013, NULL, \'login_status\', \'1\', NULL),
                            (1000000014, NULL, \'login_msg\', \'Maintenance scheduled for tomorrow from 11:00 am to 1:00 pm.\', NULL),
                            (1000000015, NULL, \'use_cache\', \'0\', NULL),
                            (1000000016, NULL, \'last_recache\', \'0000-00-00 00:00:00\', NULL),
                            (1000000017, NULL, \'public_access\', \'0\', NULL),
                            (1000000018, NULL, \'rewrite\', \'0\', NULL),
                            (1000000019, NULL, \'country\', \'DE\', NULL),
                            (1000000020, NULL, \'language\', \'en\', NULL),
                            (1000000021, NULL, \'timezone\', \'Europe/Berlin\', NULL),
                            (1000000022, NULL, \'timeformat\', \'DD.MM.YYYY hh:mm:ss\', NULL),
                            (1000000023, NULL, \'currency\', \'USD\', NULL),
                            (1000000024, NULL, \'pass_lower\', \'1\', NULL),
                            (1000000025, NULL, \'mail_admin\', \'mail@admin.com\', NULL),
                            (1000000026, NULL, \'login_name\', \'1\', NULL),
                            (1000000027, NULL, \'decimal_point\', \'.\', NULL),
                            (1000000028, NULL, \'thousands_sep\', \',\', NULL),
                            (1000000029, NULL, \'server_language\', \'en\', NULL)'
                    )->execute();

                    $this->dbPool->get()->con->commit();
                    break;
            }

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function error()
    {
        var_dump($this->dbPool->get()->con->errorInfo());
    }
}
