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

namespace Tests\PHPUnit\phpOMS\DataStorage\Database\Query;

use phpOMS\DataStorage\Database\Connection\MysqlConnection;
use phpOMS\DataStorage\Database\Query\Builder;

require_once __DIR__ . '/../../../../../../phpOMS/Autoloader.php';
require_once __DIR__ . '/../../../../../../config.php';

class BuilderTest extends \PHPUnit\Framework\TestCase
{
    protected $con = null;

    protected function setUp()
    {
        $this->con = new MysqlConnection($GLOBALS['CONFIG']['db']['core']['masters']['admin']);
    }

    public function testMysqlSelect()
    {
        $query = new Builder($this->con);
        $sql   = 'SELECT `a`.`test` FROM `a` WHERE `a`.`test` = 1;';
        self::assertEquals($sql, $query->select('a.test')->from('a')->where('a.test', '=', 1)->toSql());

        $query = new Builder($this->con);
        $sql   = 'SELECT DISTINCT `a`.`test` FROM `a` WHERE `a`.`test` = 1;';
        self::assertEquals($sql, $query->select('a.test')->distinct()->from('a')->where('a.test', '=', 1)->toSql());

        $query = new Builder($this->con);
        $sql   = 'SELECT `a`.`test`, `b`.`test` FROM `a`, `b` WHERE `a`.`test` = \'abc\';';
        self::assertEquals($sql, $query->select('a.test', 'b.test')->from('a', 'b')->where('a.test', '=', 'abc')->toSql());

        $query = new Builder($this->con);
        $datetime = new \Datetime('now');
        $sql   = 'SELECT `a`.`test`, `b`.`test` FROM `a`, `b` WHERE `a`.`test` = \'' . $datetime->format('Y-m-d H:i:s') . '\';';
        self::assertEquals($sql, $query->select('a.test', 'b.test')->from('a', 'b')->where('a.test', '=', $datetime)->toSql());

        $query            = new Builder($this->con);
        $sql              = 'SELECT `a`.`test`, `b`.`test` FROM `a`, `b` WHERE `a`.`test` = \'abc\' AND `b`.`test` = 2;';
        $systemIdentifier = '`';
        self::assertEquals($sql, $query->select('a.test', function () {
            return '`b`.`test`';
        })->from('a', function () use ($systemIdentifier) {
            return $systemIdentifier . 'b' . $systemIdentifier;
        })->where(['a.test', 'b.test'], ['=', '='], ['abc', 2], ['and', 'and'])->toSql());

        $query = new Builder($this->con);
        $sql   = 'SELECT `a`.`test`, `b`.`test` FROM `a`, `b` WHERE `a`.`test` = \'abc\' ORDER BY `a`.`test` ASC, `b`.`test` DESC;';
        self::assertEquals($sql, 
            $query->select('a.test', 'b.test')
                ->from('a', 'b')
                ->where('a.test', '=', 'abc')
                ->orderBy(['a.test', 'b.test', ], ['ASC', 'DESC', ])
                ->toSql()
        );
    }

    public function testMysqlOrder()
    {
        $query = new Builder($this->con);
        $sql   = 'SELECT `a`.`test` FROM `a` WHERE `a`.`test` = 1 ORDER BY `a`.`test` DESC;';
        self::assertEquals($sql, $query->select('a.test')->from('a')->where('a.test', '=', 1)->newest('a.test')->toSql());

        $query = new Builder($this->con);
        $sql   = 'SELECT `a`.`test` FROM `a` WHERE `a`.`test` = 1 ORDER BY `a`.`test` ASC;';
        self::assertEquals($sql, $query->select('a.test')->from('a')->where('a.test', '=', 1)->oldest('a.test')->toSql());

        $query = new Builder($this->con);
        $sql   = 'SELECT `a`.`test` FROM `a` WHERE `a`.`test` = 1 ORDER BY `a`.`test` DESC;';
        self::assertEquals($sql, $query->select('a.test')->from('a')->where('a.test', '=', 1)->orderBy('a.test', 'DESC')->toSql());

        $query = new Builder($this->con);
        $sql   = 'SELECT `a`.`test` FROM `a` WHERE `a`.`test` = 1 ORDER BY `a`.`test` ASC;';
        self::assertEquals($sql, $query->select('a.test')->from('a')->where('a.test', '=', 1)->orderBy('a.test', 'ASC')->toSql());

        $query = new Builder($this->con);
        $sql   = 'SELECT `a`.`test` FROM `a` WHERE `a`.`test` = 1 ORDER BY `a`.`test`, `a`.`test2` DESC;';
        self::assertEquals($sql, $query->select('a.test')->from('a')->where('a.test', '=', 1)->orderBy(['a.test', 'a.test2'], ['DESC', 'DESC'])->toSql());

        $query = new Builder($this->con);
        $sql   = 'SELECT `a`.`test` FROM `a` WHERE `a`.`test` = 1 ORDER BY `a`.`test`, `a`.`test2` ASC;';
        self::assertEquals($sql, $query->select('a.test')->from('a')->where('a.test', '=', 1)->orderBy(['a.test', 'a.test2'], 'ASC')->toSql());
    }

