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

require_once __DIR__ . '/../../../../../phpOMS/Autoloader.php';
require_once __DIR__ . '/../../../../../config.php';

class WikiCategoryTest extends \PHPUnit\Framework\TestCase
{
    public function testDefult()
    {
        $category = new WikiCategory();

        self::assertEquals(0, $category->getId());
        self::assertEquals('', $category->getName());
        self::assertEquals(null, $category->getParent());
    }

    public function testSetGet()
    {
        $category = new WikiCategory();

        $category->setName('Category Name');
        $category->setParent(1);

        self::assertEquals('Category Name', $category->getName());
        self::assertEquals(1, $category->getParent());
    }
}
