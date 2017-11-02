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

namespace Tests\PHPUnit\Modules\QA\Models;

use Modules\QA\Models\QAAnswer;
use Modules\QA\Models\QAAnswerStatus;

require_once __DIR__ . '/../../../../../phpOMS/Autoloader.php';
require_once __DIR__ . '/../../../../../config.php';

class QAAnswerTest extends \PHPUnit\Framework\TestCase
{
    public function testDefult()
    {
        $answer = new QAAnswer();

        self::assertEquals(0, $answer->getId());
        self::assertEquals('', $answer->getAnswer());
        self::assertEquals(0, $answer->getQuestion());
        self::assertEquals(false, $answer->isAccepted());
        self::assertEquals(QAAnswerStatus::ACTIVE, $answer->getStatus());
        self::assertEquals(0, $answer->getCreatedBy());
        self::assertInstanceOf('\DateTime', $answer->getCreatedAt());
    }

    public function testSetGet()
    {
        $answer = new QAAnswer();

        $answer->setAnswer('Answer content');
        $answer->setStatus(QAAnswerStatus::ACTIVE);
        $answer->setQuestion(3);
        $answer->setCreatedBy(2);
        $answer->setAccepted(true);

        self::assertEquals('Answer content', $answer->getAnswer());
        self::assertEquals(QAAnswerStatus::ACTIVE, $answer->getStatus());
        self::assertEquals(2, $answer->getCreatedBy());
        self::assertEquals(3, $answer->getQuestion());
        self::assertEquals(true, $answer->isAccepted());
    }
}
