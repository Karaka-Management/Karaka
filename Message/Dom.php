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

namespace Model\Message;


use phpOMS\Contract\ArrayableInterface;
use phpOMS\Contract\RenderableInterface;

/**
 * Dom class.
 *
 * @category   Modules
 * @package    Model\Message
 * @license    OMS License 1.0
 * @link       http://orange-management.com
 * @since      1.0.0
 */
class Dom implements \Serializable, ArrayableInterface
{

    /**
     * Message type.
     *
     * @var string
     * @since 1.0.0
     */
    /* public */ const TYPE = 'dom';

    /**
     * Selector string.
     *
     * @var string
     * @since 1.0.0
     */
    private $selector = '';

    /**
     * Dom content.
     *
     * @var string
     * @since 1.0.0
     */
    private $content = '';

    /**
     * Dom action.
     *
     * @var DomAction
     * @since 1.0.0
     */
    private $action = DomAction::MODIFY;

    /**
     * Delay in ms.
     *
     * @var int
     * @since 1.0.0
     */
    private $delay = 0;

    /**
     * Set DOM content
     *
     * @param string $content DOM Content
     *
     * @since 1.0.0
     */
    public function setContent(string $content)  /* : void */
    {
        $this->content = $content;
    }

    /**
     * Set selector.
     *
     * @param string $selector Selector
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function setSelector(string $selector) /* : void */
    {
        $this->selector = $selector;
    }

    /**
     * Set action.
     *
     * @param int $action action
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function setAction(int $action) /* : void */
    {
        $this->action = $action;
    }

    /**
     * Set delay.
     *
     * @param int $delay Delay in ms
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function setDelay(int $delay) /* : void */
    {
        $this->delay = $delay;
    }

    /**
     * Render message.
     *
     * @return string
     *
     * @since  1.0.0
     */
    public function serialize() : string
    {
        return $this->__toString();
    }

    public function unserialize($raw) 
    {
        return '';
    }

    /**
     * Stringify.
     *
     * @return string
     *
     * @since  1.0.0
     */
    public function __toString()
    {
        return json_encode($this->toArray());
    }

    /**
     * Generate message array.
     *
     * @return array
     *
     * @since  1.0.0
     */
    public function toArray() : array
    {
        return [
            'type'     => self::TYPE,
            'time'     => $this->delay,
            'selector' => $this->selector,
            'action'   => $this->action,
            'content'   => $this->content,
        ];
    }
}
