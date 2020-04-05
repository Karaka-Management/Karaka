<?php
/**
 * Orange Management
 *
 * PHP Version 7.4
 *
 * @package   Modules\Messages
 * @copyright Dennis Eichhorn
 * @license   OMS License 1.0
 * @version   1.0.0
 * @link      https://orange-management.org
 */
declare(strict_types=1);

$mail = new \phpOMS\Message\Mail\Imap();
$mail->connect('{imap.gmail.com:993/imap/ssl}[Gmail]/Gesendet', 'dev.orange.management@gmail.com', 'DEV_PASSWORD');
$sent = $mail->getInboxAll();
$quota = $mail->getQuota();

echo $this->getData('nav')->render(); ?>

<section class="box w-100">
    <ul class="btns floatLeft">
        <li><a href="<?= \phpOMS\Uri\UriFactory::build('{/prefix}messages/mail/create'); ?>"><i class="fa fa-pencil"></i> <?= $this->getHtml('Create', '0', '0'); ?></a>
        <li><a href=""><i class="fa fa-trash"></i> <?= $this->getHtml('Delete') ?></a>
    </ul>
</section>

<div class="box w-100">
    <table class="default">
        <caption><?= $this->getHtml('Messages') ?><i class="fa fa-download floatRight download btn"></i></caption>
        <thead>
        <tr>
            <td><span class="check"><input type="checkbox"></span>
            <td><?= $this->getHtml('Tag') ?>
            <td class="wf-100"><?= $this->getHtml('Subject') ?>
            <td><?= $this->getHtml('From') ?>
            <td><?= $this->getHtml('Date') ?>
        <tfoot>
        <tr><td colspan="5"><?= $this->printHtml(\phpOMS\Utils\Converter\File::kilobyteSizeToString($quota['usage'])); ?> / <?= $this->printHtml(\phpOMS\Utils\Converter\File::kilobyteSizeToString($quota['limit'])); ?>
        <tbody>
        <?php $count = 0; foreach ($sent as $key => $value) : ++$count;
        $url = \phpOMS\Uri\UriFactory::build('{/prefix}messages/mail/single?{?}&id=' . $value->uid); ?>
        <tr>
            <td><span class="check"><input type="checkbox"></span>
            <td><a href="<?= $url; ?>"<?= $this->printHtml($value->seen == 0 ? ' class="unseen"' : ''); ?>></a>
            <td><a href="<?= $url; ?>"<?= $this->printHtml($value->seen == 0 ? ' class="unseen"' : ''); ?>><?= $this->printHtml(\str_replace('_',' ', \mb_decode_mimeheader($value->subject))); ?></a>
            <td><a href="<?= $url; ?>"<?= $this->printHtml($value->seen == 0 ? ' class="unseen"' : ''); ?>><?= $this->printHtml($value->from); ?></a>
            <td><a href="<?= $url; ?>"<?= $this->printHtml($value->seen == 0 ? ' class="unseen"' : ''); ?>><?= $this->printHtml((new \DateTime($value->date))->format('Y-m-d H:i:s')); ?></a>
                <?php endforeach; ?>
                <?php if ($count < 1) : ?>
        <tr>
            <td colspan="5" class="empty"><?= $this->getHtml('Empty', '0', '0'); ?>
                <?php endif; ?>
    </table>
</div>
