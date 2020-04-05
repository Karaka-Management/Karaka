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
$mail->connect('{imap.gmail.com:993/imap/ssl}', 'dev.orange.management@gmail.com', 'DEV_PASSWORD');
$boxes = $mail->getBoxes();

echo $this->getData('nav')->render(); ?>

<section class="box w-33">
    <header><h1><?= $this->getHtml('Mailboxes') ?></h1></header>
    <div class="inner">
        <form>
            <table class="layout">
                <tr><td><label for="iInbox"><?= $this->getHtml('Inbox') ?></label>
                <tr><td><select id="iInbox" name="inbox">
                            <option value=""><?= $this->getHtml('Select') ?>
                            <?php foreach ($boxes as $box) : ?>
                            <option value="<?= $this->printHtml($box); ?>"><?= $this->printHtml($box); ?>
                            <?php endforeach; ?>
                        </select>
                <tr><td><label for="iOutbox"><?= $this->getHtml('Outbox') ?></label>
                <tr><td><select id="iOutbox" name="outbox">
                            <option value=""><?= $this->getHtml('Select') ?>
                            <?php foreach ($boxes as $box) : ?>
                            <option value="<?= $this->printHtml($box); ?>"><?= $this->printHtml($box); ?>
                                <?php endforeach; ?>
                        </select>
                <tr><td><label for="iDraft"><?= $this->getHtml('Draft') ?></label>
                <tr><td><select id="iDraft" name="draft">
                            <option value=""><?= $this->getHtml('Select') ?>
                            <?php foreach ($boxes as $box) : ?>
                            <option value="<?= $this->printHtml($box); ?>"><?= $this->printHtml($box); ?>
                                <?php endforeach; ?>
                        </select>
                <tr><td><label for="iTrash"><?= $this->getHtml('Trash') ?></label>
                <tr><td><select id="iTrash" name="trash">
                            <option value=""><?= $this->getHtml('Select') ?>
                            <?php foreach ($boxes as $box) : ?>
                            <option value="<?= $this->printHtml($box); ?>"><?= $this->printHtml($box); ?>
                                <?php endforeach; ?>
                        </select>
                <tr><td><label for="iSpam"><?= $this->getHtml('Spam') ?></label>
                <tr><td><select id="iSpam" name="spam">
                            <option value=""><?= $this->getHtml('Select') ?>
                            <?php foreach ($boxes as $box) : ?>
                            <option value="<?= $this->printHtml($box); ?>"><?= $this->printHtml($box); ?>
                                <?php endforeach; ?>
                        </select>
                <tr><td><input type="submit" value="<?= $this->getHtml('Save') ?>">
            </table>
        </form>
    </div>
</section>
