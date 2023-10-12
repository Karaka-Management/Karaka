<?php
/**
 * Jingga
 *
 * PHP Version 8.1
 *
 * @package   Modules\Localization
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.0
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

use phpOMS\Localization\ISO639Enum;
use phpOMS\Localization\ISO639x1Enum;
use phpOMS\Uri\UriFactory;

$l11n = $this->l11ns;
$languages = ISO639x1Enum::getConstants();
$types = $this->l11nTypes;
?>

<div class="col-xs-12 col-md-6">
    <section class="portlet">
        <form id="l11nForm" action="<?= UriFactory::build($this->apiUri); ?>" method="post"
            data-ui-container="#l11nTable tbody"
            data-add-form="l11nForm"
            data-add-tpl="#l11nTable tbody .oms-add-tpl-l11n">
            <div class="portlet-head"><?= $this->getHtml('Localization', '0', '0'); ?></div>
            <div class="portlet-body">
                <div class="form-group">
                    <label for="iLocalizationId"><?= $this->getHtml('ID', '0', '0'); ?></label>
                    <input type="text" id="iLocalizationId" name="id" data-tpl-text="/id" data-tpl-value="/id" disabled>
                </div>

                <div class="form-group">
                    <label for="iLocalizationsLanguage"><?= $this->getHtml('Language', '0', '0'); ?></label>
                    <select id="iLocalizationsLanguage" name="language" data-tpl-text="/language" data-tpl-value="/language">
                        <?php foreach ($languages as $language) : ?>
                            <option value="<?= $language ?>"<?= $this->response->header->l11n->language === $language ? ' selected' : ''; ?>><?= $this->printHtml(ISO639Enum::getBy2Code($language)); ?>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="iLocalizationsType"><?= $this->getHtml('Type', '0', '0'); ?></label>
                    <select id="iLocalizationsType" name="type" data-tpl-text="/type" data-tpl-value="/type">
                        <?php foreach ($types as $type) : ?>
                            <option value="<?= $type->id; ?>"><?= $this->printHtml($type->title); ?>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="iLocalizationContent"><?= $this->getHtml('Content', '0', '0'); ?></label>
                    <textarea class="textarea contenteditable" id="iLocalizationContent" name="content" data-tpl-value="/content" value="" contenteditable></textarea>
                </div>
            </div>
            <div class="portlet-foot">
                <input id="bLocalizationAdd" formmethod="put" type="submit" class="add-form" value="<?= $this->getHtml('Add', '0', '0'); ?>">
                <input id="bLocalizationSave" formmethod="post" type="submit" class="save-form hidden button save" value="<?= $this->getHtml('Update', '0', '0'); ?>">
                <input type="submit" class="cancel-form hidden button close" value="<?= $this->getHtml('Cancel', '0', '0'); ?>">
            </div>
        </form>
    </section>
</div>

<div class="col-xs-12 col-md-6">
    <section class="portlet">
        <div class="portlet-head"><?= $this->getHtml('Localizations', '0', '0'); ?><i class="lni lni-download download btn end-xs"></i></div>
        <div class="slider">
        <table id="l11nTable" class="default"
            data-tag="form"
            data-ui-element="tr"
            data-add-tpl=".oms-add-tpl-l11n"
            data-update-form="l11nForm">
            <thead>
                <tr>
                    <td>
                    <td><?= $this->getHtml('ID', '0', '0'); ?>
                    <td><?= $this->getHtml('Language', '0', '0'); ?>
                    <td><?= $this->getHtml('Name', '0', '0'); ?><i class="sort-asc fa fa-chevron-up"></i><i class="sort-desc fa fa-chevron-down"></i>
                    <td class="wf-100"><?= $this->getHtml('Content', '0', '0'); ?><i class="sort-asc fa fa-chevron-up"></i><i class="sort-desc fa fa-chevron-down"></i>
            <tbody>
                <template class="oms-add-tpl-l11n">
                    <tr class="animated medium-duration greenCircleFade" data-id="" draggable="false">
                        <td>
                            <i class="fa fa-cogs btn update-form"></i>
                            <input id="l11nTable-remove-0" type="checkbox" class="hidden">
                            <label for="l11nTable-remove-0" class="checked-visibility-alt"><i class="fa fa-times btn form-action"></i></label>
                            <span class="checked-visibility">
                                <label for="l11nTable-remove-0" class="link default"><?= $this->getHtml('Cancel', '0', '0'); ?></label>
                                <label for="l11nTable-remove-0" class="remove-form link cancel"><?= $this->getHtml('Delete', '0', '0'); ?></label>
                            </span>
                        <td data-tpl-text="/id" data-tpl-value="/id"></td>
                        <td data-tpl-text="/language" data-tpl-value="/language"></td>
                        <td data-tpl-text="/type" data-tpl-value="/type" data-value=""></td>
                        <td data-tpl-text="/content" data-tpl-value="/content"></td>
                    </tr>
                </template>
                <?php $c = 0;
                foreach ($l11n as $key => $value) : ++$c; ?>
                    <tr data-id="<?= $value->id; ?>">
                        <td>
                            <i class="fa fa-cogs btn update-form"></i>
                            <?php if (!$value->type->isRequired) : ?>
                            <input id="l11nTable-remove-<?= $value->id; ?>" type="checkbox" class="hidden">
                            <label for="l11nTable-remove-<?= $value->id; ?>" class="checked-visibility-alt"><i class="fa fa-times btn form-action"></i></label>
                            <span class="checked-visibility">
                                <label for="l11nTable-remove-<?= $value->id; ?>" class="link default"><?= $this->getHtml('Cancel', '0', '0'); ?></label>
                                <label for="l11nTable-remove-<?= $value->id; ?>" class="remove-form link cancel"><?= $this->getHtml('Delete', '0', '0'); ?></label>
                            </span>
                            <?php endif; ?>
                        <td data-tpl-text="/id" data-tpl-value="/id"><?= $value->id; ?>
                        <td data-tpl-text="/language" data-tpl-value="/language"><?= $value->language; ?>
                        <td data-tpl-text="/type" data-tpl-value="/type" data-value="<?= $value->name; ?>"><?= $this->printHtml($value->type->title); ?>
                        <td data-tpl-text="/content" data-tpl-value="/content" data-value="<?= \str_replace(["\r\n", "\n"], ['&#10;', '&#10;'], $this->printHtml($value->content)); ?>"><?= $this->printHtml($value->content); ?>
                <?php endforeach; ?>
                <?php if ($c === 0) : ?>
                <tr>
                    <td colspan="5" class="empty"><?= $this->getHtml('Empty', '0', '0'); ?>
                <?php endif; ?>
        </table>
        </div>
    </section>
</div>
