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

$log              = $this->app->logger->getByLine((int) $this->request->getData('id') ?? 1);
$temp             = trim($log['backtrace']);
$log['backtrace'] = json_decode($temp, true);

$details = '* Uri: `' . trim($log['path']) . "`\n"
    . '* Level: `' . trim($log['level']) . "`\n"
    . '* Message: `' . trim($log['message']) . "`\n"
    . '* File: `' . trim($log['file']) . "`\n"
    . '* Line: `' . trim($log['line']) . "`\n"
    . '* Version: `' . trim($log['version']) . "`\n"
    . '* OS: `' . trim($log['os']) . "`\n\n"
    . "Backtrace: \n\n```\n" . json_encode($log['backtrace'], JSON_PRETTY_PRINT);

echo $this->getData('nav')->render(); ?>

<div class="row">
    <div class="col-xs-12 col-md-6">
        <section class="box wf-100">
            <header><h1><?= $this->getHtml('Logs') ?></h1></header>

            <div class="inner">
                <table class="list w-100">
                    <tr>
                        <td><?= $this->getHtml('ID', 0, 0); ?>
                        <td><i class="fa fa-anchor"></i>
                        <td class="wf-100"><?= $this->printHtml((int) $this->request->getData('id') ?? 0); ?>
                    <tr>
                        <td><?= $this->getHtml('Time') ?>
                        <td><i class="fa fa-clock-o"></i>
                        <td><?= $this->printHtml($log['datetime']); ?>
                    <tr>
                        <td><?= $this->getHtml('Uri') ?>
                        <td><i class="fa fa-globe"></i>
                        <td><?= $this->printHtml($log['path']); ?>
                    <tr>
                        <td><?= $this->getHtml('Source') ?>
                        <td><i class="fa fa-wifi"></i>
                        <td><?= $this->printHtml($log['ip']); ?>
                    <tr>
                        <td><?= $this->getHtml('Level') ?>
                        <td>
                            <i class="fa fa-<?= $this->printHtml(in_array($log['level'], ['notice', 'info', 'debug']) ? 'info-circle' : 'warning'); ?>"></i>
                        <td><?= $this->printHtml($log['level']); ?>
                    <tr>
                        <td><?= $this->getHtml('Message') ?>
                        <td><i class="fa fa-commenting"></i>
                        <td><?= $this->printHtml($log['message']); ?>
                    <tr>
                        <td><?= $this->getHtml('File') ?>
                        <td><i class="fa fa-file"></i>
                        <td><?= $this->printHtml($log['file']); ?>
                    <tr>
                        <td><?= $this->getHtml('Line') ?>
                        <td><i class="fa fa-commenting"></i>
                        <td><?= $this->printHtml($log['line']); ?>
                    <tr>
                        <td><?= $this->getHtml('Version') ?>
                        <td><i class="fa fa-pencil"></i>
                        <td><?= $this->printHtml($log['version']); ?>
                    <tr>
                        <td><?= $this->getHtml('OS') ?>
                        <td><i class="fa fa-laptop"></i>
                        <td><?= $this->printHtml($log['os']); ?>
                    <tr>
                        <td colspan="3"><?= $this->getHtml('Backtrace') ?>
                    <tr>
                        <td colspan="3">
                            <pre><?= $this->printHtml(json_encode($log['backtrace'], JSON_PRETTY_PRINT)); ?></pre>
                    <tr>
                        <td colspan="3" style="padding-top: 10px"><a class="button" target="_blank"
                            href="https://gitreports.com/issue/Orange-Management/Orange-Management/?name=Guest&issue_title=<?= $this->printHtml(urlencode($log['message'])); ?>&details=<?= $this->printHtml(urlencode($details)); ?>"><?= $this->getHtml('Report') ?></a>
                </table>
            </div>
        </section>
    </div>
</div>
