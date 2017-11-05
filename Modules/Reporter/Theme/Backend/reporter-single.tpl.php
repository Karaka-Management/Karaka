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
// TODO: load template in new view that doesn't get access to anything otherwise user can interact with app in bad ways
$tcoll    = $this->getData('tcoll');
$rcoll    = $this->getData('rcoll');
$cLang    = $this->getData('lang');
$template = $this->getData('template');
$report   = $this->getData('report');

/** @noinspection PhpIncludeInspection */
$reportLanguage = include __DIR__ . '/../../../../' . $tcoll['lang']->getPath();
$lang = $reportLanguage[$cLang];

echo $this->getData('nav')->render(); ?>
<div class="row">
    <div class="col-xs-12 col-md-9">
        <div class="wf-100">
            <?php /** @noinspection PhpIncludeInspection */
            include  __DIR__ . '/../../../../' . $tcoll['template']->getPath(); ?>
        </div>
    </div>

    <div class="col-xs-12 col-md-3">
        <section class="box wf-100">
            <header><h1><?= $this->getHtml('Reports') ?></h1></header>

            <div class="inner">
                <form action="<?= \phpOMS\Uri\UriFactory::build('{/base}/{/lang}/api/reporter/template'); ?>" method="post">
                    <table class="layout wf-100">
                        <tbody>
                        <tr>
                            <td><label for="iLang"><?= $this->getHtml('Language'); ?></label>
                        <tr>
                            <td><select id="iLang" name="lang" data-action='[{"listener": "change", "action": [{"key": 1, "type": "redirect", "uri": "{%}&lang={#iLang}", "target": "self"}]}]'>
                                    <?php foreach ($reportLanguage as $key => $langauge) : ?>
                                    <option value="<?= $this->printHtml($key); ?>"<?= $this->printHtml($key === $cLang ? ' selected' : ''); ?>><?= $this->printHtml($langauge[':language'] ); ?>
                                    <?php endforeach; ?>
                                </select>
                        <?php if (!$template->isStandalone()) : ?><tr>
                            <td><label for="iReport"><?= $this->getHtml('Report'); ?></label>
                        <tr>
                            <td><select id="iReport" name="report">
                                </select>
                        <?php endif; ?>
                    </table>
                </form>
            </div>
        </section>

        <section class="box wf-100">
            <header><h1><?= $this->getHtml('Export') ?></h1></header>

            <div class="inner">
                <form action="<?= \phpOMS\Uri\UriFactory::build('{/base}/{/lang}/api/reporter/template'); ?>" method="post">
                    <table class="layout wf-100">
                        <tbody>
                        <tr>
                            <td><label for="iExport"><?= $this->getHtml('Export'); ?></label>
                        <tr>
                            <td><select id="iExport" name="export-type">
                                    <option value="select" disabled><?= $this->getHtml('Select'); ?>
                                    <option value="excel"<?= $this->printHtml((!isset($tcoll['excel'])) ? ' disabled' : ''); ?>>Excel
                                    <option value="pdf"<?= $this->printHtml((!isset($tcoll['pdf'])) ? ' disabled' : ''); ?>>Pdf
                                    <option value="doc"<?= $this->printHtml((!isset($tcoll['word'])) ? ' disabled' : ''); ?>>Word
                                    <option value="ppt"<?= $this->printHtml((!isset($tcoll['powerpoint'])) ? ' disabled' : ''); ?>>Powerpoint
                                    <option value="csv"<?= $this->printHtml((!isset($tcoll['csv'])) ? ' disabled' : ''); ?>>Csv
                                    <option value="json"<?= $this->printHtml((!isset($tcoll['json'])) ? ' disabled' : ''); ?>>Json
                                    
                                </select>
                        <tr>
                            <td><input type="button" value="<?= $this->getHtml('Export'); ?>"
                                    data-ropen="/{#lang}/api/reporter/export.php?{type=#iExport}{lang=#iLang}{QUERY}">
                    </table>
                </form>
            </div>
        </section>

        <section class="box wf-100">
            <header><h1><?= $this->getHtml('Info') ?></h1></header>

            <div class="inner">
                <table class="list wf-100">
                    <tbody>
                    <?php if (!$template->isStandalone()) : ?>
                    <tr>
                        <th colspan="2"><?= $this->getHtml('Report') ?>
                    <tr>
                        <td><?= $this->getHtml('Name'); ?>
                        <td><?= $this->printHtml($report->getTitle()); ?>
                    <tr>
                        <td><?= $this->getHtml('Creator'); ?>
                        <td><?= $this->printHtml($report->getCreatedBy()->getName1()); ?>
                    <tr>
                        <td><?= $this->getHtml('Created'); ?>
                        <td><?= $report->getCreatedAt()->format('Y-m-d'); ?>
                    <?php endif; ?>
                    <tr>
                        <th colspan="2"><?= $this->getHtml('Template') ?>
                    <tr>
                        <td><?= $this->getHtml('Name'); ?>
                        <td><?= $this->printHtml($template->getName()); ?>
                    <tr>
                        <td><?= $this->getHtml('Creator'); ?>
                        <td><?= $this->printHtml($template->getCreatedBy()->getName1()); ?>
                    <tr>
                        <td><?= $this->getHtml('Created'); ?>
                        <td><?= $template->getCreatedAt()->format('Y-m-d'); ?>
                </table>
            </div>
        </section>
    </div>
</div>