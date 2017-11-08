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
 * @var \phpOMS\Views\View         $this
 * @var \Modules\Tasks\Models\Task $task
 */
$task      = $this->getData('task');
$taskMedia = $task->getMedia();
$elements  = $task->getTaskElements();
$cElements = count($elements);

if ($task->getStatus() === \Modules\Tasks\Models\TaskStatus::OPEN) { $color = 'darkblue'; }
elseif ($task->getStatus() === \Modules\Tasks\Models\TaskStatus::WORKING) { $color = 'purple'; }
elseif ($task->getStatus() === \Modules\Tasks\Models\TaskStatus::CANCELED) { $color = 'red'; }
elseif ($task->getStatus() === \Modules\Tasks\Models\TaskStatus::SUSPENDED) { $color = 'yellow'; }

echo $this->getData('nav')->render(); ?>

<div class="row">
    <div class="col-xs-12">
        <section class="box wf-100">
            <header><h1><?= $this->printHtml($task->getTitle()); ?></h1></header>
            <div class="inner">
                <div class="floatRight">Due <?= $this->printHtml($task->getDue()->format('Y-m-d H:i')); ?></div>
                <div>Created <?= $this->printHtml($task->getCreatedAt()->format('Y-m-d H:i')); ?></div>
            </div>
            <div class="inner">
                <blockquote>
                    <?= $this->printHtml($task->getDescription()); ?>
                </blockquote>
            </div>

            <?php if (!empty($taskMedia)) : ?>
            <div class="inner">
                <?php foreach ($taskMedia as $media) : ?>
                <span><?= $media->getName(); ?></span>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>

            <div class="inner">
                <div class="pAlignTable">
                    <div class="vCenterTable wf-100">Created <?= $this->printHtml($task->getCreatedBy()->getName1()); ?></div>
                    <span class="vCenterTable nobreak tag"><?= $this->getHtml('S' . $task->getStatus()) ?></span>
                </div>
            </div>
        </section>

        <?php $c = 0;
        foreach ($elements as $key => $element) : $c++;
            if ($element->getStatus() === \Modules\Tasks\Models\TaskStatus::DONE) { $color = 'green'; }
            elseif ($element->getStatus() === \Modules\Tasks\Models\TaskStatus::OPEN) { $color = 'darkblue'; }
            elseif ($element->getStatus() === \Modules\Tasks\Models\TaskStatus::WORKING) { $color = 'purple'; }
            elseif ($element->getStatus() === \Modules\Tasks\Models\TaskStatus::CANCELED) { $color = 'red'; }
            elseif ($element->getStatus() === \Modules\Tasks\Models\TaskStatus::SUSPENDED) { $color = 'yellow'; } ?>
            <section class="box wf-100">
                <div class="inner pAlignTable">
                    <div class="vCenterTable wf-100"><?= $this->printHtml($element->getCreatedBy()->getName1()); ?> - <?= $this->printHtml($element->getCreatedAt()->format('Y-m-d H:i')); ?></div>
                    <span class="vCenterTable tag <?= $this->printHtml($color); ?>"><?= $this->getHtml('S' . $element->getStatus()) ?></span>
                </div>

                <?php if ($element->getDescription() !== '') : ?>
                    <div class="inner">
                        <blockquote>
                            <?= $this->printHtml($element->getDescription()); ?>
                        </blockquote>
                    </div>
                <?php endif; ?>

                <?php $elementMedia = $element->getMedia(); if (!empty($elementMedia)) : ?>
                <div class="inner">
                    <?php foreach ($elementMedia as $media) : ?>
                    <span><?= $media->getName(); ?></span>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>

                <div class="inner pAlignTable">
                <?php if ($element->getForwarded() !== 0) : ?>
                    <div class="vCenterTable wf-100">Forwarded <?= $this->printHtml($element->getForwarded()->getName1()); ?></div>
                <?php endif; ?>
                <?php if ($element->getStatus() !== \Modules\Tasks\Models\TaskStatus::CANCELED ||
                    $element->getStatus() !== \Modules\Tasks\Models\TaskStatus::DONE ||
                    $element->getStatus() !== \Modules\Tasks\Models\TaskStatus::SUSPENDED || $c != $cElements
                ) : ?>
                    <div class="vCenterTable nobreak">Due <?= $this->printHtml($element->getDue()->format('Y-m-d H:i')); ?></div>
                <?php endif; ?>
            </section>
        <?php endforeach; ?>

        <section class="box wf-100">
            <div class="inner">
                <form id="taskElementCreate" method="POST" action="<?= \phpOMS\Uri\UriFactory::build('/{/lang}/api/task/element?{?}&csrf={$CSRF}'); ?>">
                    <table class="layout wf-100">
                        <tr><td><label for="iMessage"><?= $this->getHtml('Message') ?></label>
                        <tr><td><textarea id="iMessage" name="description"></textarea>
                        <tr><td><label for="iDue"><?= $this->getHtml('Due') ?></label>
                        <tr><td><input type="datetime-local" id="iDue" name="due" value="<?= $this->printHtml(!empty($elements) ? end($elements)->getDue()->format('Y-m-d\TH:i:s') : $task->getDue()->format('Y-m-d\TH:i:s')); ?>">
                        <tr><td><label for="iStatus"><?= $this->getHtml('Status') ?></label>
                        <tr><td><select id="iStatus" name="status">
                                    <option value="<?= $this->printHtml(\Modules\Tasks\Models\TaskStatus::OPEN); ?>" selected>Open
                                    <option value="<?= $this->printHtml(\Modules\Tasks\Models\TaskStatus::WORKING); ?>">Working
                                    <option value="<?= $this->printHtml(\Modules\Tasks\Models\TaskStatus::SUSPENDED); ?>">Suspended
                                    <option value="<?= $this->printHtml(\Modules\Tasks\Models\TaskStatus::CANCELED); ?>">Canceled
                                    <option value="<?= $this->printHtml(\Modules\Tasks\Models\TaskStatus::DONE); ?>">Done
                                </select>
                        <tr><td><label for="iReceiver"><?= $this->getHtml('To') ?></label>
                        <tr><td><input type="text" id="iReceiver" name="forward" value="<?= $this->printHtml($this->request->getHeader()->getAccount()); ?>" placeholder="&#xf007; Guest">
                        <tr><td colspan="2"><label for="iMedia"><?= $this->getHtml('Media') ?></label>
                        <tr><td><input type="text" id="iMedia" placeholder="&#xf15b; File"><td><button><?= $this->getHtml('Select') ?></button>
                        <tr><td colspan="2"><label for="iUpload"><?= $this->getHtml('Upload') ?></label>
                        <tr><td><input type="file" id="iUpload" form="fTask"><input form="fTask" type="hidden" name="type"><td>
                        <tr><td><input type="submit" value="<?= $this->getHtml('Create', 0, 0); ?>"><input type="hidden" name="task" value="<?= $this->printHtml($this->request->getData('id')); ?>"><input type="hidden" name="type" value="1">
                    </table>
                </form>
            </div>
        </section>
    </div>
</div>
