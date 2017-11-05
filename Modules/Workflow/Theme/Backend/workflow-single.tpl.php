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
$elements  = $task->getTaskElements();
$cElements = count($elements);

echo $this->getData('nav')->render(); ?>

<section class="box w-50">
    <header><h1><?= $this->printHtml($task->getTitle()); ?></h1></header>
    <div class="inner">
        <div class="floatRight">Due <?= $this->printHtml($task->getDue()->format('Y-m-d H:i')); ?></div>
        <div>Created <?= $this->printHtml($task->getCreatedAt()->format('Y-m-d H:i')); ?></div>
        <blockquote>
            <?= $this->printHtml($task->getDescription()); ?>
        </blockquote>
        <div>Created <?= $this->printHtml($task->getCreatedBy()); ?></div>
        <div>Status <?= $this->printHtml($task->getStatus()); ?></div>
    </div>
</section>

<?php $c = 0;
foreach ($elements as $key => $element) : $c++;
    if ($element->getStatus() === \Modules\Tasks\Models\TaskStatus::DONE) { $color = 'green'; }
    elseif ($element->getStatus() === \Modules\Tasks\Models\TaskStatus::OPEN) { $color = 'darkblue'; }
    elseif ($element->getStatus() === \Modules\Tasks\Models\TaskStatus::WORKING) { $color = 'purple'; }
    elseif ($element->getStatus() === \Modules\Tasks\Models\TaskStatus::CANCELED) { $color = 'red'; }
    elseif ($element->getStatus() === \Modules\Tasks\Models\TaskStatus::SUSPENDED) { $color = 'yellow'; } ?>
    <section class="box w-50">
        <div class="floatRight"><span class="tag <?= $this->printHtml($color); ?>"><?= $this->getHtml('S' . $element->getStatus()) ?></span></div>
        <div><?= $this->printHtml($element->getCreatedBy()); ?> - <?= $this->printHtml($element->getCreatedAt()->format('Y-m-d H:i')); ?></div>
    </section>
    <?php if ($element->getDescription() !== '') : ?>
        <section class="box w-50">
            <div class="inner">
                <blockquote>
                    <?= $this->printHtml($element->getDescription()); ?>
                </blockquote>
            </div>
        </section>
    <?php endif; ?>
    <section class="box w-50">
        <?php if ($element->getStatus() !== \Modules\Tasks\Models\TaskStatus::CANCELED ||
            $element->getStatus() !== \Modules\Tasks\Models\TaskStatus::DONE ||
            $element->getStatus() !== \Modules\Tasks\Models\TaskStatus::SUSPENDED || $c != $cElements
        ) : ?>
            <div class="floatRight">Due <?= $this->printHtml($element->getDue()->format('Y-m-d H:i')); ?></div>
        <?php endif; ?>
        <?php if ($element->getForwarded() !== 0) : ?>
            <div>Forwarded <?= $this->printHtml($element->getForwarded()); ?></div>
        <?php endif; ?>
    </section>
<?php endforeach; ?>

<section class="box w-50">
    <div class="inner">
        <form>
            <table class="layout wf-100">
                <tr><td><label for="iMessage"><?= $this->getHtml('Message') ?></label>
                <tr><td><textarea></textarea>
                <tr><td><label for="iDue"><?= $this->getHtml('Due') ?></label>
                <tr><td><input type="datetime-local">
                <tr><td><label for="iReceiver"><?= $this->getHtml('Status') ?></label>
                <tr><td><select>
                            <option>
                        </select>
                <tr><td><label for="iReceiver"><?= $this->getHtml('To') ?></label>
                <tr><td><input type="text" id="iReceiver" placeholder="&#xf007; Guest">
                <tr><td><input type="submit" value="<?= $this->getHtml('Create', 0, 0); ?>"><input type="hidden" name="type" value="1">
            </table>
        </form>
    </div>
</section>
