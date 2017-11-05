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

namespace Tests\PHPUnit\Modules\QA\Models;

use Modules\QA\Models\QACategory;
use Modules\QA\Models\QACategoryMapper;
use phpOMS\DataStorage\Database\DataMapperAbstract;
use phpOMS\DataStorage\Database\DatabasePool;
use phpOMS\Utils\RnG\Text;

require_once __DIR__ . '/../../../../../phpOMS/Autoloader.php';
require_once __DIR__ . '/../../../../../config.php';

class QACategoryMapperTest extends \PHPUnit\Framework\TestCase
{

    public function testCRUD()
    {
        $category = new QACategory();

        $category->setName('Test Category');

        $id = QACategoryMapper::create($category);
        self::assertGreaterThan(0, $category->getId());
        self::assertEquals($id, $category->getId());

        $categoryR = QACategoryMapper::get($category->getId());
        self::assertEquals($category->getName(), $categoryR->getName());
    }

    public function testChildCRUD()
    {
        $category = new QACategory();

        $category->setName('Test Category2');
        $category->setParent(1);

        $id = QACategoryMapper::create($category);
        self::assertGreaterThan(0, $category->getId());
        self::assertEquals($id, $category->getId());

        $categoryR = QACategoryMapper::get($category->getId());
        self::assertEquals($category->getName(), $categoryR->getName());
        self::assertEquals($category->getParent(), $categoryR->getParent());
    }

    /**
     * @group volume
     */
    public function testVolume()
    {
        for ($i = 1; $i < 30; $i++) {
            $text = new Text();
            $category = new QACategory();

            $category->setName($text->generateText(mt_rand(1, 3)));

            $id = QACategoryMapper::create($category);
        }
    }
}