    public function testMysqlOffsetLimit()
    {
        $query = new Builder($this->con);
        $sql   = 'SELECT `a`.`test` FROM `a` WHERE `a`.`test` = 1 LIMIT 3;';
        self::assertEquals($sql, $query->select('a.test')->from('a')->where('a.test', '=', 1)->limit(3)->toSql());

        $query = new Builder($this->con);
        $sql   = 'SELECT `a`.`test` FROM `a` WHERE `a`.`test` = 1 OFFSET 3;';
        self::assertEquals($sql, $query->select('a.test')->from('a')->where('a.test', '=', 1)->offset(3)->toSql());
    }

    public function testMysqlGroup()
    {
        $query = new Builder($this->con);
        $sql   = 'SELECT `a`.`test` FROM `a` WHERE `a`.`test` = 1 GROUP BY `a`;';
        self::assertEquals($sql, $query->select('a.test')->from('a')->where('a.test', '=', 1)->groupBy('a')->toSql());

        $query = new Builder($this->con);
        $sql   = 'SELECT `a`.`test` FROM `a` WHERE `a`.`test` = 1 GROUP BY `a`, `b`;';
        self::assertEquals($sql, $query->select('a.test')->from('a')->where('a.test', '=', 1)->groupBy('a')->groupBy('b')->toSql());
        
        $query = new Builder($this->con);
        self::assertEquals($sql, $query->select('a.test')->from('a')->where('a.test', '=', 1)->groupBy('a', 'b')->toSql());
    }

