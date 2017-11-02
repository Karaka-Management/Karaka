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

namespace Tests\PHPUnit\Modules\News\Models;

use Modules\News\Models\NewsArticle;
use Modules\News\Models\Badge;
use Modules\News\Models\NewsStatus;
use Modules\News\Models\NewsType;
use phpOMS\Localization\ISO639x1Enum;
use phpOMS\Stdlib\Base\Exception\InvalidEnumValue;

require_once __DIR__ . '/../../../../../phpOMS/Autoloader.php';
require_once __DIR__ . '/../../../../../config.php';

class NewsArticleTest extends \PHPUnit\Framework\TestCase
{
    public function testDefult()
    {
        $news = new NewsArticle();

        self::assertEquals(0, $news->getId());
        self::assertEquals(0, $news->getCreatedBy());
        self::assertEquals('', $news->getTitle());
        self::assertEquals('', $news->getContent());
        self::assertEquals((new \DateTime('now'))->format('Y-m-d'), $news->getCreatedAt()->format('Y-m-d'));
        self::assertEquals((new \DateTime('now'))->format('Y-m-d'), $news->getPublish()->format('Y-m-d'));
        self::assertFalse($news->isFeatured());
        self::assertEquals(ISO639x1Enum::_EN, $news->getLanguage());
        self::assertEquals(NewsStatus::DRAFT, $news->getStatus());
        self::assertEquals(NewsType::ARTICLE, $news->getType());
        self::assertEquals([], $news->getBadges());
        self::assertEquals('', $news->getPlain());
    }

    public function testSetGet()
    {
        $news = new NewsArticle();

        $news->setCreatedBy(1);
        self::assertEquals(1, $news->getCreatedBy());

        $news->setTitle('Title');
        self::assertEquals('Title', $news->getTitle());

        $news->setContent('Content');
        self::assertEquals('Content', $news->getContent());

        $news->setPlain('Plain');
        self::assertEquals('Plain', $news->getPlain());

        $news->addBadge(new Badge());
        self::assertEquals([new Badge()], $news->getBadges());

        $news->setCreatedAt($data = new \DateTime('2001-05-05'));
        self::assertEquals($data, $news->getCreatedAt());

        $news->setPublish($data = new \DateTime('2001-05-07'));
        self::assertEquals($data, $news->getPublish());

        $news->setFeatured(true);
        self::assertTrue($news->isFeatured());

        $news->setLanguage(ISO639x1Enum::_DE);
        self::assertEquals(ISO639x1Enum::_DE, $news->getLanguage());

        $news->setStatus(NewsStatus::VISIBLE);
        self::assertEquals(NewsStatus::VISIBLE, $news->getStatus());

        $news->setType(NewsType::HEADLINE);
        self::assertEquals(NewsType::HEADLINE, $news->getType());

        $arr = [
            'id' => 0,
            'title' => $news->getTitle(),
            'plain' => $news->getPlain(),
            'content' => $news->getContent(),
            'type' => $news->getType(),
            'status' => $news->getStatus(),
            'featured' => $news->isFeatured(),
            'publish' => $news->getPublish()->format('Y-m-d H:i:s'),
            'createdAt' => $news->getCreatedAt()->format('Y-m-d H:i:s'),
            'createdBy' => $news->getCreatedBy(),
        ];
        self::assertEquals($arr, $news->toArray());
        self::assertEquals($arr, $news->jsonSerialize());
        self::assertEquals(json_encode($arr), $news->__toString());
    }

    /**
     * @expectedException \phpOMS\Stdlib\Base\Exception\InvalidEnumValue
     */
    public function testInvalidStatus()
    {
        $news = new NewsArticle();
        $news->setStatus(9999);
    }
    
    /**
     * @expectedException \phpOMS\Stdlib\Base\Exception\InvalidEnumValue
     */
    public function testInvalidType()
    {
        $news = new NewsArticle();
        $news->setType(9999);
    }
    
    /**
     * @expectedException \phpOMS\Stdlib\Base\Exception\InvalidEnumValue
     */
    public function testInvalidLanguage()
    {
        $news = new NewsArticle();
        $news->setLanguage('9999');
	}
}
