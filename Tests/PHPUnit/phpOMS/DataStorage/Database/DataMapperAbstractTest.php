<?php
/**
 * Orange Management
 *
 * PHP Version 7.1
 *
 * @category   TBD
 * @package    TBD
 * @author     OMS Development Team <dev@oms.com>
 * @copyright  Dennis Eichhorn
 * @license    OMS License 1.0
 * @version    1.0.0
 * @link       http://website.orange-management.de
 */

namespace Tests\PHPUnit\phpOMS\DataStorage\Database;

use phpOMS\DataStorage\Database\Connection\MysqlConnection;
use phpOMS\DataStorage\Database\DatabaseStatus;
use phpOMS\DataStorage\Database\DatabasePool;

use Tests\PHPUnit\phpOMS\DataStorage\Database\TestModel\BaseModel;
use Tests\PHPUnit\phpOMS\DataStorage\Database\TestModel\BaseModelMapper;

require_once __DIR__ . '/../../../../../phpOMS/Autoloader.php';
require_once __DIR__ . '/../../../../../config.php';

class DataMapperAbstractTest extends \PHPUnit\Framework\TestCase
{
    protected $model = null;

    protected function setUp()
    {
        $this->model = new BaseModel();

        $GLOBALS['dbpool']->get()->con->prepare(
            'CREATE TABLE `oms_test_base` (
                `test_base_id` int(11) NOT NULL AUTO_INCREMENT,
                `test_base_string` varchar(254) NOT NULL,
                `test_base_int` int(11) NOT NULL,
                `test_base_bool` tinyint(1) DEFAULT NULL,
                `test_base_null` int(11) DEFAULT NULL,
                `test_base_float` decimal(5, 4) DEFAULT NULL,
                `test_base_belongs_to_one` int(11) DEFAULT NULL,
                `test_base_owns_one_self` int(11) DEFAULT NULL,
                `test_base_json` varchar(254) DEFAULT NULL,
                `test_base_json_serializable` varchar(254) DEFAULT NULL,
                `test_base_datetime` datetime DEFAULT NULL,
                PRIMARY KEY (`test_base_id`)
            )ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;'
        )->execute();

