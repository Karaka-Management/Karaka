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
$mail = new \phpOMS\Message\Mail\Imap();
$mail->connect('{imap.gmail.com:993/imap/ssl}INBOX', 'dev.orange.management@gmail.com', DEV_PASSWORD);
$mails = $mail->getEmail($this->getData('id'));

echo $this->getData('nav')->render(); ?>

<section class="box w-100">
    <header><h1><?= $this->printHtml(str_replace('_',' ', mb_decode_mimeheader($mails['overview'][0]->subject))); ?></h1></header>
    <div class="inner">
        <?= $this->printHtml($mail::decode($mails['body'], $mails['encoding']->encoding)); ?>
    </div>
</section>