    public function testMysqlWheres()
    {
        $query = new Builder($this->con);
        $sql   = 'SELECT `a`.`test` FROM `a` WHERE `a`.`test` = 1;';
        self::assertEquals($sql, $query->select('a.test')->from('a')->where('a.test', '=', 1)->toSql());

        $query = new Builder($this->con);
        $sql   = 'SELECT `a`.`test` FROM `a` WHERE `a`.`test` = 0;';
        self::assertEquals($sql, $query->select('a.test')->from('a')->where('a.test', '=', false)->toSql());

        $query = new Builder($this->con);
        $sql   = 'SELECT `a`.`test` FROM `a` WHERE `a`.`test` = 1;';
        self::assertEquals($sql, $query->select('a.test')->from('a')->where('a.test', '=', true)->toSql());

        $query = new Builder($this->con);
        $sql   = 'SELECT `a`.`test` FROM `a` WHERE `a`.`test` = \'string\';';
        self::assertEquals($sql, $query->select('a.test')->from('a')->where('a.test', '=', 'string')->toSql());

        $query = new Builder($this->con);
        $sql   = 'SELECT `a`.`test` FROM `a` WHERE `a`.`test` = 1.23;';
        self::assertEquals($sql, $query->select('a.test')->from('a')->where('a.test', '=', 1.23)->toSql());

        $query = new Builder($this->con);
        $sql   = 'SELECT `a`.`test` FROM `a` WHERE `a`.`test` = 1 AND `a`.`test2` = 2;';
        self::assertEquals($sql, $query->select('a.test')->from('a')->where('a.test', '=', 1)->where('a.test2', '=', 2, 'and')->toSql());

        $query = new Builder($this->con);
        $sql   = 'SELECT `a`.`test` FROM `a` WHERE `a`.`test` = 1 AND `a`.`test2` = 2;';
        self::assertEquals($sql, $query->select('a.test')->from('a')->where('a.test', '=', 1)->andWhere('a.test2', '=', 2)->toSql());

        $query = new Builder($this->con);
        $sql   = 'SELECT `a`.`test` FROM `a` WHERE `a`.`test` = 1 OR `a`.`test2` = 2;';
        self::assertEquals($sql, $query->select('a.test')->from('a')->where('a.test', '=', 1)->where('a.test2', '=', 2, 'or')->toSql());

        $query = new Builder($this->con);
        $sql   = 'SELECT `a`.`test` FROM `a` WHERE `a`.`test` = 1 OR `a`.`test2` = 2;';
        self::assertEquals($sql, $query->select('a.test')->from('a')->where('a.test', '=', 1)->orWhere('a.test2', '=', 2)->toSql());

        $query = new Builder($this->con);
        $sql   = 'SELECT `a`.`test` FROM `a` WHERE `a`.`test` = 1 OR `a`.`test2` IS NULL;';
        self::assertEquals($sql, $query->select('a.test')->from('a')->where('a.test', '=', 1)->whereNull('a.test2', 'or')->toSql());

        $query = new Builder($this->con);
        $sql   = 'SELECT `a`.`test` FROM `a` WHERE `a`.`test` = 1 OR `a`.`test2` IS NOT NULL;';
        self::assertEquals($sql, $query->select('a.test')->from('a')->where('a.test', '=', 1)->whereNotNull('a.test2', 'or')->toSql());

        $query = new Builder($this->con);
        $sql   = 'SELECT `a`.`test` FROM `a` WHERE `a`.`test` = 1 OR `a`.`test2` IN (1, 2, 3);';
        self::assertEquals($sql, $query->select('a.test')->from('a')->where('a.test', '=', 1)->whereIn('a.test2', [1, 2, 3], 'or')->toSql());

        $query = new Builder($this->con);
        $sql   = 'SELECT `a`.`test` FROM `a` WHERE `a`.`test` = 1 OR `a`.`test2` IN (\'a\', \'b\', \'c\');';
        self::assertEquals($sql, $query->select('a.test')->from('a')->where('a.test', '=', 1)->whereIn('a.test2', ['a', 'b', 'c'], 'or')->toSql());
    }

    public function testMysqlInsert()
    {
        $query = new Builder($this->con);
        $sql   = 'INSERT INTO `a` VALUES (1, \'test\');';
        self::assertEquals($sql, $query->insert()->into('a')->values(1, 'test')->toSql());

        $query = new Builder($this->con);
        $sql   = 'INSERT INTO `a` (`test`, `test2`) VALUES (1, \'test\');';
        self::assertEquals($sql, $query->insert('test', 'test2')->into('a')->values(1, 'test')->toSql());
    }

    public function testMysqlDelete()
    {
        $query = new Builder($this->con);
        $sql   = 'DELETE FROM `a` WHERE `a`.`test` = 1;';
        self::assertEquals($sql, $query->delete()->from('a')->where('a.test', '=', 1)->toSql());
    }

    public function testMysqlUpdate()
    {
        $query = new Builder($this->con);
        $sql   = 'UPDATE `a` SET `a`.`test` = 1, `a`.`test2` = 2 WHERE `a`.`test` = 1;';
        self::assertEquals($sql, $query->update('a')->set(['a.test' => 1])->set(['a.test2' => 2])->where('a.test', '=', 1)->toSql());
    }

    public function testRaw()
    {
        $query = new Builder($this->con);
        self::assertEquals('SELECT test.val FROM test;', $query->raw('SELECT test.val FROM test;')->toSql());
    }

    /**
     * @expectedException \Exception
     */
    public function testReadOnlyRaw()
    {
        $query = new Builder($this->con, true);
        $query->raw('DROP DATABASE oms;');
    }
    
    /**
     * @expectedException \Exception
     */
    public function testReadOnlyInsert()
    {
        $query = new Builder($this->con, true);
        $query->insert('test');
    }

    /**
     * @expectedException \Exception
     */
    public function testReadOnlyUpdate()
    {
        $query = new Builder($this->con, true);
        $query->update();
    }
    
    /**
     * @expectedException \Exception
     */
    public function testReadOnlyDelete()
    {
        $query = new Builder($this->con, true);
        $query->delete();
    }
}