        $GLOBALS['dbpool']->get()->con->prepare(
            'CREATE TABLE `oms_test_belongs_to_one` (
                `test_belongs_to_one_id` int(11) NOT NULL AUTO_INCREMENT,
                `test_belongs_to_one_string` varchar(254) NOT NULL,
                PRIMARY KEY (`test_belongs_to_one_id`)
            )ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;'
        )->execute();

        $GLOBALS['dbpool']->get()->con->prepare(
            'CREATE TABLE `oms_test_owns_one` (
                `test_owns_one_id` int(11) NOT NULL AUTO_INCREMENT,
                `test_owns_one_string` varchar(254) NOT NULL,
                PRIMARY KEY (`test_owns_one_id`)
            )ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;'
        )->execute();

        $GLOBALS['dbpool']->get()->con->prepare(
            'CREATE TABLE `oms_test_has_many_direct` (
                `test_has_many_direct_id` int(11) NOT NULL AUTO_INCREMENT,
                `test_has_many_direct_string` varchar(254) NOT NULL,
                `test_has_many_direct_to` int(11) NOT NULL,
                PRIMARY KEY (`test_has_many_direct_id`)
            )ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;'
        )->execute();

        $GLOBALS['dbpool']->get()->con->prepare(
            'CREATE TABLE `oms_test_has_many_rel` (
                `test_has_many_rel_id` int(11) NOT NULL AUTO_INCREMENT,
                `test_has_many_rel_string` varchar(254) NOT NULL,
                PRIMARY KEY (`test_has_many_rel_id`)
            )ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;'
        )->execute();

        $GLOBALS['dbpool']->get()->con->prepare(
            'CREATE TABLE `oms_test_has_many_rel_relations` (
                `test_has_many_rel_relations_id` int(11) NOT NULL AUTO_INCREMENT,
                `test_has_many_rel_relations_src` int(11) NOT NULL,
                `test_has_many_rel_relations_dest` int(11) NOT NULL,
                PRIMARY KEY (`test_has_many_rel_relations_id`)
            )ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;'
        )->execute();
    }

    protected function  tearDown()
    {
        $GLOBALS['dbpool']->get()->con->prepare('DROP TABLE oms_test_base')->execute();
        $GLOBALS['dbpool']->get()->con->prepare('DROP TABLE oms_test_belongs_to_one')->execute();
        $GLOBALS['dbpool']->get()->con->prepare('DROP TABLE oms_test_owns_one')->execute();
        $GLOBALS['dbpool']->get()->con->prepare('DROP TABLE oms_test_has_many_direct')->execute();
        $GLOBALS['dbpool']->get()->con->prepare('DROP TABLE oms_test_has_many_rel')->execute();
        $GLOBALS['dbpool']->get()->con->prepare('DROP TABLE oms_test_has_many_rel_relations')->execute();
    }

    public function testCreate()
    {
        self::assertGreaterThan(0, BaseModelMapper::create($this->model));
        self::assertGreaterThan(0, $this->model->id);
    }

    public function testRead()
    {
        $id = BaseModelMapper::create($this->model);
        $modelR = BaseModelMapper::get($id);

        self::assertEquals($this->model->id, $modelR->id);
        self::assertEquals($this->model->string, $modelR->string);
        self::assertEquals($this->model->int, $modelR->int);
        self::assertEquals($this->model->bool, $modelR->bool);
        self::assertEquals($this->model->float, $modelR->float);
        self::assertEquals($this->model->null, $modelR->null);
        self::assertEquals($this->model->datetime->format('Y-m-d'), $modelR->datetime->format('Y-m-d'));

        // todo implement these
        //self::assertEquals('123', $modelR->serializable);
        //self::assertEquals($this->model->json, $modelR->json);
        //self::assertEquals([1, 2, 3], $modelR->jsonSerializable);

        self::assertEquals(2, count($modelR->hasManyDirect));
        self::assertEquals(2, count($modelR->hasManyRelations));
        self::assertEquals(reset($this->model->hasManyDirect)->string, reset($modelR->hasManyDirect)->string);
        self::assertEquals(reset($this->model->hasManyRelations)->string, reset($modelR->hasManyRelations)->string);
        self::assertEquals($this->model->ownsOneSelf->string, $modelR->ownsOneSelf->string);
        self::assertEquals($this->model->belongsToOne->string, $modelR->belongsToOne->string);
    }

    public function testUpdate()
    {
        $id = BaseModelMapper::create($this->model);
        $modelR = BaseModelMapper::get($id);

        $modelR->string = 'Update';
        $modelR->int = '321';
        $modelR->bool = true;
        $modelR->float = 3.15;
        $modelR->null = null;
        $modelR->datetime = new \DateTime('now');

        $id2 = BaseModelMapper::update($modelR);
        $modelR2 = BaseModelMapper::get($id2);

        self::assertEquals($modelR->string, $modelR2->string);
        self::assertEquals($modelR->int, $modelR2->int);
        self::assertEquals($modelR->bool, $modelR2->bool);
        self::assertEquals($modelR->float, $modelR2->float);
        self::assertEquals($modelR->null, $modelR2->null);
        self::assertEquals($modelR->datetime->format('Y-m-d'), $modelR2->datetime->format('Y-m-d'));

        // todo test update relations
    }

    public function testDelete()
    {
        $id = BaseModelMapper::create($this->model);
        BaseModelMapper::delete($this->model);
        $modelR = BaseModelMapper::get($id);

        self::assertInstanceOf('\Tests\PHPUnit\phpOMS\DataStorage\Database\TestModel\NullBaseModel', $modelR);

        // todo test if relations also deleted
    }


}
