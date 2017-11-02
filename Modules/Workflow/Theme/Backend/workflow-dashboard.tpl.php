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
/**
 * @var \phpOMS\Views\View $this
 */
$workflows = [];

echo $this->getData('nav')->render(); ?>

<div class="row">
    <div class="col-xs-12">
        <div class="box wf-100">
            <table class="table red">
                <caption><?= $this->getHtml('Workflow') ?></caption>
                <thead>
                <td><?= $this->getHtml('Status') ?>
                <td><?= $this->getHtml('Next') ?>
                <td class="full"><?= $this->getHtml('Title') ?>
                <td><?= $this->getHtml('Creator') ?>
                <td><?= $this->getHtml('Created') ?>
                <tfoot>
                <tbody>
                <?php $c = 0; foreach ($workflows as $key => $workflow) : $c++;
                $url = \phpOMS\Uri\UriFactory::build('{/base}/{/lang}/backend/task/single?{?}&id=' . $workflow->getId());
                $color = 'darkred';
                if ($workflow->getStatus() === \Modules\Workflow\Models\WorkflowStatus::DONE) { $color = 'green'; }
                elseif ($workflow->getStatus() === \Modules\Workflow\Models\WorkflowStatus::OPEN) { $color = 'darkblue'; }
                elseif ($workflow->getStatus() === \Modules\Workflow\Models\WorkflowStatus::WORKING) { $color = 'purple'; }
                elseif ($workflow->getStatus() === \Modules\Workflow\Models\WorkflowStatus::CANCELED) { $color = 'red'; }
                elseif ($workflow->getStatus() === \Modules\Workflow\Models\WorkflowStatus::SUSPENDED) { $color = 'yellow'; } ;?>
                <tr>
                    <td><a href="<?= $url; ?>"><span class="tag <?= $this->printHtml($color); ?>"><?= $this->getHtml('S' . $workflow->getStatus()) ?></span></a>
                    <td><a href="<?= $url; ?>"><?= $this->printHtml($workflow->getDue()->format('Y-m-d H:i')); ?></a>
                    <td><a href="<?= $url; ?>"><?= $this->printHtml($workflow->getTitle()); ?></a>
                    <td><a href="<?= $url; ?>"><?= $this->printHtml($workflow->getCreatedBy()); ?></a>
                    <td><a href="<?= $url; ?>"><?= $this->printHtml($workflow->getCreatedAt()->format('Y-m-d H:i')); ?></a>
                        <?php endforeach; if ($c == 0) : ?>
                <tr><td colspan="6" class="empty"><?= $this->getHtml('Empty', 0, 0); ?>
                        <?php endif; ?>
            </table>
        </div>
    </div>
</div>