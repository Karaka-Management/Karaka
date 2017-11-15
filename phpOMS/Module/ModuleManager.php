<?php
/**
 * Orange Management
 *
 * PHP Version 7.1
 *
 * @category   Framework
 * @package    phpOMS\Module
 * @copyright  Dennis Eichhorn
 * @license    OMS License 1.0
 * @version    1.0.0
 * @link       http://website.orange-management.de
 */
declare(strict_types = 1);

namespace phpOMS\Module;

use phpOMS\ApplicationAbstract;
use phpOMS\Autoloader;
use phpOMS\DataStorage\Database\DatabaseType;
use phpOMS\Message\Http\Request;
use phpOMS\System\File\PathException;
use phpOMS\Module\Exception\InvalidModuleException;

/**
 * Modules class.
 *
 * General module functionality such as listings and initialization.
 *
 * @category   Framework
 * @package    phpOMS\Module
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
class ModuleManager
{

    /**
     * All modules that are running on this uri.
     *
     * @var \phpOMS\Module\ModuleAbstract[]
     * @since 1.0.0
     */
    private $running = [];

    /**
     * Application instance.
     *
     * @var ApplicationAbstract
     * @since 1.0.0
     */
    private $app = null;

    /**
     * Installed modules.
     *
     * @var array
     * @since 1.0.0
     */
    private $installed = null;

    /**
     * All active modules (on all pages not just the ones that are running now).
     *
     * @var array
     * @since 1.0.0
     */
    private $active = null;

    /**
     * Module path.
     *
     * @var string
     * @since 1.0.0
     */
    private $modulePath = __DIR__ . '/../../Modules';

    /**
     * All modules in the module directory.
     *
     * @var array
     * @since 1.0.0
     */
    private $all = null;

    /**
     * To load based on request uri.
     *
     * @var array
     * @since 1.0.0
     */
    private $uriLoad = null;

    /**
     * Constructor.
     *
     * @param ApplicationAbstract $app Application
     * @param string $modulePath Path to modules
     *
     * @since  1.0.0
     */
    public function __construct(ApplicationAbstract $app, string $modulePath = '')
    {
        $this->app = $app;
        $this->modulePath = $modulePath;
    }

    /**
     * Get language files.
     *
     * @param Request $request Request
     *
     * @return array
     *
     * @since  1.0.0
     */
    public function getLanguageFiles(Request $request) : array
    {
        $files = $this->getUriLoad($request);

        $lang = [];
        if (isset($files[5])) {
            foreach ($files[5] as $module) {
                $lang[] = '/Modules/' . $module['module_load_from'] . '/Theme/' . $this->app->appName . '/Lang/' . $module['module_load_file'];
            }
        }

        return $lang;
    }

    /**
     * Get modules that run on this page.
     *
     * @param Request $request Request
     *
     * @return array
     *
     * @since  1.0.0
     */
    public function getUriLoad(Request $request) : array
    {
        if (!isset($this->uriLoad)) {
            switch ($this->app->dbPool->get('select')->getType()) {
                case DatabaseType::MYSQL:
                    $uriHash = $request->getHash();
                    $uriPdo  = '';

                    $i = 1;
                    $c = count($uriHash);
                    
                    for ($k = 0; $k < $c; $k++) {
                        $uriPdo .= ':pid' . $i . ',';
                        $i++;
                    }

                    $uriPdo = rtrim($uriPdo, ',');

                    /* TODO: make join in order to see if they are active */
                    $sth = $this->app->dbPool->get('select')->con->prepare(
                        'SELECT
                    `' . $this->app->dbPool->get('select')->prefix . 'module_load`.`module_load_type`, `' . $this->app->dbPool->get('select')->prefix . 'module_load`.*
                    FROM
                    `' . $this->app->dbPool->get('select')->prefix . 'module_load`
                    WHERE
                    `module_load_pid` IN(' . $uriPdo . ')'
                    );

                    $i = 1;
                    foreach ($uriHash as $hash) {
                        $sth->bindValue(':pid' . $i, $hash, \PDO::PARAM_STR);
                        $i++;
                    }

                    $sth->execute();

                    $this->uriLoad = $sth->fetchAll(\PDO::FETCH_GROUP);
            }
        }

        return $this->uriLoad;
    }

    /**
     * Get all installed modules that are active (not just on this uri).
     * 
     * @param bool $useCache Use Cache or load new
     *
     * @return array
     *
     * @since  1.0.0
     */
    public function getActiveModules(bool $useCache = true) : array
    {
        if ($this->active === null || !$useCache) {
            switch ($this->app->dbPool->get('select')->getType()) {
                case DatabaseType::MYSQL:
                    $sth = $this->app->dbPool->get('select')->con->prepare('SELECT `module_path` FROM `' . $this->app->dbPool->get('select')->prefix . 'module` WHERE `module_active` = 1');
                    $sth->execute();
                    $this->active = $sth->fetchAll(\PDO::FETCH_COLUMN);
                    break;
            }
        }

        return $this->active;
    }

    public function isActive(string $module) : bool
    {
        return in_array($module, $this->getActiveModules(false));
    }

    /**
     * Get all modules in the module directory.
     *
     * @return array
     *
     * @since  1.0.0
     */
    public function getAllModules() : array
    {
        if (!isset($this->all)) {
            chdir($this->modulePath);
            $files = glob('*', GLOB_ONLYDIR);
            $c     = count($files);

            for ($i = 0; $i < $c; $i++) {
                $path = $this->modulePath . '/' . $files[$i] . '/info.json';

                if (!file_exists($path)) {
                    continue;
                    // throw new PathException($path);
                }

                $json                                 = json_decode(file_get_contents($path), true);
                $this->all[$json['name']['internal']] = $json;
            }
        }

        return $this->all;
    }

    /**
     * Get modules that are available from official resources.
     *
     * @return array
     *
     * @since  1.0.0
     */
    public function getAvailableModules() : array
    {
        return [];
    }

    /**
     * Get all installed modules.
     * 
     * @param bool $useCache Use Cache
     *
     * @return array
     *
     * @since  1.0.0
     */
    public function getInstalledModules(bool $useCache = true) : array
    {
        if ($this->installed === null || !$useCache) {
            switch ($this->app->dbPool->get('select')->getType()) {
                case DatabaseType::MYSQL:
                    $sth = $this->app->dbPool->get('select')->con->prepare('SELECT `module_id`,`module_theme`,`module_version` FROM `' . $this->app->dbPool->get('select')->prefix . 'module`');
                    $sth->execute();
                    $this->installed = $sth->fetchAll(\PDO::FETCH_GROUP);
                    break;
            }
        }

        return $this->installed;
    }

    /**
     * Load info of module.
     *
     * @param string $module Module name
     *
     * @return InfoManager
     *
     * @since  1.0.0
     */
    private function loadInfo(string $module) : InfoManager
    {
        $path = realpath($oldPath = $this->modulePath . '/' . $module . '/' . 'info.json');

        if ($path === false) {
            throw new PathException($oldPath);
        }

        $info = new InfoManager($path);
        $info->load();

        return $info;
    }

    /**
     * Deactivate module.
     *
     * @param string $module Module name
     *
     * @return bool
     *
     * @since  1.0.0
     */
    public function deactivate(string $module) : bool
    {
        $installed = $this->getInstalledModules(false);

        if (!isset($installed[$module])) {
            return false;
        }

        try {
            $info = $this->loadInfo($module);

            $this->deactivateModule($info);

            return true;
        } catch (PathException $e) {
            // todo: handle module doesn't exist or files are missing
            //echo $e->getMessage();

            return false;
        } catch (\Exception $e) {
            //echo $e->getMessage();

            return false;
        }
    }

    /**
     * Deactivate module.
     *
     * @param InfoManager $info Module info
     *
     * @return void
     *
     * @throws InvalidModuleException Throws this exception in case the deactiviation doesn't exist
     *
     * @since  1.0.0
     */
    private function deactivateModule(InfoManager $info) /* : void */
    {
        $class = '\\Modules\\' . $info->getDirectory() . '\\Admin\\Deactivate';

        if (!Autoloader::exists($class)) {
            throw new InvalidModuleException($info->getDirectory());
        }

        /** @var $class DeactivateAbstract */
        $class::deactivate($this->app->dbPool, $info);
    }

    /**
     * Deactivate module.
     *
     * @param string $module Module name
     *
     * @return bool
     *
     * @since  1.0.0
     */
    public function activate(string $module) : bool
    {
        $installed = $this->getInstalledModules(false);

        if (!isset($installed[$module])) {
            return false;
        }

        try {
            $info = $this->loadInfo($module);

            $this->activateModule($info);

            return true;
        } catch (PathException $e) {
            // todo: handle module doesn't exist or files are missing
            //echo $e->getMessage();

            return false;
        } catch (\Exception $e) {
            //echo $e->getMessage();

            return false;
        }
    }

    /**
     * Activate module.
     *
     * @param InfoManager $info Module info
     *
     * @return void
     *
     * @throws InvalidModuleException Throws this exception in case the activation doesn't exist
     *
     * @since  1.0.0
     */
    private function activateModule(InfoManager $info) /* : void */
    {
        $class = '\\Modules\\' . $info->getDirectory() . '\\Admin\\Activate';

        if (!Autoloader::exists($class)) {
            throw new InvalidModuleException($info->getDirectory());
        }

        /** @var $class ActivateAbstract */
        $class::activate($this->app->dbPool, $info);
    }

    /**
     * Re-init module.
     *
     * @param string $module Module name
     *
     * @return void
     *
     * @throws InvalidModuleException Throws this exception in case the installer doesn't exist
     *
     * @since  1.0.0
     */
    public function reInit(string $module) /* : void */
    {
        $info = $this->loadInfo($module);
        $class = '\\Modules\\' . $info->getDirectory() . '\\Admin\\Installer';

        if (!Autoloader::exists($class)) {
            throw new InvalidModuleException($info->getDirectory());
        }

        /** @var $class InstallerAbstract */
        $class::reInit($this->modulePath, $info);
    }

    /**
     * Install module.
     *
     * @param string $module Module name
     *
     * @return bool
     *
     * @since  1.0.0
     */
    public function install(string $module) : bool
    {
        $installed = $this->getInstalledModules(false);

        if (isset($installed[$module])) {
            return false;
        }

        if (!file_exists($this->modulePath . '/' . $module . '/Admin/Installer.php')) {
            // todo download;
            return false;
        }

        try {
            $info = $this->loadInfo($module);

            $this->installed[$module] = $info;
            $this->installDependencies($info->getDependencies());
            $this->installModule($info);

            /* Install providing */
            $providing = $info->getProviding();
            foreach ($providing as $key => $version) {
                $this->installProviding($module, $key);
            }

            /* Install receiving */
            foreach ($installed as $key => $value) {
                $this->installProviding($key, $module);
            }

            return true;
        } catch (PathException $e) {
            return false;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Install module dependencies.
     *
     * @param array $dependencies Module dependencies
     *
     * @return void
     *
     * @since  1.0.0
     */
    private function installDependencies(array $dependencies) /* : void */
    {
        foreach ($dependencies as $key => $version) {
            $this->install($key);
        }
    }

    /**
     * Install module itself.
     *
     * @param InfoManager $info Module info
     *
     * @return void
     *
     * @throws InvalidModuleException Throws this exception in case the installer doesn't exist
     *
     * @since  1.0.0
     */
    private function installModule(InfoManager $info) /* : void */
    {
        $class = '\\Modules\\' . $info->getDirectory() . '\\Admin\\Installer';

        if (!Autoloader::exists($class)) {
            throw new InvalidModuleException($info->getDirectory());
        }

        /** @var $class InstallerAbstract */
        $class::install($this->modulePath, $this->app->dbPool, $info);
    }

    /**
     * Install providing.
     *
     * Installing additional functionality for another module
     *
     * @param string $from From module
     * @param string $for  For module
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function installProviding(string $from, string $for) /* : void */
    {
        if (file_exists($this->modulePath . '/' . $from . '/Admin/Install/' . $for . '.php')) {
            $class = '\\Modules\\' . $from . '\\Admin\\Install\\' . $for;
            /** @var $class InstallerAbstract */
            $class::install($this->modulePath, $this->app->dbPool, null);
        }
    }

    /**
     * Get module instance.
     *
     * @param string $module Module name
     *
     * @return \phpOMS\Module\ModuleAbstract
     *
     * @throws \Exception
     *
     * @since  1.0.0
     */
    public function get(string $module) : ModuleAbstract
    {
        try {
            if (!isset($this->running[$module])) {
                $this->initModule($module);
            }

            return $this->running[$module];
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Initialize module.
     *
     * @param string|array $modules Module name
     *
     * @return void
     *
     * @throws \InvalidArgumentException
     *
     * @since  1.0.0
     */
    public function initModule($modules) /* : void */
    {
        $modules = (array) $modules;

        foreach ($modules as $module) {
            try {
                $this->initModuleController($module);
            } catch (\InvalidArgumentException $e) {
                throw $e;
            }
        }
    }

    /**
     * Initialize module.
     *
     * Also registers controller in the dispatcher
     *
     * @param string $module Module
     *
     * @return void
     *
     * @throws \Exception
     *
     * @since  1.0.0
     */
    private function initModuleController(string $module) /* : void */
    {
        try {
            $this->running[$module] = ModuleFactory::getInstance($module, $this->app);
            $this->app->dispatcher->set($this->running[$module], '\Modules\\' . $module . '\\Controller');
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Initialize all modules for a request.
     *
     * @param Request $request Request
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function initRequestModules(Request $request) /* : void */
    {
        $toInit = $this->getRoutedModules($request);

        foreach ($toInit as $module) {
            $this->initModuleController($module);
        }
    }

    /**
     * Get modules that run on this page.
     *
     * @param Request $request Request
     *
     * @return array
     *
     * @since  1.0.0
     */
    public function getRoutedModules(Request $request) : array
    {
        $files   = $this->getUriLoad($request);
        $modules = [];

        if (isset($files[4])) {
            foreach ($files[4] as $module) {
                $modules[] = $module['module_load_file'];
            }
        }

        return $modules;
    }
}
