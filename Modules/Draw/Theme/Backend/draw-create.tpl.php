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
                <form id="drawForm" action="<?= \phpOMS\Uri\UriFactory::build('/{/lang}/api/draw?{?}&csrf={$CSRF}'); ?>" method="POST">
                    <input type="text" id="iTitle" name="title" class="wf-100"><input type="submit" value="<?= $this->getHtml('Create', 0, 0); ?>">
                </form>
            </div>
        </section>
    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        <div class="box wf-100">
            <div class="tabular">
                <ul class="tab-links">
                    <li><label for="c-tab-1"><?= $this->getHtml('Start'); ?></label>
                    <li><label for="c-tab-2"><?= $this->getHtml('Layout'); ?></label>
                </ul>
                <div class="tab-content">
                    <input type="radio" id="c-tab-1" name="tabular-1" checked>
                    <div class="tab">
                        <ul class="h-list">
                            <li><i class="fa fa-lg fa-floppy-o"></i>
                            <li><i class="fa fa-lg fa-cloud-download"></i>
                            <li><i class="fa fa-lg fa-undo"></i>
                            <li><i class="fa fa-lg fa-repeat"></i>
                            <li><i class="fa fa-lg fa-pencil"></i>
                            <li><i class="fa fa-lg fa-paint-brush"></i>
                            <li><i class="fa fa-lg fa-eraser"></i>
                            <li><i class="fa fa-lg fa-minus"></i>
                            <li><i class="fa fa-lg fa-square-o"></i>
                            <li><i class="fa fa-lg fa-circle-thin"></i>
                            <li><i class="fa fa-lg fa-tint"></i>
                            <li><i class="fa fa-lg fa-bars"></i>
                            <li><i class="fa fa-lg fa-i-cursor"></i>
                            <li><i class="fa fa-lg fa-text-height"></i>
                        </ul>
                    </div>
                    <input type="radio" id="c-tab-2" name="tabular-1">
                    <div class="tab">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        <div class="m-draw">
            <section class="box wf-100" style="height: 30%;">
                <div id="drawContainer" class="inner resizable">
                    <canvas id="canvasImage resizable" name="image" form="drawForm"></canvas>
                </div>
            </section>
        </div>
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
                        <tr><td><input id="iPermission" name="group" type="text" placeholder="&#xf084;"><td><button><?= $this->getHtml('Add', 0, 0); ?></button>
                    </table>
                </form>
            </div>
        </section>
    </div>
</div>