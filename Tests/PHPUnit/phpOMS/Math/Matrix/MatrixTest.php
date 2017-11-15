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

namespace Tests\PHPUnit\phpOMS\Math\Matrix;

require_once __DIR__ . '/../../../../../phpOMS/Autoloader.php';

use phpOMS\Math\Matrix\Matrix;

class MatrixTest extends \PHPUnit\Framework\TestCase
{
    protected $A = null;
    protected $B = null;
    protected $C = null;

    protected function setUp()
    {
        $this->A = new Matrix(2, 3);
        $this->A->setMatrix([
            [1, 0, -2],
            [0, 3, -1],
        ]);

        $this->B = new Matrix(3, 2);
        $this->B->setMatrix([
            [0, 3],
            [-2, -1],
            [0, 4],
        ]);

        $this->C = $this->A->mult($this->B);
    }

    public function testBase()
    {
        self::assertEquals(2, $this->A->getM());
        self::assertEquals(3, $this->A->getN());
        // LU decomposition
    }

    public function testMult()
    {
        self::assertEquals([[0, -5], [-6, -7]], $this->C->getMatrix());
        self::assertEquals([[0, -10], [-12, -14]], $this->C->mult(2)->getMatrix());
    }

    public function testAddSub()
    {
        self::assertEquals([[2, -3], [-4, -5]], $this->C->add(2)->getMatrix());
        self::assertEquals([[0, -10], [-12, -14]], $this->C->add((new Matrix(2, 2))->setMatrix([[0, -5], [-6, -7]]))->getMatrix());

        self::assertEquals([[-2, -7], [-8, -9]], $this->C->sub(2)->getMatrix());
    }

    public function testDet()
    {
        $this->B = new Matrix();
        $this->B->setMatrix([
            [6, 1, 1],
            [4, -2, 5],
            [2, 8, 7],
        ]);

        self::assertEquals(-306, $this->B->det());
    }

    public function testInverse()
    {
        $A = new Matrix();
        $A->setMatrix([
            [1, -2, 3],
            [5, 8, -1],
            [2, 1, 1],
        ]);

        /*self::assertEquals([
            [-0.9, -0.5, 2.2],
            [0.7, 0.5, -1.6],
            [1.1, 0.5, -1.8],
        ], $A->inverse()->toArray(), '', 0.2);*/
    }

    public function testReduce()
    {
        self::assertEquals([[-6, -7], [0, -5]], $this->C->upperTriangular()->getMatrix());
        //self::assertEquals([], $this->C->lowerTriangular()->getMatrix());
        //self::assertEquals([], $this->C->diagonalize()->getMatrix());
    }
}
