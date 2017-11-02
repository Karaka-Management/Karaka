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
$logs = $this->app->logger->countLogs();
$penetrators = $this->app->logger->getHighestPerpetrator();

echo $this->getData('nav')->render(); ?>

<div class="row">
    <div class="col-xs-12 col-md-4">
        <section class="box wf-100">
            <header><h1><?= $this->getHtml('System'); ?></h1></header>
            <div class="inner">
                <table class="list wf-100">
                    <tbody>
                        <tr><td><?= $this->getHtml('OS'); ?><td><?= $this->printHtml(php_uname('s')); ?>
                        <tr><td><?= $this->getHtml('Version'); ?><td><?= $this->printHtml(php_uname('v')); ?>
                        <tr><td><?= $this->getHtml('Release'); ?><td><?= $this->printHtml(php_uname('r')); ?>
                        <tr><td><?= $this->getHtml('RAMUsage'); ?><td><?= $this->printHtml(memory_get_usage(true)/(1024*1024)); ?> MB
                        <tr><td><?= $this->getHtml('MemoryLimit'); ?><td><?= $this->printHtml(ini_get('memory_limit')); ?>
                        <tr><td><?= $this->getHtml('SystemRAM'); ?><td><?= $this->printHtml(\phpOMS\System\SystemUtils::getRAM()/(1024)); ?> MB
                        <tr><td><?= $this->getHtml('CPUUsage'); ?><td><?= $this->printHtml(\phpOMS\System\SystemUtils::getCpuUsage()); ?>%
                </table>
            </div>
        </section>
    </div>

    <div class="col-xs-12 col-md-4">
        <section class="box wf-100">
            <header><h1><?= $this->getHtml('Logs'); ?></h1></header>
            <div class="inner">
                <table class="list wf-100">
                    <tbody>
                    <tr><td><?= $this->getHtml('Emergencies'); ?><td><?= $this->printHtml($logs['emergency'] ?? 0); ?>
                    <tr><td><?= $this->getHtml('Criticals'); ?><td><?= $this->printHtml($logs['critical'] ?? 0); ?>
                    <tr><td><?= $this->getHtml('Errors'); ?><td><?= $this->printHtml($logs['error'] ?? 0); ?>
                    <tr><td><?= $this->getHtml('Warnings'); ?><td><?= $this->printHtml($logs['warning'] ?? 0); ?>
                    <tr><td><?= $this->getHtml('Alerts'); ?><td><?= $this->printHtml($logs['alert'] ?? 0); ?>
                    <tr><td><?= $this->getHtml('Notices'); ?><td><?= $this->printHtml($logs['notice'] ?? 0); ?>
                    <tr><td><?= $this->getHtml('Info'); ?><td><?= $this->printHtml($logs['info'] ?? 0); ?>
                    <tr><td><?= $this->getHtml('Debug'); ?><td><?= $this->printHtml($logs['debug'] ?? 0); ?>
                    <tr><td><?= $this->getHtml('Total'); ?><td><?= $this->printHtml(array_sum($logs)); ?>
                </table>
            </div>
        </section>
    </div>

    <div class="col-xs-12 col-md-4">
        <section class="box wf-100">
            <header><h1><?= $this->getHtml('Penetrators'); ?></h1></header>
            <div class="inner">
                <table class="list wf-100">
                    <tbody>
                    <?php foreach ($penetrators as $ip => $count) : ?>
                    <tr><td><?= $this->printHtml($ip); ?><td><?= $this->printHtml($count); ?>
                    <?php endforeach; ?>
                </table>
            </div>
        </section>
    </div>
</div>