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

namespace phpOMS\Message\Mail;

/**
 * Mail class.
 *
 * @category   Framework
 * @package    phpOMS\Message\Mail
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
class Mail
{
    /**
     * Mail from.
     *
     * @var string
     * @since 1.0.0
     */
    protected $from = '';

    /**
     * Mail to.
     *
     * @var array
     * @since 1.0.0
     */
    protected $to = [];

    /**
     * Mail subject.
     *
     * @var string
     * @since 1.0.0
     */
    protected $subject = '';

    /**
     * Mail cc.
     *
     * @var array
     * @since 1.0.0
     */
    protected $cc = [];

    /**
     * Mail reply to.
     *
     * @var array
     * @since 1.0.0
     */
    protected $replyTo = [];

    /**
     * Mail bcc.
     *
     * @var array
     * @since 1.0.0
     */
    protected $bcc = [];

    /**
     * Mail attachments.
     *
     * @var array
     * @since 1.0.0
     */
    protected $attachment = [];

    /**
     * Mail body.
     *
     * @var string
     * @since 1.0.0
     */
    protected $body = '';

    /**
     * Mail overview.
     *
     * @var string
     * @since 1.0.0
     */
    protected $overview = '';

    /**
     * Mail alt.
     *
     * @var string
     * @since 1.0.0
     */
    protected $bodyAlt = '';

    /**
     * Mail mime.
     *
     * @var string
     * @since 1.0.0
     */
    protected $bodyMime = '';

    /**
     * Mail header.
     *
     * @var string
     * @since 1.0.0
     */
    protected $headerMail = '';

    /**
     * Word wrap.
     *
     * @var string
     * @since 1.0.0
     */
    protected $wordWrap = 78;

    /**
     * Encoding.
     *
     * @var int
     * @since 1.0.0
     */
    protected $encoding = 0;

    /**
     * Mail host name.
     *
     * @var string
     * @since 1.0.0
     */
    protected $hostname = '';

    /**
     * Mail id.
     *
     * @var string
     * @since 1.0.0
     */
    protected $messageId = '';

    /**
     * Mail message type.
     *
     * @var string
     * @since 1.0.0
     */
    protected $messageType = '';

    /**
     * Mail from.
     *
     * @var \DateTime
     * @since 1.0.0
     */
    protected $messageDate = null;

    /**
     * Constructor.
     *
     * @param mixed $id Id
     *
     * @since  1.0.0
     */
    public function __construct($id)
    {
        $this->messageId = $id;
    }

    /**
     * Set body.
     *
     * @param string $body Mail body
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function setBody(string $body) /* : void */
    {
        $this->body = $body;
    }

    /**
     * Set body.
     *
     * @param string $overview Mail overview
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function setOverview(string $overview) /* : void */
    {
        $this->overview = $overview;
    }

    /**
     * Set encoding.
     *
     * @param int $encoding Mail encoding
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function setEncoding(int $encoding) /* : void */
    {
        $this->encoding = $encoding;
    }

}
