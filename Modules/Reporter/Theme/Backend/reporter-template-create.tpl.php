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

<div class="row">
    <div class="col-xs-12 col-md-6">
        <section class="box wf-100">
            <header><h1><?= $this->getHtml('Template'); ?></h1></header>
            <div class="inner">
                <form id="reporter-template-create" action="<?= \phpOMS\Uri\UriFactory::build('/{/lang}/api/reporter/report/template'); ?>" method="post">
                    <table class="layout wf-100">
                        <tbody>
                        <tr><td colspan="2"><label for="iTitle"><?= $this->getHtml('Title'); ?></label>
                        <tr><td colspan="2"><input id="iTitle" name="name" type="text" placeholder="&#xf040; P&L Reporting" required>
                        <tr><td colspan="2"><label for="iDescription"><?= $this->getHtml('Description'); ?></label>
                        <tr><td colspan="2"><textarea id="iDescription" name="description"></textarea>
                        <tr><td colspan="2">
                                <span class="checkbox">
                                    <input id="iStandalone" name="standalone" type="checkbox" value="1">
                                    <label for="iStandalone"><?= $this->getHtml('Standalone'); ?></label>
                                </span>
                        <tr><td colspan="2"><h2><?= $this->getHtml('Storage'); ?></h2>
                        <tr><td colspan="2">
                                <span class="radio">
                                    <input id="iSourceDB" name="source" type="radio" value="<?= $this->printHtml(\Modules\Reporter\Models\TemplateDataType::GLOBAL_DB); ?>">
                                    <label for="iSourceDB"><?= $this->getHtml('CentralizedDB'); ?></label>
                                </span>
                        <tr><td colspan="2">
                                <span class="radio">
                                    <input id="iSourceFile" name="source" type="radio" value="<?= $this->printHtml(\Modules\Reporter\Models\TemplateDataType::GLOBAL_FILE); ?>">
                                    <label for="iSourceFile"><?= $this->getHtml('CentralizedFiles'); ?></label>
                                </span>
                        <tr><td colspan="2">
                                <span class="radio">
                                    <input id="iSourceOther" name="source" type="radio" value="<?= $this->printHtml(\Modules\Reporter\Models\TemplateDataType::OTHER); ?>" checked>
                                    <label for="iSourceOther"><?= $this->getHtml('Other'); ?></label>
                                </span>
                        <tr><td colspan="2"><label for="iFile"><?= $this->getHtml('Files'); ?></label>
                        <tr><td colspan="2"><input id="iFile" name="fileVisual" type="file" required multiple><input id="iFileHidden" name="files" type="hidden">
                        <tr><td colspan="2"><label for="iExpected"><?= $this->getHtml('Expected'); ?></label>
                        <tr><td class="wf-100"><input id="iExpected" type="text" placeholder="&#xf15b; file.csv"><input name="expected" type="hidden"><td><button><?= $this->getHtml('Add', 0, 0); ?></button>
                        <tr><td colspan="2"><input type="submit" value="<?= $this->getHtml('Create', 0, 0); ?>">
                    </table>
                </form>
            </div>
        </section>
    </div>
</div>