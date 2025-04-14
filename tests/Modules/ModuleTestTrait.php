<?php
/**
 * Jingga
 *
 * PHP Version 8.2
 *
 * @package   tests
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.2
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

namespace tests\Modules;

use Model\CoreSettings;
use Modules\Admin\Models\ModuleStatusUpdateType;
use phpOMS\Account\AccountManager;
use phpOMS\Application\ApplicationAbstract;
use phpOMS\Autoloader;
use phpOMS\DataStorage\Database\Query\Builder;
use phpOMS\DataStorage\Database\Schema\Builder as SchemaBuilder;
use phpOMS\DataStorage\Session\HttpSession;
use phpOMS\Dispatcher\Dispatcher;
use phpOMS\Event\EventManager;
use phpOMS\Localization\L11nManager;
use phpOMS\Message\Http\HttpRequest;
use phpOMS\Message\Http\HttpResponse;
use phpOMS\Module\ModuleManager;
use phpOMS\Router\WebRouter;
use phpOMS\Uri\HttpUri;
use phpOMS\Utils\ArrayUtils;
use phpOMS\Validation\Base\Json;
use phpOMS\Version\Version;

trait ModuleTestTrait
{
    protected ApplicationAbstract $app;

    protected const LANGUAGES = ['en', 'de'];

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
     * @slowThreshold 5000
     */
    #[\PHPUnit\Framework\Attributes\Group('admin')]
    #[\PHPUnit\Framework\Attributes\Group('module')]
    public function testModuleIntegration() : void
    {
        $iResponse                 = new HttpResponse();
        $iRequest                  = new HttpRequest();
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

    #[\PHPUnit\Framework\Attributes\Group('module')]
    #[\PHPUnit\Framework\Attributes\CoversNothing]
    public function testMembers() : void
    {
        $module = $this->app->moduleManager->get(self::NAME);

        if ($module::ID === 0) {
            return;
        }

        self::assertEquals(self::NAME, $module::NAME);
        self::assertGreaterThanOrEqual(0, Version::compare($module::VERSION, '1.0.0'));
    }

    #[\PHPUnit\Framework\Attributes\Group('module')]
    #[\PHPUnit\Framework\Attributes\CoversNothing]
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

    #[\PHPUnit\Framework\Attributes\Group('module')]
    #[\PHPUnit\Framework\Attributes\CoversNothing]
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

            $columns   = $class::COLUMNS;
            $ownsOne   = $class::OWNS_ONE;
            $belongsTo = $class::HAS_MANY;
            $hasMany   = $class::HAS_MANY;

            $relations = \array_merge($ownsOne, $belongsTo, $hasMany);

            $classReflection   = new \ReflectionClass(\substr($class, 0, -6));
            $defaultProperties = $classReflection->getDefaultProperties();

            $invalidAcessors = [];

            foreach ($relations as $column => $relation) {
                if (!$classReflection->hasProperty($column)) {
                    self::assertTrue(false, 'Mapper "' . $class . '" column "' . $column . '" has missing/invalid internal/member');
                }

                $property = $classReflection->getProperty($column) ?? null;
                if ($property === null || (!$property->isPublic() && (!isset($relation['private']) || !$relation['private']))) {
                    $invalidAcessors[] = $column;
                }
            }

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

                $property = $classReflection->getProperty($column['internal']) ?? null;
                if ($property === null || (!$property->isPublic() && (!isset($column['private']) || !$column['private']))) {
                    $invalidAcessors[] = $column['internal'];
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

            if (!empty($invalidAcessors)) {
                self::assertTrue(false, 'Mapper "' . $class . '" must define private for "' . \implode(',', $invalidAcessors) . '" or make them public (recommended) in the model');
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

    #[\PHPUnit\Framework\Attributes\Group('module')]
    #[\PHPUnit\Framework\Attributes\CoversNothing]
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

                if (!\str_starts_with($column['type'] ?? '', 'TINYINT')
                    && !\str_starts_with($column['type'] ?? '', 'SMALLINT')
                    && !\str_starts_with($column['type'] ?? '', 'INT')
                    && !\str_starts_with($column['type'] ?? '', 'BIGINT')
                    && !\str_starts_with($column['type'] ?? '', 'VARCHAR')
                    && !\str_starts_with($column['type'] ?? '', 'VARBINARY')
                    && !\str_starts_with($column['type'] ?? '', 'TEXT')
                    && !\str_starts_with($column['type'] ?? '', 'LONGTEXT')
                    && !\str_starts_with($column['type'] ?? '', 'BLOB')
                    && !\str_starts_with($column['type'] ?? '', 'DATETIME')
                    && !\str_starts_with($column['type'] ?? '', 'DECIMAL')
                ) {
                    self::assertTrue(false, 'Schema "' . $schemaPath . '" type "' . ($column['type'] ?? '') . '" is a missing/invalid type');
                }
            }
        }

        $dbTemplate = \json_decode(\file_get_contents(__DIR__ . '/../../phpOMS/DataStorage/Database/tableDefinition.json'), true);
        self::assertTrue(Json::validateTemplate($dbTemplate, $db), 'Invalid db template for ' . self::NAME);
    }

    #[\PHPUnit\Framework\Attributes\Group('module')]
    #[\PHPUnit\Framework\Attributes\CoversNothing]
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

    #[\PHPUnit\Framework\Attributes\Group('module')]
    #[\PHPUnit\Framework\Attributes\CoversNothing]
    public function testMapperAgainstDbSchema() : void
    {
        $mappers = \glob(__DIR__ . '/../../Modules/' . self::NAME . '/Models/*Mapper.php');
        $info    = \json_decode(\file_get_contents(__DIR__ . '/../../Modules/' . self::NAME . '/info.json'), true);

        $toCheck = [self::NAME];
        foreach ($info['dependencies'] as $dependency => $version) {
            $toCheck[] = $dependency;
        }

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

            foreach ($toCheck as $module) {
                $schemaPath = __DIR__ . '/../../Modules/' . $module . '/Admin/Install/db.json';
                if (!\is_file($schemaPath)) {
                    continue;
                }
                $db = \json_decode(\file_get_contents($schemaPath), true);

                $status = $this->helperMapperAgainstDbSchema($class, $table, $columns, $schemaPath, $db);
                if ($status === 0 || $status < -1) {
                    break;
                }
            }

            if ($status === -1) {
                self::assertTrue(false, 'Mapper "' . $class . '" table "' . $table . '" doesn\'t match schema');
            }

            if ($status < 0) {
                return;
            }
        }

        self::assertTrue(true);
    }

    private function helperMapperAgainstDbSchema(string $class, string $table, array $columns, string $schemaPath, array $db)
    {
        // testing existence of table name in schema
        if (!isset($db[$table])) {
            return -1;
        }

        foreach ($columns as $cName => $column) {
            // testing existence of field name in schema
            if (!isset($db[$table]['fields'][$cName])) {
                self::assertTrue(false, 'Mapper "' . $class . '" column "' . $cName . '" doesn\'t match schema');

                return -2;
            }

            // testing schema/mapper same column data type
            if (!(($column['type'] === 'string'
                    && (\str_starts_with($db[$table]['fields'][$cName]['type'], 'VARCHAR')
                        || \str_starts_with($db[$table]['fields'][$cName]['type'], 'VARBINARY')
                        || \str_starts_with($db[$table]['fields'][$cName]['type'], 'BLOB')
                        || \str_starts_with($db[$table]['fields'][$cName]['type'], 'TEXT')
                        || \str_starts_with($db[$table]['fields'][$cName]['type'], 'LONGTEXT')))
                || ($column['type'] === 'int'
                    && (\str_starts_with($db[$table]['fields'][$cName]['type'], 'TINYINT')
                        || \str_starts_with($db[$table]['fields'][$cName]['type'], 'SMALLINT')
                        || \str_starts_with($db[$table]['fields'][$cName]['type'], 'INT')
                        || \str_starts_with($db[$table]['fields'][$cName]['type'], 'BIGINT')))
                || ($column['type'] === 'Json'
                    && (\str_starts_with($db[$table]['fields'][$cName]['type'], 'VARCHAR')
                        || \str_starts_with($db[$table]['fields'][$cName]['type'], 'LONGTEXT')
                        || \str_starts_with($db[$table]['fields'][$cName]['type'], 'TEXT')))
                || ($column['type'] === 'compress'
                    && (\str_starts_with($db[$table]['fields'][$cName]['type'], 'BLOB')))
                || ($column['type'] === 'Serializable')
                || ($column['type'] === 'bool' && \str_starts_with($db[$table]['fields'][$cName]['type'], 'TINYINT'))
                || ($column['type'] === 'float' && \str_starts_with($db[$table]['fields'][$cName]['type'], 'DECIMAL'))
                || ($column['type'] === 'DateTime' && \str_starts_with($db[$table]['fields'][$cName]['type'], 'DATETIME'))
                || ($column['type'] === 'DateTimeImmutable' && \str_starts_with($db[$table]['fields'][$cName]['type'], 'DATETIME'))
            )) {
                self::assertTrue(false, 'Schema "' . $schemaPath . '" type "' . ($column['type'] ?? '') . '" is incompatible with mapper "' . $class . '" definition "' . $db[$table]['fields'][$cName]['type'] . '" for field "' . $cName . '"');

                return -3;
            }
        }

        // testing schema/mapper same primary key definition
        $primary = $class::PRIMARYFIELD;
        if (!($db[$table]['fields'][$primary]['primary'] ?? false)) {
            self::assertTrue(false, 'Field "' . $primary . '" from mapper "' . $class . '" is not defined as primary key in table "' . $table . '"');

            return -4;
        }

        return 0;
    }

    #[\PHPUnit\Framework\Attributes\Group('module')]
    #[\PHPUnit\Framework\Attributes\CoversNothing]
    public function testJson() : void
    {
        $sampleInfo   = \json_decode(\file_get_contents(__DIR__ . '/../../Modules/TestModule/info.json'), true);
        $infoTemplate = \json_decode(\file_get_contents(__DIR__ . '/../../phpOMS/Module/infoLayout.json'), true);

        $module = $this->app->moduleManager->get(self::NAME);

        if ($module::ID === 0) {
            return;
        }

        // validate info.json
        $info = \json_decode(\file_get_contents($module::PATH . '/info.json'), true);
        self::assertTrue($this->infoJsonTest($info, $sampleInfo), 'Info assert failed for '. self::NAME);
        self::assertTrue(Json::validateTemplate($infoTemplate, $info), 'Invalid info template for ' . self::NAME);
    }

    #[\PHPUnit\Framework\Attributes\Group('module')]
    #[\PHPUnit\Framework\Attributes\CoversNothing]
    public function testDependency() : void
    {
        $module = $this->app->moduleManager->get(self::NAME);

        if ($module::ID === 0) {
            return;
        }

        // validate dependency installation
        $info = \json_decode(\file_get_contents($module::PATH . '/info.json'), true);
        self::assertTrue($this->dependencyTest($info, $this->app->moduleManager->getInstalledModules(false)), 'Invalid dependency configuration in ' . self::NAME);
    }

    #[\PHPUnit\Framework\Attributes\Group('module')]
    #[\PHPUnit\Framework\Attributes\CoversNothing]
    public function testRoutes() : void
    {
        $this->app->moduleManager = new ModuleManager($this->app, __DIR__ . '/../../Modules/');
        $totalBackendRoutes       = \is_file(__DIR__ . '/../../Web/Backend/Routes.php') ? include __DIR__ . '/../../Web/Backend/Routes.php' : [];
        $totalApiRoutes           = \is_file(__DIR__ . '/../../Web/Api/Routes.php') ? include __DIR__ . '/../../Web/Api/Routes.php' : [];

        $module = $this->app->moduleManager->get(self::NAME);

        if ($module::ID === 0) {
            return;
        }

        // test routes
        if (\is_file($module::PATH . '/Admin/Routes/Web/Backend.php')) {
            $moduleRoutes = include $module::PATH . '/Admin/Routes/Web/Backend.php';
            self::assertEquals(
                [],
                $invalidRoutes = $this->routesTest($moduleRoutes, $totalBackendRoutes),
                'Backend route assert failed for '. self::NAME . ' (' . \implode(', ', $invalidRoutes) . ')'
            );
        }

        // test routes
        if (\is_file($module::PATH . '/Admin/Routes/Web/Api.php')) {
            $moduleRoutes = include $module::PATH . '/Admin/Routes/Web/Api.php';
            self::assertEquals(
                [],
                $invalidRoutes = $this->routesTest($moduleRoutes, $totalApiRoutes),
                'Api route assert failed for '. self::NAME . ' (' . \implode(', ', $invalidRoutes) . ')'
            );
        }
    }

    #[\PHPUnit\Framework\Attributes\Group('module')]
    #[\PHPUnit\Framework\Attributes\CoversNothing]
    public function testHooks() : void
    {
        $this->app->moduleManager = new ModuleManager($this->app, __DIR__ . '/../../Modules/');
        $totalBackendHooks        = \is_file(__DIR__ . '/../../Web/Backend/Hooks.php') ? include __DIR__ . '/../../Web/Backend/Hooks.php' : [];
        $totalApiHooks            = \is_file(__DIR__ . '/../../Web/Api/Hooks.php') ? include __DIR__ . '/../../Web/Api/Hooks.php' : [];

        $module = $this->app->moduleManager->get(self::NAME);

        if ($module::ID === 0) {
            return;
        }

        // test hooks
        if (\is_file($module::PATH . '/Admin/Hooks/Web/Backend.php')) {
            $moduleHooks = include $module::PATH . '/Admin/Hooks/Web/Backend.php';
            self::assertEquals(
                [],
                $invalidHooks = $this->hooksTest($moduleHooks, $totalBackendHooks),
                'Backend hook assert failed for '. self::NAME . ' (' . \implode(', ', $invalidHooks) . ')'
            );
        }

        // test hooks
        if (\is_file($module::PATH . '/Admin/Hooks/Web/Api.php')) {
            $moduleHooks = include $module::PATH . '/Admin/Hooks/Web/Api.php';
            self::assertEquals(
                [],
                $invalidHooks = $this->hooksTest($moduleHooks, $totalApiHooks),
                'Api hook assert failed for '. self::NAME . ' (' . \implode(', ', $invalidHooks) . ')'
            );
        }
    }

    #[\PHPUnit\Framework\Attributes\Group('final')]
    #[\PHPUnit\Framework\Attributes\Group('module')]
    #[\PHPUnit\Framework\Attributes\CoversNothing]
    public function testNavigation() : void
    {
        $module = $this->app->moduleManager->get(self::NAME);

        if ($module::ID === 0
            || $this->app->moduleManager->get('Navigation')::ID === 0
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
     * @return array
     */
    private function routesTest(array $module, array $total) : array
    {
        $invalid = [];
        foreach ($module as $route => $dests) {
            // test route existence after installation
            if (!isset($total[$route])) {
                $invalid[] = $route;
            }

            // test route class
            foreach ($dests as $verb) {
                $parts = \explode(':', $verb['dest']);
                $path  = __DIR__ . '/../../' . \ltrim(\strtr($parts[0], '\\', '/'), '/') . '.php';
                if (!\is_file($path)) {
                    $invalid[] = $verb['dest'];
                }

                // test route method
                $content = \file_get_contents($path);
                if ($content === false) {
                    continue;
                }

                if (\stripos($content, 'function ' . $parts[\count($parts) - 1]) === false
                    && \strpos($parts[\count($parts) - 1], 'Trait') === false
                ) {
                    $invlaid[] = $parts[\count($parts) - 1];
                }
            }
        }

        return $invalid;
    }

    /**
     * Test if hook destinations exist (in the *Controller and global application hook file)
     *
     * @param array $module Hooks of the module from the respective app and module hook file
     * @param array $total  Routing file of the respective application which contains all app routes
     *
     * @return array
     */
    private function hooksTest(array $module, array $total) : array
    {
        $invalid = [];
        foreach ($module as $route => $dests) {
            if (!isset($total[$route])) {
                $invalid[] = $route;
            }

            // test route class
            foreach ($dests['callback'] as $callback) {
                $parts = \explode(':', $callback);
                $path  = __DIR__ . '/../../' . \ltrim(\strtr($parts[0], '\\', '/'), '/') . '.php';
                if (!\is_file($path)) {
                    $invalid[] = $callback;
                }

                // test route method
                $content = \file_get_contents($path);
                if ($content === false) {
                    continue;
                }

                if (\stripos($content, 'function ' . $parts[\count($parts) - 1]) === false) {
                    $invlaid[] = $parts[\count($parts) - 1];
                }
            }
        }

        return $invalid;
    }

    /**
     * Test if the module info file has the correct types
     *
     * @param array $module Module info file
     * @param array $sample Sample info file (as basis for checking the data types)
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
                && \gettype($module['directory']) === \gettype($sample['directory'])
                && \gettype($module['dependencies']) === \gettype($sample['dependencies'])
                && \gettype($module['providing']) === \gettype($sample['providing'])
                && \gettype($module['load']) === \gettype($sample['load'])
            ) {
                return true;
            }
        } catch (\Throwable $_) {
            return false;
        }

        return false;
    }

    #[\PHPUnit\Framework\Attributes\Group('module')]
    #[\PHPUnit\Framework\Attributes\CoversNothing]
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

    #[\PHPUnit\Framework\Attributes\Group('module')]
    #[\PHPUnit\Framework\Attributes\CoversNothing]
    public function testLanguage() : void
    {
        $module = $this->app->moduleManager->get(self::NAME);
        if ($module::ID === 0) {
            return;
        }

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

            $langKeys = [];

            $langFiles = \scandir($module::PATH . '/Theme/' . $theme . '/Lang');
            foreach ($langFiles as $file) {
                if ($file === '.' || $file === '..' || \stripos($file, '.lang.') === false) {
                    continue;
                }

                $parts = \explode('.', $file);
                $type  = '';

                $type = \strlen($parts[0]) === 2 ? '' : $parts[0];

                if (!isset($langKeys[$type])) {
                    $langKeys[$type] = [
                        'required' => null,
                        'keys'     => [],
                    ];
                }

                // check if required languages files exist IFF any language file of a specific type exists
                if ($langKeys[$type]['required'] === null) {
                    $langKeys[$type]['required'] = true;

                    $missingLanguages = [];
                    foreach (self::LANGUAGES as $lang) {
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

                /** @var array $keys */
                $keys = \array_keys($langArray);

                $diff1 = [];
                $diff2 = [];

                if (empty($langKeys[$type]['keys'])) {
                    $langKeys[$type]['keys'] = $keys;
                } elseif (!empty($diff1 = \array_diff($langKeys[$type]['keys'], $keys))
                    || !empty($diff2 = \array_diff($keys, $langKeys[$type]['keys']))) {
                    self::assertTrue(false, $file . ': The language keys "' . \implode(', ', \array_merge($diff1, $diff2)) . '" are different.');
                }
            }
        }

        self::assertTrue(true);
    }

    #[\PHPUnit\Framework\Attributes\Group('module')]
    #[\PHPUnit\Framework\Attributes\CoversNothing]
    public function testNavigationLanguage() : void
    {
        $module = $this->app->moduleManager->get(self::NAME);
        if ($module::ID === 0) {
            return;
        }

        if (!\is_file($module::PATH . '/Admin/Install/Navigation.install.json')) {
            return;
        }

        $navigation = \json_decode(\file_get_contents($module::PATH . '/Admin/Install/Navigation.install.json'), true);

        if (!\is_dir($module::PATH . '/Theme')) {
            return;
        }

        $themes = \scandir($module::PATH . '/Theme');
        if ($themes === false) {
            return;
        }

        foreach ($themes as $theme) {
            if ($theme === '.' || $theme === '..' || !\is_file($module::PATH . '/Theme/' . $theme . '/Lang/Navigation.en.lang.php')) {
                continue;
            }

            $langFile = include $module::PATH . '/Theme/' . $theme . '/Lang/Navigation.en.lang.php';
            $found    = [];

            \array_walk_recursive($navigation, function ($item, $key) use (&$missing, $langFile) : void {
                if ($key !== 'name') {
                    return;
                }

                $found[] = $item;
            });

            if (!empty($diff = \array_diff($found, $langFile['Navigation']))) {
                self::assertTrue(false, 'Differences in Navigation language file and Navigation file: ' . \implode(',', $diff));
            }
        }

        self::assertTrue(true);
    }

    #[\PHPUnit\Framework\Attributes\Group('module')]
    #[\PHPUnit\Framework\Attributes\CoversNothing]
    public function testNullModelExistence() : void
    {
        $module = $this->app->moduleManager->get(self::NAME);
        if ($module::ID === 0) {
            return;
        }

        if (!\is_dir($module::PATH . '/Models')) {
            return;
        }

        $mappers = \scandir($module::PATH . '/Models');
        if ($mappers === false) {
            return;
        }

        foreach ($mappers as $mapper) {
            if ($mapper === '..' || $mapper === '.'
                || !\str_ends_with($mapper, 'Mapper.php')
            ) {
                continue;
            }

            $mapperContent = \file_get_contents($module::PATH . '/Models/' . $mapper);
            $model         = \substr($mapper, 0, -10);

            // Is either model with different name or model with same name in different path (use is used)
            if (\stripos($mapperContent, 'public const MODEL =') !== false
                && (\stripos($mapperContent, 'public const MODEL = ' . $model . '::class') === false
                    || \stripos($mapperContent, '\\' . $model . ';') !== false
                )
            ) {
                continue;
            }

            // Is most likely a helper mapper that is used for additional functions
            if (\stripos($mapperContent, 'public const COLUMNS =') === false
                && \stripos($mapperContent, 'public const HAS_MANY =') === false
                && \stripos($mapperContent, 'public const OWNS_ONE =') === false
                && \stripos($mapperContent, 'public const BELONGS_TO =') === false
            ) {
                continue;
            }

            if (!\is_file($module::PATH . '/Models/Null' . $model . '.php')) {
                self::assertTrue(false, 'Missing Null model for: ' . $mapper);
                return;
            }
        }

        self::assertTrue(true);
    }

    #[\PHPUnit\Framework\Attributes\Group('optional')]
    public function testTemplateLanguage() : void
    {
        // @todo Parts of this should be recursive because sometimes there are sub-directories
        //      One such example are Components
        //      Alternatively, use glob
        $module = $this->app->moduleManager->get(self::NAME);
        if ($module::ID === 0) {
            return;
        }

        if (!\is_dir($module::PATH . '/Theme')) {
            return;
        }

        $themes = \scandir($module::PATH . '/Theme');
        if ($themes === false) {
            return;
        }

        foreach ($themes as $theme) {
            if ($theme === '.' || $theme === '..') {
                continue;
            }

            $missingLanguage = [];
            $unusedLanguage  = [];

            $lang = [];

            if (empty($lang) && \is_dir($module::PATH . '/Theme/' . $theme . '/Lang')) {
                $lang = include $module::PATH . '/Theme/' . $theme . '/Lang/en.lang.php';
                $lang = $lang[self::NAME];

                $unusedLanguage = $lang;
            }

            $tpls = \scandir($module::PATH . '/Theme/' . $theme);
            if ($tpls === false) {
                return;
            }

            foreach ($unusedLanguage as $key => $_) {
                if (\str_starts_with($key, ':')) {
                    unset($unusedLanguage[$key]);
                }
            }

            foreach ($tpls as $tpl) {
                if ($tpl === '.' || $tpl === '..' || !\str_ends_with($tpl, '.tpl.php')) {
                    continue;
                }

                $fileContent = \file_get_contents($module::PATH . '/Theme/' . $theme . '/' . $tpl);

                // unused
                foreach ($unusedLanguage as $key => $_) {
                    if (\stripos($fileContent, '$this->getHtml(\'' . $key . '\')') !== false
                        || \stripos($fileContent, '$this->getHtml(\'' . $key . '\', \'' . self::NAME . '\')') !== false
                        || \stripos($fileContent, '$this->getHtml(\'' . $key . '\', \'' . self::NAME . '\', \'' . $theme . '\')') !== false
                    ) {
                        unset($unusedLanguage[$key]);
                    }
                }

                // in template
                $matches = [];
                \preg_match_all('/\$this\->getHtml\(\'([a-zA-Z0-9:\-]+?)\'\)/', $fileContent, $matches);
                foreach (($matches[1] ?? []) as $match) {
                    if (\stripos($match, ':') !== false) {
                        continue;
                    }

                    if(!isset($lang[$match])) {
                        $missingLanguage[] = $match;
                    }
                }
            }

            self::assertEquals([], $unusedLanguage ?? [], 'Unused language.');
            self::assertEquals([], $missingLanguage ?? [], 'Missing language from templates');
        }

        self::assertTrue(true);
    }

    #[\PHPUnit\Framework\Attributes\Group('optional')]
    public function testTemplates() : void
    {
        $module = $this->app->moduleManager->get(self::NAME);
        if ($module::ID === 0) {
            return;
        }

        if (!\is_dir($module::PATH . '/Theme')) {
            return;
        }

        $tpls = \scandir($module::PATH . '/Theme/Backend');
        if ($tpls === false) {
            return;
        }

        if (!\is_file($module::PATH . '/Controller/BackendController.php')) {
            return;
        }

        $backend = \file_get_contents($module::PATH . '/Controller/BackendController.php');
        $unused  = [];

        foreach ($tpls as $tpl) {
            if ($tpl === '.' || $tpl === '..'
                || !\str_ends_with($tpl, '.tpl.php') || \str_starts_with($tpl, '_')
            ) {
                continue;
            }

            if (\stripos($backend, \substr($tpl, 0, -8)) === false) {
                $unused[] = $tpl;
            }
        }

        self::assertEquals([], $unused ?? [], 'Unused template files: ' . \implode(',', $unused));
    }
}
