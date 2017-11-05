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
    <div class="col-xs-12">
        <section class="box wf-100">
            <div class="inner">
                <form id="fEditor" method="POST" action="<?= \phpOMS\Uri\UriFactory::build('{/base}/{/lang}/api/editor?{?}&csrf={$CSRF}'); ?>">
                    <input name="title" type="text" class="wf-100">
                    <input type="submit" value="<?= $this->getHtml('Save') ?>">
                </form>
            </div>
        </section>
    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        <section class="box wf-100">
            <div class="inner">
                <?= $this->getData('editor')->render('editor-tools'); ?>
            </div>
        </section>
    </div>
</div>

<div class="row">
    <div class="box col-xs-12">
        <?= $this->getData('editor')->getData('text')->render('editor-text'); ?>
    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        <section class="box wf-100">
            <div class="inner">
                <form>
                    <table class="layout">
                        <tr><td colspan="2"><label><?= $this->getHtml('Permission'); ?></label>
                        <tr><td><select>
                                    <option>
                                </select>
                        <tr><td colspan="2"><label><?= $this->getHtml('GroupUser'); ?></label>
                        <tr><td><input id="iPermission" name="group" type="text" placeholder="&#xf084;"><td><button><?= $this->getHtml('Add'); ?></button>
                    </table>
                </form>
            </div>
        </section>
    </div>
</div>
