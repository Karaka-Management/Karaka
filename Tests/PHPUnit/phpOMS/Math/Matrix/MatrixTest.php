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
        $A = new Matrix();
        $A->setMatrix([[1, 2], [3, 4]]);

        self::assertEquals([[1-2, 2-2], [3-2, 4-2]], $A->sub(2)->toArray());
        self::assertEquals([[1+2, 2+2], [3+2, 4+2]], $A->add(2)->toArray());

        $B = new Matrix();
        $B->setMatrix([[1, 2], [3, 4]]);

        self::assertEquals([[1-1, 2-2], [3-3, 4-4]], $A->sub($B)->toArray());
        self::assertEquals([[1+1, 2+2], [3+3, 4+4]], $A->add($B)->toArray());
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

    public function testGetSet()
    {
        $id = new Matrix();
        $id->setMatrix([
            [1, 0, 0, 0, 0],
            [0, 1, 0, 0, 0],
            [0, 0, 1, 0, 0],
            [0, 0, 0, 1, 0],
            [0, 0, 0, 0, 1],
        ]);

        self::assertEquals(1, $id->get(1, 1));
        self::assertEquals(0, $id->get(1, 2));

        $id->set(1, 2, 4);
        self::assertEquals(4, $id->get(1, 2));
        self::assertEquals(
            [
                [1, 0, 0, 0, 0],
                [0, 1, 4, 0, 0],
                [0, 0, 1, 0, 0],
                [0, 0, 0, 1, 0],
                [0, 0, 0, 0, 1],
            ],
            $id->toArray()
        );
    }

    public function testArrayAccess()
    {
        $A = new Matrix();
        $A->setMatrix([
            [0, 1, 2, 3],
            [4, 5, 6, 7],
            [8, 9, 10, 11],
            [12, 13, 14, 15],
        ]);

        foreach ($A as $key => $value) {
            self::assertEquals($key, $value);
        }

        self::assertEquals(5, $A[5]);

        $A[5] = 6;
        self::assertEquals(6, $A[5]);

        self::assertTrue(isset($A[6]));
        self::assertFalse(isset($A[17]));

        unset($A[6]);
        self::assertFalse(isset($A[6]));
    }

    /**
     * @expectedException \phpOMS\Math\Matrix\Exception\InvalidDimensionException
     */
    public function invalidSetIndexException()
    {
        $id = new Matrix();
        $id->setMatrix([
            [1, 0],
            [0, 1],
        ]);
        $id->set(99, 99, 99);
    }

    /**
     * @expectedException \phpOMS\Math\Matrix\Exception\InvalidDimensionException
     */
    public function invalidGetIndexException()
    {
        $id = new Matrix();
        $id->setMatrix([
            [1, 0],
            [0, 1],
        ]);
        $id->get(99, 99);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function invalidSub()
    {
        $id = new Matrix();
        $id->setMatrix([
            [1, 0],
            [0, 1],
        ]);

        $id->sub([]);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function invalidAdd()
    {
        $id = new Matrix();
        $id->setMatrix([
            [1, 0],
            [0, 1],
        ]);

        $id->add([]);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function invalidMult()
    {
        $id = new Matrix();
        $id->setMatrix([
            [1, 0],
            [0, 1],
        ]);

        $id->mult([]);
    }

    /**
     * @expectedException \phpOMS\Math\Matrix\Exception\InvalidDimensionException
     */
    public function invalidDimensionAdd()
    {
        $A = new Matrix();
        $A->setMatrix([[1, 2], [3, 4]]);

        $B = new Matrix();
        $B->setMatrix([[1, 2], [3, 4], [5, 6]]);

        $A->add($B);
    }

    /**
     * @expectedException \phpOMS\Math\Matrix\Exception\InvalidDimensionException
     */
    public function invalidDimensionSub()
    {
        $A = new Matrix();
        $A->setMatrix([[1, 2], [3, 4]]);

        $B = new Matrix();
        $B->setMatrix([[1, 2], [3, 4], [5, 6]]);

        $A->sub($B);
    }

    /**
     * @expectedException \phpOMS\Math\Matrix\Exception\InvalidDimensionException
     */
    public function invalidDimensionMult()
    {
        $A = new Matrix();
        $A->setMatrix([[1, 2], [3, 4]]);

        $B = new Matrix();
        $B->setMatrix([[1, 2], [3, 4], [5, 6]]);

        $A->mult($B);
    }
}
