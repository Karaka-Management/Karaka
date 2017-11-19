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
/**
 * @var \phpOMS\Views\View $this
 */
echo $this->getData('nav')->render(); ?>

<section class="box w-50 floatLeft">
    <header><h1><?= $this->getHtml('Task') ?></h1></header>

    <div class="inner">
        <form id="fTask"  method="POST" action="<?= \phpOMS\Uri\UriFactory::build('/{/lang}/api/task/create'); ?>">
            <table class="layout wf-100">
                <tbody>
                <tr><td colspan="2"><label for="iReceiver"><?= $this->getHtml('To') ?></label>
                <tr><td><span class="input"><button type="button" data-action='[{"type": "popup", "tpl": "acc-grp-tpl", "aniIn": "fadeIn", "aniOut": "fadeOut", "stay": 5000}]' formaction=""><i class="fa fa-book"></i></button><input type="number" min="1" id="iReceiver" name="receiver" placeholder="&#xf007; Guest" required></span><td><button><?= $this->getHtml('Add', 0, 0); ?></button>
                <tr><td colspan="2"><label for="iObserver"><?= $this->getHtml('CC') ?></label>
                <tr><td><span class="input"><button type="button" formaction=""><i class="fa fa-book"></i></button><input type="number" min="1" id="iObserver" name="observer" placeholder="&#xf007; Guest" required></span><td><button><?= $this->getHtml('Add', 0, 0); ?></button>
                <tr><td colspan="2"><label for="iDue"><?= $this->getHtml('Due') ?></label>
                <tr><td><input type="datetime-local" id="iDue" name="due" value="<?= $this->printHtml((new \DateTime('NOW'))->format('Y-m-d\TH:i:s')); ?>"><td>
                <tr><td colspan="2"><label for="iTitle"><?= $this->getHtml('Title') ?></label>
                <tr><td><input type="text" id="iTitle" name="title" placeholder="&#xf040; <?= $this->getHtml('Title') ?>"><td>
                <tr><td colspan="2"><label for="iMessage"><?= $this->getHtml('Message') ?></label>
                <tr><td><textarea id="iMessage" name="description" placeholder="&#xf040;"></textarea><td>
                <tr><td colspan="2"><input type="submit" value="<?= $this->getHtml('Create', 0, 0); ?>"><input type="hidden" name="type" value="<?= $this->printHtml(\Modules\Tasks\Models\TaskType::SINGLE); ?>">
            </table>
        </form>
    </div>
</section>

<section class="box w-50 floatLeft">
    <header><h1><?= $this->getHtml('Media') ?></h1></header>

    <div class="inner">
        <form>
            <table class="layout wf-100">
                <tbody>
                <tr><td colspan="2"><label for="iMedia"><?= $this->getHtml('Media') ?></label>
                <tr><td><input type="text" id="iMedia" placeholder="&#xf15b; File"><td><button><?= $this->getHtml('Select') ?></button>
                <tr><td colspan="2"><label for="iUpload"><?= $this->getHtml('Upload') ?></label>
                <tr><td><input type="file" id="iUpload" form="fTask"><input form="fTask" type="hidden" name="type"><td>
            </table>
        </form>
    </div>
</section>
