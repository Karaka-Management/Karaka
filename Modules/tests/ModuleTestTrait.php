<?php
/**
 * Karaka
 *
 * PHP Version 8.1
 *
 * @package   tests
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.0
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

namespace Modules\tests;

use Model\CoreSettings;
use Modules\Admin\Models\ModuleStatusUpdateType;
use phpOMS\Account\AccountManager;
use phpOMS\Application\ApplicationAbstract;
use phpOMS\DataStorage\Database\Query\Builder;
use phpOMS\DataStorage\Database\Schema\Builder as SchemaBuilder;
use phpOMS\DataStorage\Session\HttpSession;
use phpOMS\Dispatcher\Dispatcher;
use phpOMS\Event\EventManager;
use phpOMS\Localization\L11nManager;
use phpOMS\Message\Http\HttpRequest;
use phpOMS\Message\Http\HttpResponse;
use phpOMS\Module\ModuleManager;
use phpOMS\Module\NullModule;
use phpOMS\Router\WebRouter;
use phpOMS\Uri\HttpUri;
use phpOMS\Utils\ArrayUtils;
use phpOMS\Validation\Base\Json;
use phpOMS\Version\Version;

trait ModuleTestTrait
{
    protected ApplicationAbstract $app;

    /**
     * {@inheritdoc}
     */
    protected function setUp() : void
    {
        if (self::NAME === 'TestModule') {
            $this->markTestSkipped(
                'The TestModule is not tested'
            );
        }

        $this->app = new class() extends ApplicationAbstract
        {
            protected string $appName = 'Api';
        };

        $this->app->dbPool         = $GLOBALS['dbpool'];
        $this->app->router         = new WebRouter();
        $this->app->dispatcher     = new Dispatcher($this->app);
        $this->app->appSettings    = new CoreSettings();
        $this->app->moduleManager  = new ModuleManager($this->app, __DIR__ . '/../../Modules/');
        $this->app->sessionManager = new HttpSession(0);
        $this->app->accountManager = new AccountManager($this->app->sessionManager);
        $this->app->eventManager   = new EventManager($this->app->dispatcher);
        $this->app->l11nManager    = new L11nManager();
    }

    /**
     * @group admin
     * @slowThreshold 5000
     * @group module
     */
    public function testModuleIntegration() : void
    {
        $iResponse                 = new HttpResponse();
        $iRequest                  = new HttpRequest(new HttpUri(''));
        $iRequest->header->account = 1;
        $iRequest->setData('status', ModuleStatusUpdateType::INSTALL);

        $iRequest->setData('module', self::NAME);
        $this->app->moduleManager->get('Admin')->apiModuleStatusUpdate($iRequest, $iResponse);

        $iRequest->setData('status', ModuleStatusUpdateType::DEACTIVATE, true);
        $this->app->moduleManager->get('Admin')->apiModuleStatusUpdate($iRequest, $iResponse);
        self::assertFalse($this->app->moduleManager->isActive(self::NAME), 'Module "' . self::NAME . '" is not active.');

        $iRequest->setData('status', ModuleStatusUpdateType::ACTIVATE, true);
        $this->app->moduleManager->get('Admin')->apiModuleStatusUpdate($iRequest, $iResponse);
        self::assertTrue($this->app->moduleManager->isActive(self::NAME), 'Module "' . self::NAME . '" is not active.');
    }

    /**
     * @group module
     * @coversNothing
     */
    public function testMembers() : void
    {
        $module = $this->app->moduleManager->get(self::NAME);

        if ($module instanceof NullModule) {
            return;
        }

        self::assertEquals(self::NAME, $module::NAME);
        self::assertEquals(\realpath(__DIR__ . '/../../Modules/' . self::NAME), \realpath($module::PATH));
        self::assertGreaterThanOrEqual(0, Version::compare($module::VERSION, '1.0.0'));
    }

    /**
     * @group module
     * @coversNothing
     */
    public function testValidMapper() : void
    {
        $mappers = \glob(__DIR__ . '/../../Modules/' . self::NAME . '/Models/*Mapper.php');

        foreach ($mappers as $mapper) {
            $class   = $this->getMapperFromPath($mapper);
            $columns = $class::COLUMNS;

            foreach ($columns as $cName => $column) {
                if (!\in_array($column['type'], ['int', 'string', 'compress', 'DateTime', 'DateTimeImmutable', 'Json', 'Serializable', 'bool', 'float'])) {
                    self::assertTrue(false, 'Mapper "' . $class . '" column "' . $cName . '" has invalid type');
                }

                if ($cName !== ($column['name'] ?? false)) {
                    self::assertTrue(false);
                }
            }
        }

        self::assertTrue(true);
    }

    /**
     * Get mapper from file path
     *
     * @param string $mapper Mapper path
     *
     * @return string
     */
    private function getMapperFromPath(string $mapper) : string
    {
        $name = \substr($mapper, \strlen(__DIR__ . '/../../Modules/' . self::NAME . '/Models/'), -4);

        return '\\Modules\\' . self::NAME . '\\Models\\' . $name;
    }

    /**
     * @group module
     * @coversNothing
     */
    public function testMapperAgainstModel() : void
    {
        $mappers = \glob(__DIR__ . '/../../Modules/' . self::NAME . '/Models/*Mapper.php');

        foreach ($mappers as $mapper) {
            $class = $this->getMapperFromPath($mapper);
            if ($class === '\Modules\Admin\Models\ModuleMapper'
                || !Autoloader::exists(\substr($class, 0, -6))
            ) {
                continue;
            }

            $columns = $class::COLUMNS;
            $ownsOne = $class::OWNS_ONE;

            $classReflection   = new \ReflectionClass(\substr($class, 0, -6));
            $defaultProperties = $classReflection->getDefaultProperties();

            foreach ($columns as $cName => $column) {
                $isArray = false;
                // testing existence of member variable in model
                if (\stripos($column['internal'], '/') !== false) {
                    $column['internal'] = \explode('/', $column['internal'])[0];
                    $isArray            = true;
                }

                if (!$classReflection->hasProperty($column['internal'])) {
                    self::assertTrue(false, 'Mapper "' . $class . '" column "' . $cName . '" has missing/invalid internal/member');
                }

                // testing correct mapper/model variable type definition
                $property = $defaultProperties[$column['internal']] ?? null;
                if (!($property === null /* not every value is allowed to be null but this just has to be correctly implemented in the mapper, no additional checks for this case! */
                    || (\is_string($property) && ($column['type'] === 'string' || $column['type'] === 'compress'))
                    || (\is_int($property) && $column['type'] === 'int')
                    || (\is_array($property) && ($column['type'] === 'Json' || $column['type'] === 'Serializable' || $isArray))
                    || (\is_bool($property) && $column['type'] === 'bool')
                    || (\is_float($property) && $column['type'] === 'float')
                    || ($property instanceof \DateTime && $column['type'] === 'DateTime')
                    || ($property instanceof \DateTimeImmutable && $column['type'] === 'DateTimeImmutable')
                    || (isset($ownsOne[$column['internal']]) && $column['type'] === 'int') // if it is in ownsOne it can be a different type because it is a reference!
                )) {
                    self::assertTrue(false, 'Mapper "' . $class . '" column "' . $cName . '" has invalid type compared to model definition');
                }
            }

            // test hasMany variable exists in model
            $rel = $class::HAS_MANY;
            foreach ($rel as $pName => $def) {
                $property = $classReflection->getProperty($pName) ?? null;
                if (!\array_key_exists($pName, $defaultProperties) && $property === null) {
                    self::assertTrue(false, 'Mapper "' . $class . '" property "' . $pName . '" doesn\'t exist in model');
                }
            }
        }

        self::assertTrue(true);
    }

    /**
     * @group module
     * @coversNothing
     */
    public function testValidDbSchema() : void
    {
        $schemaPath = __DIR__ . '/../../Modules/' . self::NAME . '/Admin/Install/db.json';

        if (!\is_file($schemaPath)) {
            self::assertTrue(true);

            return;
        }

        $db = \json_decode(\file_get_contents($schemaPath), true);

        foreach ($db as $name => $table) {
            if ($name !== ($table['name'] ?? false)) {
                self::assertTrue(false, 'Schema "' . $schemaPath . '" name "' . $name . '" is invalid');
            }

            foreach ($table['fields'] as $cName => $column) {
                if ($cName !== ($column['name'] ?? false)) {
                    self::assertTrue(false, 'Schema "' . $schemaPath . '" name "' . $cName . '" is invalid');
                }

                if (!(\stripos($column['type'] ?? '', 'TINYINT') === 0
                    || \stripos($column['type'] ?? '', 'SMALLINT') === 0
                    || \stripos($column['type'] ?? '', 'INT') === 0
                    || \stripos($column['type'] ?? '', 'BIGINT') === 0
                    || \stripos($column['type'] ?? '', 'VARCHAR') === 0
                    || \stripos($column['type'] ?? '', 'VARBINARY') === 0
                    || \stripos($column['type'] ?? '', 'TEXT') === 0
                    || \stripos($column['type'] ?? '', 'LONGTEXT') === 0
                    || \stripos($column['type'] ?? '', 'BLOB') === 0
                    || \stripos($column['type'] ?? '', 'DATETIME') === 0
                    || \stripos($column['type'] ?? '', 'DECIMAL') === 0
                )) {
                    self::assertTrue(false, 'Schema "' . $schemaPath . '" type "' . ($column['type'] ?? '') . '" is a missing/invalid type');
                }
            }
        }

        $dbTemplate = \json_decode(\file_get_contents(__DIR__ . '/../../phpOMS/DataStorage/Database/tableDefinition.json'), true);
        self::assertTrue(Json::validateTemplate($dbTemplate, $db), 'Invalid db template for ' . self::NAME);
    }

    /**
     * @group module
     * @coversNothing
     */
    public function testDbSchemaAgainstDb() : void
    {
        $builder = new SchemaBuilder($this->app->dbPool->get());
        $tables  = $builder->selectTables()->execute()->fetchAll(\PDO::FETCH_COLUMN);

        $schemaPath = __DIR__ . '/../../Modules/' . self::NAME . '/Admin/Install/db.json';

        if (!\is_file($schemaPath)) {
            self::assertTrue(true);

            return;
        }

        $db = \json_decode(\file_get_contents($schemaPath), true);

        foreach ($db as $name => $table) {
            if (!\in_array($name, $tables)) {
                self::assertTrue(false, 'Table ' . $name . ' doesn\'t exist in the database.');
            }

            $field  = new SchemaBuilder($this->app->dbPool->get());
            $fields = $field->selectFields($name)->execute()->fetchAll();

            foreach ($table['fields'] as $cName => $column) {
                if (!ArrayUtils::inArrayRecursive($cName, $fields)) {
                    self::assertTrue(false, 'Couldn\'t find "' . $cName . '" in "' . $name . '"');
                }
            }
        }

        self::assertTrue(true);
    }

    /**
     * @group module
     * @coversNothing
     */
    public function testMapperAgainstDbSchema() : void
    {
        $schemaPath = __DIR__ . '/../../Modules/' . self::NAME . '/Admin/Install/db.json';
        $mappers    = \glob(__DIR__ . '/../../Modules/' . self::NAME . '/Models/*Mapper.php');

        if (!\is_file($schemaPath)) {
            self::assertTrue(true);

            return;
        }

        $db = \json_decode(\file_get_contents($schemaPath), true);

        foreach ($mappers as $mapper) {
            $class = $this->getMapperFromPath($mapper);

            if (\defined('self::MAPPER_TO_IGNORE') && \in_array(\ltrim($class, '\\'), self::MAPPER_TO_IGNORE)
                || empty($class::COLUMNS)
                || $class === '\Modules\Admin\Models\ModuleMapper'
            ) {
                continue;
            }

            $table   = $class::TABLE;
            $columns = $class::COLUMNS;

            foreach ($columns as $cName => $column) {
                // testing existence of field name in schema
                if (!isset($db[$table]['fields'][$cName])) {
                    self::assertTrue(false, 'Mapper "' . $class . '" column "' . $cName . '" doesn\'t match schema');
                }

                // testing schema/mapper same column data type
                if (!(($column['type'] === 'string'
                        && (\stripos($db[$table]['fields'][$cName]['type'], 'VARCHAR') === 0
                            || \stripos($db[$table]['fields'][$cName]['type'], 'VARBINARY') === 0
                            || \stripos($db[$table]['fields'][$cName]['type'], 'BLOB') === 0
                            || \stripos($db[$table]['fields'][$cName]['type'], 'TEXT') === 0
                            || \stripos($db[$table]['fields'][$cName]['type'], 'LONGTEXT') === 0))
                    || ($column['type'] === 'int'
                        && (\stripos($db[$table]['fields'][$cName]['type'], 'TINYINT') === 0
                            || \stripos($db[$table]['fields'][$cName]['type'], 'SMALLINT') === 0
                            || \stripos($db[$table]['fields'][$cName]['type'], 'INT') === 0
                            || \stripos($db[$table]['fields'][$cName]['type'], 'BIGINT') === 0))
                    || ($column['type'] === 'Json'
                        && (\stripos($db[$table]['fields'][$cName]['type'], 'VARCHAR') === 0
                            || \stripos($db[$table]['fields'][$cName]['type'], 'LONGTEXT') === 0
                            || \stripos($db[$table]['fields'][$cName]['type'], 'TEXT') === 0))
                    || ($column['type'] === 'compress'
                        && (\stripos($db[$table]['fields'][$cName]['type'], 'BLOB') === 0))
                    || ($column['type'] === 'Serializable')
                    || ($column['type'] === 'bool' && \stripos($db[$table]['fields'][$cName]['type'], 'TINYINT') === 0)
                    || ($column['type'] === 'float' && \stripos($db[$table]['fields'][$cName]['type'], 'DECIMAL') === 0)
                    || ($column['type'] === 'DateTime' && \stripos($db[$table]['fields'][$cName]['type'], 'DATETIME') === 0)
                    || ($column['type'] === 'DateTimeImmutable' && \stripos($db[$table]['fields'][$cName]['type'], 'DATETIME') === 0)
                )) {
                    self::assertTrue(false, 'Schema "' . $schemaPath . '" type "' . ($column['type'] ?? '') . '" is incompatible with mapper "' . $class . '" definition "' . $db[$table]['fields'][$cName]['type'] . '" for field "' . $cName . '"');
                }
            }

            // testing schema/mapper same primary key definition
            $primary = $class::PRIMARYFIELD;
            if (!($db[$table]['fields'][$primary]['primary'] ?? false)) {
                self::assertTrue(false, 'Field "' . $primary . '" from mapper "' . $class . '" is not defined as primary key in table "' . $table . '"');
            }
        }

        self::assertTrue(true);
    }

    /**
     * @group module
     * @coversNothing
     */
    public function testJson() : void
    {
        $sampleInfo    = \json_decode(\file_get_contents(__DIR__ . '/../TestModule/info.json'), true);
        $infoTemplate  = \json_decode(\file_get_contents(__DIR__ . '/../../phpOMS/Module/infoLayout.json'), true);

        $module = $this->app->moduleManager->get(self::NAME);

        if ($module instanceof NullModule) {
            return;
        }

        // validate info.json
        $info = \json_decode(\file_get_contents($module::PATH . '/info.json'), true);
        self::assertTrue($this->infoJsonTest($info, $sampleInfo), 'Info assert failed for '. self::NAME);
        self::assertTrue(Json::validateTemplate($infoTemplate, $info), 'Invalid info template for ' . self::NAME);
    }

    /**
     * @group module
     * @coversNothing
     */
    public function testDependency() : void
    {
        $module = $this->app->moduleManager->get(self::NAME);

        if ($module instanceof NullModule) {
            return;
        }

        // validate dependency installation
        $info = \json_decode(\file_get_contents($module::PATH . '/info.json'), true);
        self::assertTrue($this->dependencyTest($info, $this->app->moduleManager->getInstalledModules(false)), 'Invalid dependency configuration in ' . self::NAME);
    }

    /**
     * @group module
     * @coversNothing
     */
    public function testRoutes() : void
    {
        $this->app->moduleManager      = new ModuleManager($this->app, __DIR__ . '/../../Modules/');
        $totalBackendRoutes            = \is_file(__DIR__ . '/../../Web/Backend/Routes.php') ? include __DIR__ . '/../../Web/Backend/Routes.php' : [];
        $totalApiRoutes                = \is_file(__DIR__ . '/../../Web/Api/Routes.php') ? include __DIR__ . '/../../Web/Api/Routes.php' : [];

        $module = $this->app->moduleManager->get(self::NAME);

        if ($module instanceof NullModule) {
            return;
        }

        // test routes
        if (\is_file($module::PATH . '/Admin/Routes/Web/Backend.php')) {
            $moduleRoutes = include $module::PATH . '/Admin/Routes/Web/Backend.php';
            self::assertEquals(1, $this->routesTest($moduleRoutes, $totalBackendRoutes), 'Backend route assert failed for '. self::NAME);
        }

        // test routes
        if (\is_file($module::PATH . '/Admin/Routes/Web/Api.php')) {
            $moduleRoutes = include $module::PATH . '/Admin/Routes/Web/Api.php';
            self::assertEquals(1, $this->routesTest($moduleRoutes, $totalApiRoutes), 'Api route assert failed for '. self::NAME);
        }
    }

    /**
     * @group module
     * @coversNothing
     */
    public function testHooks() : void
    {
        $this->app->moduleManager     = new ModuleManager($this->app, __DIR__ . '/../../Modules/');
        $totalBackendHooks            = \is_file(__DIR__ . '/../../Web/Backend/Hooks.php') ? include __DIR__ . '/../../Web/Backend/Hooks.php' : [];
        $totalApiHooks                = \is_file(__DIR__ . '/../../Web/Api/Hooks.php') ? include __DIR__ . '/../../Web/Api/Hooks.php' : [];

        $module = $this->app->moduleManager->get(self::NAME);

        if ($module instanceof NullModule) {
            return;
        }

        // test hooks
        if (\is_file($module::PATH . '/Admin/Hooks/Web/Backend.php')) {
            $moduleHooks = include $module::PATH . '/Admin/Hooks/Web/Backend.php';
            self::assertEquals(1, $this->hooksTest($moduleHooks, $totalBackendHooks), 'Backend hook assert failed for '. self::NAME);
        }

        // test hooks
        if (\is_file($module::PATH . '/Admin/Hooks/Web/Api.php')) {
            $moduleHooks = include $module::PATH . '/Admin/Hooks/Web/Api.php';
            self::assertEquals(1, $this->hooksTest($moduleHooks, $totalApiHooks), 'Api hook assert failed for '. self::NAME);
        }
    }

    /**
     * @group final
     * @group module
     * @coversNothing
     */
    public function testNavigation() : void
    {
        $module = $this->app->moduleManager->get(self::NAME);

        if (($module instanceof NullModule)
            || ($this->app->moduleManager->get('Navigation') instanceof NullModule)
            || !\is_file($module::PATH . '/Admin/Install/Navigation.install.json')
        ) {
            return;
        }

        // test if navigation db entries match json files
        self::assertTrue(
            $this->navLinksTest(
                $this->app->dbPool->get(),
                \json_decode(
                    \file_get_contents($module::PATH . '/Admin/Install/Navigation.install.json'),
                    true
                ),
                self::NAME
            )
        );
    }

    /**
     * Test if all navigation links are in the database
     *
     * @param mixed  $db     Database connection
     * @param array  $links  Navigation links from install file
     * @param string $module Module name
     *
     * @return bool
     */
    private function navLinksTest($db, array $links, string $module) : bool
    {
        $query = new Builder($db);
        $query->select('nav_id')->from('nav')->where('nav_from', '=', $module);

        $result = $query->execute()->fetchAll(\PDO::FETCH_COLUMN);
        $it     = new \RecursiveIteratorIterator(new \RecursiveArrayIterator($links));

        foreach ($it as $link) {
            if (\is_array($link)
                && !\in_array($link['id'], $result)
            ) {
                return false;
            }
        }

        return true;
    }

    /**
     * Test if all dependencies got installed
     *
     * @param array $info    Module info array/file
     * @param array $modules Installed modules
     *
     * @return bool
     */
    private function dependencyTest(array $info, array $modules) : bool
    {
        foreach ($info['dependencies'] as $module => $version) {
            if (!isset($modules[$module])) {
                return false;
            }
        }

        return true;
    }

    /**
     * Test if route destinations exist (in the *Controller and global application route file)
     *
     * @param array $module Routes of the module from the respective app and module route file
     * @param array $total  Routing file of the respective application which contains all app routes
     *
     * @return int
     */
    private function routesTest(array $module, array $total) : int
    {
        foreach ($module as $route => $dests) {
            // test route existence after installation
            if (!isset($total[$route])) {
                return -1;
            }

            // test route class
            foreach ($dests as $verb) {
                $parts = \explode(':', $verb['dest']);
                $path  = __DIR__ . '/../../' . \ltrim(\str_replace('\\', '/', $parts[0]), '/') . '.php';
                if (!\is_file($path)) {
                    return -2;
                }

                // test route method
                $content = \file_get_contents($path);
                if (\stripos($content, 'function ' . $parts[\count($parts) - 1]) === false
                    && \strpos($parts[\count($parts) - 1], 'Trait') === false
                ) {
                    return -3;
                }
            }
        }

        return 1;
    }

    /**
     * Test if hook destinations exist (in the *Controller and global application hook file)
     *
     * @param array $module Hooks of the module from the respective app and module hook file
     * @param array $total  Routing file of the respective application which contains all app routes
     *
     * @return int
     */
    private function hooksTest(array $module, array $total) : int
    {
        foreach ($module as $route => $dests) {
            if (!isset($total[$route])) {
                return -1;
            }

            // test route class
            foreach ($dests['callback'] as $callback) {
                $parts = \explode(':', $callback);
                $path  = __DIR__ . '/../../' . \ltrim(\str_replace('\\', '/', $parts[0]), '/') . '.php';
                if (!\is_file($path)) {
                    return -2;
                }

                // test route method
                $content = \file_get_contents($path);
                if (\stripos($content, 'function ' . $parts[\count($parts) - 1]) === false) {
                    return -3;
                }
            }
        }

        return 1;
    }

    /**
     * Test if the module info file has the correct types
     *
     * @param array $module Module info file
     * @param array $samle  Sample info file (as basis for checking the data types)
     *
     * @return bool
     */
    private function infoJsonTest(array $module, array $sample) : bool
    {
        try {
            if (\gettype($module['name']['id']) === \gettype($sample['name']['id'])
                && \gettype($module['name']['internal']) === \gettype($sample['name']['internal'])
                && \gettype($module['name']['external']) === \gettype($sample['name']['external'])
                && \gettype($module['category']) === \gettype($sample['category'])
                && \gettype($module['version']) === \gettype($sample['version'])
                && \gettype($module['requirements']) === \gettype($sample['requirements'])
                && \gettype($module['creator']) === \gettype($sample['creator'])
                && \gettype($module['creator']['name']) === \gettype($sample['creator']['name'])
                && \gettype($module['description']) === \gettype($sample['description'])
                && \gettype($module['directory']) === \gettype($sample['directory'])
                && \gettype($module['dependencies']) === \gettype($sample['dependencies'])
                && \gettype($module['providing']) === \gettype($sample['providing'])
                && \gettype($module['load']) === \gettype($sample['load'])
            ) {
                return true;
            }
        } catch (\Throwable $e) {
            return false;
        }

        return false;
    }

    /**
     * @group module
     * @coversNothing
     */
    public function testRequestLoads() : void
    {
        if (!\defined('self::URI_LOAD') || empty(self::URI_LOAD)) {
            return;
        }

        $request = new HttpRequest(new HttpUri(self::URI_LOAD));
        $request->createRequestHashs(2);

        $loaded = $this->app->moduleManager->getUriLoad($request);

        $found = false;
        foreach ($loaded[4] as $module) {
            if ($module['module_load_file'] === self::NAME) {
                $found = true;
                break;
            }
        }

        self::assertTrue($found, 'Module ' . self::NAME . ' is not loaded at ' . self::URI_LOAD . '. The module info.json file ("load" section for type: 4 loads) and the routing files paths should match.');
        self::assertGreaterThan(0, \count($this->app->moduleManager->getLanguageFiles($request)));
        self::assertTrue(\in_array(self::NAME, $this->app->moduleManager->getRoutedModules($request)));

        $this->app->moduleManager->initRequestModules($request);
        self::assertTrue($this->app->moduleManager->isRunning(self::NAME));
    }

    /**
     * @group module
     * @coversNothing
     */
    public function testLanguage() : void
    {
        $module = $this->app->moduleManager->get(self::NAME);
        if ($module instanceof NullModule) {
            return;
        }

        $required = ['en', 'de'];
        $langKeys = [];

        if (!\is_dir($module::PATH . '/Theme')) {
            return;
        }

        $themes = \scandir($module::PATH . '/Theme');
        if ($themes === false) {
            return;
        }

        foreach ($themes as $theme) {
            if ($theme === '.' || $theme === '..' || !\is_dir($module::PATH . '/Theme/' . $theme . '/Lang')) {
                continue;
            }

            $langFiles = \scandir($module::PATH . '/Theme/' . $theme . '/Lang');
            foreach ($langFiles as $file) {
                if ($file === '.' || $file === '..' || \stripos($file, '.lang.') === false) {
                    continue;
                }

                $parts = \explode('.', $file);
                $type  = '';

                if (\strlen($parts[0]) === 2) {
                    $type = '';
                } else {
                    $type = $parts[0];
                }

                if (!isset($langKeys[$type])) {
                    $langKeys[$type] = [
                        'required' => null,
                        'keys'     => [],
                    ];
                }

                // check if required lanugages files exist IFF any language file of a specific type exists
                if ($langKeys[$type]['required'] === null) {
                    $langKeys[$type]['required'] = true;

                    $missingLanguages = [];
                    foreach ($required as $lang) {
                        if (!\in_array(($type !== '' ? $type . '.' : '') . $lang . '.lang.php', $langFiles)) {
                            $langKeys[$type]['required'] = false;
                            $missingLanguages[]          = $lang;
                        }
                    }

                    if (!empty($missingLanguages)) {
                        self::assertTrue(false, 'The language files "' . \implode(', ', $missingLanguages) . '" are missing with type "' . $type . '".');
                    }
                }

                // compare key equality
                // every key in the key list must be present in all other language files of the same type and vice versa
                $langArray = include $module::PATH . '/Theme/' . $theme . '/Lang/' . $file;
                $langArray = \reset($langArray);

                $keys = \array_keys($langArray);

                if (empty($langKeys[$type]['keys'])) {
                    $langKeys[$type]['keys'] = $keys;
                } else {
                    if (!empty($diff1 = \array_diff($langKeys[$type]['keys'], $keys))
                        || !empty($diff2 = \array_diff($keys, $langKeys[$type]['keys']))
                    ) {
                        self::assertTrue(false, $file . ': The language keys "' . \implode(', ', \array_merge($diff1, $diff2)) . '" are different.');
                    }
                }
            }
        }

        self::assertTrue(true);
    }
}
