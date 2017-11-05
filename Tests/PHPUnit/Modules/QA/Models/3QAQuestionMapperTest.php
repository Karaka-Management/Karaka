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

use Modules\QA\Models\QAQuestion;
use Modules\QA\Models\QAQuestionMapper;
use Modules\QA\Models\QAQuestionStatus;
use phpOMS\DataStorage\Database\DataMapperAbstract;
use phpOMS\DataStorage\Database\DatabasePool;
use phpOMS\Utils\RnG\Text;

require_once __DIR__ . '/../../../../../phpOMS/Autoloader.php';
require_once __DIR__ . '/../../../../../config.php';

class QAQuestionMapperTest extends \PHPUnit\Framework\TestCase
{

    public function testCRUD()
    {
        $question = new QAQuestion();

        $question->setName('Question Name');
        $question->setQuestion('Question content');
        $question->setStatus(QAQuestionStatus::ACTIVE);
        $question->setCategory(1);
        $question->setCreatedBy(1);
        $question->setLanguage('en');
        $question->addBadge(1);

        $id = QAQuestionMapper::create($question);
        self::assertGreaterThan(0, $question->getId());
        self::assertEquals($id, $question->getId());

        $questionR = QAQuestionMapper::get($question->getId());
        self::assertEquals($question->getName(), $questionR->getName());
        self::assertEquals($question->getQuestion(), $questionR->getQuestion());
        self::assertEquals($question->getStatus(), $questionR->getStatus());
        self::assertEquals($question->getLanguage(), $questionR->getLanguage());
        self::assertEquals($question->getCategory(), $questionR->getCategory()->getId());
        self::assertEquals($question->getCreatedBy(), $questionR->getCreatedBy());
        self::assertEquals(count($question->getBadges()), count($questionR->getBadges()));
    }

    /**
     * @group volume
     */
    public function testVolume()
    {
        for ($i = 1; $i < 30; $i++) {
            $text = new Text();
            $question = new QAQuestion();

            $question->setName($text->generateText(mt_rand(1, 3)));
            $question->setQuestion($text->generateText(mt_rand(100, 500)));
            $question->setStatus(QAQuestionStatus::ACTIVE);
            $question->setCategory(mt_rand(1, 9));
            $question->setCreatedBy(1);
            $question->setLanguage('en');
            $question->addBadge(mt_rand(1, 9));

            $id = QAQuestionMapper::create($question);
        }
    }
}
