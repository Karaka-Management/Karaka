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
 * @link       http://orange-management.com
 */

namespace Tests\PHPUnit\Modules\Knowledgebase\Models;

use Modules\Knowledgebase\Models\WikiCategory;
use Modules\Knowledgebase\Models\WikiCategoryMapper;
use phpOMS\DataStorage\Database\DataMapperAbstract;
use phpOMS\DataStorage\Database\DatabasePool;
use phpOMS\Utils\RnG\Text;

require_once __DIR__ . '/../../../../../phpOMS/Autoloader.php';
require_once __DIR__ . '/../../../../../config.php';

class WikiCategoryMapperTest extends \PHPUnit\Framework\TestCase
{

    public function testCRUD()
    {
        $category = new WikiCategory();

        $category->setName('Test Category');

        $id = WikiCategoryMapper::create($category);
        self::assertGreaterThan(0, $category->getId());
        self::assertEquals($id, $category->getId());

        $categoryR = WikiCategoryMapper::get($category->getId());
        self::assertEquals($category->getName(), $categoryR->getName());
    }

    public function testChildCRUD()
    {
        $category = new WikiCategory();

        $category->setName('Test Category2');
        $category->setParent(1);

        $id = WikiCategoryMapper::create($category);
        self::assertGreaterThan(0, $category->getId());
        self::assertEquals($id, $category->getId());

        $categoryR = WikiCategoryMapper::get($category->getId());
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
            $category = new WikiCategory();

            $category->setName($text->generateText(mt_rand(1, 3)));

            $id = WikiCategoryMapper::create($category);
        }
    }
}
