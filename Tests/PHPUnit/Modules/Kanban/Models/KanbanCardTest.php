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

namespace Tests\PHPUnit\Modules\Kanban\Models;

use Modules\Kanban\Models\KanbanCard;
use Modules\Kanban\Models\CardStatus;
use Modules\Kanban\Models\CardType;

require_once __DIR__ . '/../../../../../phpOMS/Autoloader.php';
require_once __DIR__ . '/../../../../../config.php';

class KanbanCardTest extends \PHPUnit\Framework\TestCase
{
    public function testDefult()
    {
        $card = new KanbanCard();

        self::assertEquals(0, $card->getId());
        self::assertEquals(CardStatus::ACTIVE, $card->getStatus());
        self::assertEquals(CardType::TEXT, $card->getType());
        self::assertEquals('', $card->getName());
        self::assertEquals('', $card->getDescription());
        self::assertEquals(0, $card->getColumn());
        self::assertEquals(0, $card->getOrder());
        self::assertEquals(0, $card->getCreatedBy());
        self::assertInstanceOf('\DateTime', $card->getCreatedAt());
        self::assertEquals([], $card->getComments());
        self::assertEquals([], $card->getLabels());
        self::assertEquals([], $card->getMedia());
    }

    public function testSetGet()
    {
        $card = new KanbanCard();
        $card->setStatus(CardStatus::ARCHIVED);
        $card->setType(CardType::TASK);
        $card->setName('Name');
        $card->setDescription('Description');
        $card->setColumn(1);
        $card->setOrder(2);
        $card->setCreatedBy(1);
        $card->addComment(5);
        $card->addLabel(6);
        $card->addMedia(7);

        self::assertEquals(CardStatus::ARCHIVED, $card->getStatus());
        self::assertEquals(CardType::TASK, $card->getType());
        self::assertEquals('Name', $card->getName());
        self::assertEquals('Description', $card->getDescription());
        self::assertEquals(1, $card->getColumn());
        self::assertEquals(2, $card->getOrder());
        self::assertEquals(1, $card->getCreatedBy());
        self::assertEquals([5], $card->getComments());
        self::assertEquals([6], $card->getLabels());
        self::assertEquals([7], $card->getMedia());
    }
}
