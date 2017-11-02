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
 * @link       http://orange-management.com
 */
declare(strict_types = 1);
namespace Modules\QA\Models;

/**
 * Answer class.
 *
 * @category   QA
 * @package    Modules
 * @license    OMS License 1.0
 * @link       http://orange-management.com
 * @since      1.0.0
 */
class QAAnswer implements \JsonSerializable
{
    private $id = 0;

    private $status = QAAnswerStatus::ACTIVE;

    private $answer = '';

    private $question = 0;

    private $isAccepted = false;

    private $createdBy = 0;

    private $createdAt = null;

    public function __construct()
    {
        $this->createdAt = new \DateTime('now');
    }

    public function getId() : int
    {
        return $this->id;
    }

    public function getAnswer() : string
    {
        return $this->answer;
    }

    public function setAnswer(string $answer) /* : void */
    {
        $this->answer = $answer;
    }

    public function getQuestion() : int
    {
        return $this->question;
    }

    public function setQuestion(int $question) /* : void */
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
    
    public function setAccepted(bool $accepted) /* : void */
    {
        $this->isAccepted = $accepted;
    }

    public function isAccepted() : bool
    {
        return $this->isAccepted;
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

    public function jsonSerialize() : array
    {
        return [];
    }
}