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
 * @var \phpOMS\Views\View         $this
 */
$job      = $this->getData('job');

echo $this->getData('nav')->render(); ?>

<div class="row">
    <div class="col-xs-12">
        <section class="box wf-100">
            <header><h1><?= $this->printHtml($job->getId()); ?></h1></header>
            <div class="inner">
            <table class="list w-100">
                    <tr>
                        <td><?= $this->getHtml('Status') ?>
                        <td><i class="fa fa-anchor"></i>
                        <td class="wf-100"><?= $this->printHtml($job->getStatus()); ?>
                    <tr>
                        <td><?= $this->getHtml('Run') ?>
                        <td><i class="fa fa-anchor"></i>
                        <td><?= $this->printHtml($job->getRun()); ?>
                    <tr>
                        <td><?= $this->getHtml('LastRunTime') ?>
                        <td><i class="fa fa-anchor"></i>
                        <td><?= $this->printHtml($job->getLastRunTime() !== null ? $job->getLastRunTime()->format('Y-m-d') : ''); ?>
                    <tr>
                        <td><?= $this->getHtml('NextRunTime') ?>
                        <td><i class="fa fa-anchor"></i>
                        <td><?= $this->printHtml($job->getNextRunTime() !== null ? $job->getNextRunTime()->format('Y-m-d') : ''); ?>
                    <tr>
                        <td><?= $this->getHtml('Description') ?>
                        <td><i class="fa fa-anchor"></i>
                        <td><blockquote><?= $this->printHtml($job->getComment()); ?></blockquote>
            </table>
                
            </div>
        </section>
    </div>
</div>