<?php
/**
 * Orange Management
 *
 * PHP Version 7.1
 *
 * @category   TBD
 * @package    TBD
 * @copyright  Dennis Eichhorn
 * @license    OMS License 1.0
 * @version    1.0.0
 * @link       http://website.orange-management.de
 */
declare(strict_types = 1);
namespace Modules\QA\Models;

/**
 * Task class.
 *
 * @category   Kanban
 * @package    Modules
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
class QAQuestion implements \JsonSerializable
{
    private $id = 0;

    private $name = '';

    private $status = QAQuestionStatus::ACTIVE;

    private $question = '';

    private $category = 0;

    private $language = '';

    private $createdBy = 0;

    private $createdAt = null;

    private $badges = [];

    private $answers = [];

    public function __construct()
    {
        $this->createdAt = new \DateTime('now');
    }

    public function getId() : int
    {
        return $this->id;
    }

    public function hasAccepted() : bool 
    {
        foreach ($this->answers as $answer) {
            if ($answer->isAccepted()) {
                return true;
            }
        }

        return false;
    }

    public function getLanguage() : string
    {
        return $this->language;
    }

    public function setLanguage(string $language) /* : void */
    {
        $this->language = $language;
    }

    public function isAnswered() : bool
    {
        foreach ($this->answers as $answer) {
            if ($answer->isAccepted()) {
                return true;
            }
        }

        return false;
    }

    public function getName() : string
    {
        return $this->name;
    }

    public function setName(string $name) /* : void */
    {
        $this->name = $name;
    }

    public function getQuestion() : string
    {
        return $this->question;
    }

    public function setQuestion(string $question) /* : void */
    {
        $this->question = $question;
    }

    public function getStatus() : int
    {
        return $this->status;
    }

    public function setStatus(int $status) /* : void */
    {
        $this->status = $status;
    }

    public function getCategory()
    {
        return $this->category;
    }

    public function setCategory(int $category) /* : void */
    {
        $this->category = $category;
    }

    public function getCreatedBy() : int
    {
        return $this->createdBy;
    }

    public function setCreatedBy(int $id) /* : void */
    {
        $this->createdBy = $id;
    }

    public function getCreatedAt() : \DateTime
    {
        return $this->createdAt;
    }

    public function getBadges() : array
    {
        return $this->badges;
    }

    public function addBadge($badge) /* : void */
    {
        $this->badges[] = $badge;
    }

    public function getAnswers() : array
    {
        return $this->answers;
    }

    public function addAnswer($answer) /* : void */
    {
        $this->answers[] = $answer;
    }

    public function jsonSerialize() : array
    {
        return [];
    }
}