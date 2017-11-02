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
use Modules\News\Models\NewsArticleMapper;
use Modules\News\Models\NewsStatus;
use Modules\News\Models\NewsType;
use phpOMS\DataStorage\Database\DataMapperAbstract;
use phpOMS\DataStorage\Database\DatabasePool;
use phpOMS\Localization\ISO639x1Enum;
use phpOMS\Utils\RnG\Text;

require_once __DIR__ . '/../../../../../phpOMS/Autoloader.php';
require_once __DIR__ . '/../../../../../config.php';

class NewsArticleMapperTest extends \PHPUnit\Framework\TestCase
{

    public function testCRUD()
    {
        $text = new Text();
        $news = new NewsArticle();

        $news->setCreatedBy(1);
        $news->setTitle($text->generateText(mt_rand(3, 7)));
        $news->setContent($text->generateText(mt_rand(100, 300)));
        $news->setCreatedAt(new \DateTime('2001-05-05'));
        $news->setPublish(new \DateTime('2001-05-07'));
        $news->setFeatured(true);
        $news->setLanguage(ISO639x1Enum::_DE);
        $news->setStatus(NewsStatus::VISIBLE);
        $news->setType(NewsType::HEADLINE);

        $id = NewsArticleMapper::create($news);
        self::assertGreaterThan(0, $news->getId());
        self::assertEquals($id, $news->getId());

        $newsR = NewsArticleMapper::get($news->getId());
        self::assertEquals($news->getCreatedAt()->format('Y-m-d'), $newsR->getCreatedAt()->format('Y-m-d'));
        self::assertEquals($news->getCreatedBy(), $newsR->getCreatedBy()->getId());
        self::assertEquals($news->getContent(), $newsR->getContent());
        self::assertEquals($news->getTitle(), $newsR->getTitle());
        self::assertEquals($news->getStatus(), $newsR->getStatus());
        self::assertEquals($news->getType(), $newsR->getType());
        self::assertEquals($news->getLanguage(), $newsR->getLanguage());
        self::assertEquals($news->isFeatured(), $newsR->isFeatured());
        self::assertEquals($news->getPublish()->format('Y-m-d'), $newsR->getPublish()->format('Y-m-d'));
    }

    /**
     * @group volume
     */
    public function testVolume()
    {
        $text = new Text();

        // Created by other

        $news = new NewsArticle();
        $news->setCreatedBy(2);
        $news->setTitle($text->generateText(mt_rand(3, 7)));
        $news->setContent($text->generateText(mt_rand(10, 300)));
        $news->setCreatedAt(new \DateTime('2001-05-05'));
        $news->setPublish(new \DateTime('2001-05-07'));
        $news->setFeatured(false);
        $news->setLanguage(ISO639x1Enum::_DE);
        $news->setStatus(NewsStatus::VISIBLE);
        $news->setType(NewsType::HEADLINE);

        $id = NewsArticleMapper::create($news);

        $news = new NewsArticle();
        $news->setCreatedBy(2);
        $news->setTitle($text->generateText(mt_rand(3, 7)));
        $news->setContent($text->generateText(mt_rand(10, 300)));
        $news->setCreatedAt(new \DateTime('2001-05-05'));
        $news->setPublish(new \DateTime('2001-05-07'));
        $news->setFeatured(false);
        $news->setLanguage(ISO639x1Enum::_DE);
        $news->setStatus(NewsStatus::DRAFT);
        $news->setType(NewsType::HEADLINE);

        $id = NewsArticleMapper::create($news);

        // Created by me

        $news = new NewsArticle();
        $news->setCreatedBy(1);
        $news->setTitle($text->generateText(mt_rand(3, 7)));
        $news->setContent($text->generateText(mt_rand(10, 300)));
        $news->setCreatedAt(new \DateTime('2001-05-05'));
        $news->setPublish(new \DateTime('2001-05-07'));
        $news->setFeatured(false);
        $news->setLanguage(ISO639x1Enum::_DE);
        $news->setStatus(NewsStatus::VISIBLE);
        $news->setType(NewsType::ARTICLE);

        $id = NewsArticleMapper::create($news);

        $news = new NewsArticle();
        $news->setCreatedBy(1);
        $news->setTitle($text->generateText(mt_rand(3, 7)));
        $news->setContent($text->generateText(mt_rand(10, 300)));
        $news->setCreatedAt(new \DateTime('2001-05-05'));
        $news->setPublish(new \DateTime('2001-05-07'));
        $news->setFeatured(false);
        $news->setLanguage(ISO639x1Enum::_DE);
        $news->setStatus(NewsStatus::VISIBLE);
        $news->setType(NewsType::LINK);

        $id = NewsArticleMapper::create($news);

        $news = new NewsArticle();
        $news->setCreatedBy(1);
        $news->setTitle($text->generateText(mt_rand(3, 7)));
        $news->setContent($text->generateText(mt_rand(10, 300)));
        $news->setCreatedAt(new \DateTime('2001-05-05'));
        $news->setPublish(new \DateTime('2001-05-07'));
        $news->setFeatured(false);
        $news->setLanguage(ISO639x1Enum::_DE);
        $news->setStatus(NewsStatus::DRAFT);
        $news->setType(NewsType::ARTICLE);

        $id = NewsArticleMapper::create($news);

        // Language

        $news = new NewsArticle();
        $news->setCreatedBy(1);
        $news->setTitle($text->generateText(mt_rand(3, 7)));
        $news->setContent($text->generateText(mt_rand(10, 300)));
        $news->setCreatedAt(new \DateTime('2001-05-05'));
        $news->setPublish(new \DateTime('2001-05-07'));
        $news->setFeatured(true);
        $news->setLanguage(ISO639x1Enum::_EN);
        $news->setStatus(NewsStatus::VISIBLE);
        $news->setType(NewsType::ARTICLE);

        $id = NewsArticleMapper::create($news);

        // Publish
        
        $publishDate = new \DateTime('now');
        $publishDate->modify('+1 days');

        $news = new NewsArticle();
        $news->setCreatedBy(1);
        $news->setTitle($text->generateText(mt_rand(3, 7)));
        $news->setContent($text->generateText(mt_rand(10, 300)));
        $news->setCreatedAt(new \DateTime('2001-05-05'));
        $news->setPublish($publishDate);
        $news->setFeatured(false);
        $news->setLanguage(ISO639x1Enum::_DE);
        $news->setStatus(NewsStatus::VISIBLE);
        $news->setType(NewsType::ARTICLE);

        $id = NewsArticleMapper::create($news);
    }
}
