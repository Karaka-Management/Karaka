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
$jobs = $this->getData('jobs');

echo $this->getData('nav')->render(); ?>

<div class="row">
    <div class="col-xs-12">
        <div class="box wf-100">
            <table class="table red">
                <caption><?= $this->getHtml('Job') ?></caption>
                <thead>
                <td><?= $this->getHtml('Status') ?>
                <td><?= $this->getHtml('Last') ?>
                <td><?= $this->getHtml('Next') ?>
                <td class="full"><?= $this->getHtml('Title') ?>
                <td><?= $this->getHtml('Run') ?>
                <tfoot>
                <tbody>
                <?php $c = 0; foreach ($jobs as $key => $job) : $c++;
                $url = \phpOMS\Uri\UriFactory::build('/{/lang}/backend/admin/job/single?{?}&id=' . $job->getId()); ?>
                <tr data-href="<?= $url; ?>">
                    <td><a href="<?= $url; ?>"><?= $this->printHtml($job->getStatus()); ?></a>
                    <td><a href="<?= $url; ?>"><?= $this->printHtml(!empty($job->getLastRunTime()) ? $job->getLastRunTime()->format('Y-m-d H:i:s') : ''); ?></a>
                    <td><a href="<?= $url; ?>"><?= $this->printHtml(!empty($job->getNextRunTime()) ? $job->getNextRunTime()->format('Y-m-d H:i:s') : ''); ?></a>
                    <td><a href="<?= $url; ?>"><?= $this->printHtml(trim($job->getId())); ?></a>
                    <td><a href="<?= $url; ?>"><?= $this->printHtml($job->getRun()); ?></a>
                        <?php endforeach; if ($c == 0) : ?>
                <tr><td colspan="6" class="empty"><?= $this->getHtml('Empty', 0, 0); ?>
                        <?php endif; ?>
            </table>
        </div>
    </div>
</div>