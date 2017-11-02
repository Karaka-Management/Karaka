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

echo $this->getData('nav')->render(); ?>

<section class="box w-100">
    <div class="inner">
        <form>
            <input type="text" class="wf-100">
        </form>
    </div>
</section>

<div class="box w-100">
    <div class="tabular">
        <ul class="tab-links">
            <li><label for="c-tab-1"><?= $this->getHtml('Start'); ?></label>
            <li><label for="c-tab-2"><?= $this->getHtml('Insert'); ?></label>
            <li><label for="c-tab-3"><?= $this->getHtml('Layout'); ?></label>
        </ul>
        <div class="tab-content">
            <input type="radio" id="c-tab-1" name="tabular-1" checked>
            <div class="tab">
                <ul class="h-list">
                    <li><i class="fa fa-lg fa-floppy-o"></i>
                    <li><i class="fa fa-lg fa-cloud-download"></i>
                    <li><i class="fa fa-lg fa-undo"></i>
                    <li><i class="fa fa-lg fa-repeat"></i>
                    <li><i class="fa fa-lg fa-copy"></i>
                    <li><i class="fa fa-lg fa-paste"></i>
                    <li><i class="fa fa-lg fa-cut"></i>
                    <li><i class="fa fa-lg fa-bold"></i>
                    <li><i class="fa fa-lg fa-italic"></i>
                    <li><i class="fa fa-lg fa-underline"></i>
                    <li><i class="fa fa-lg fa-strikethrough"></i>
                    <li><i class="fa fa-lg fa-font"></i>
                    <li><i class="fa fa-lg fa-subscript"></i>
                    <li><i class="fa fa-lg fa-superscript"></i>
                    <li><i class="fa fa-lg fa-paint-brush"></i>
                    <li><i class="fa fa-lg fa-pencil"></i>
                    <li><i class="fa fa-lg fa-list-ul"></i>
                    <li><i class="fa fa-lg fa-list-ol"></i>
                    <li><i class="fa fa-lg fa-indent"></i>
                    <li><i class="fa fa-lg fa-dedent"></i>
                    <li><i class="fa fa-lg fa-align-left"></i>
                    <li><i class="fa fa-lg fa-align-justify"></i>
                    <li><i class="fa fa-lg fa-align-right"></i>
                </ul>
            </div>
            <input type="radio" id="c-tab-2" name="tabular-1">
            <div class="tab">
                <ul class="h-list">
                    <li><i class="fa fa-lg fa-table"></i>
                    <li><i class="fa fa-lg fa-image"></i>
                    <li><i class="fa fa-lg fa-camera"></i>
                    <li><i class="fa fa-lg fa-paint-brush"></i>
                    <li><i class="fa fa-lg fa-bar-chart"></i>
                    <li><i class="fa fa-lg fa-link"></i>
                    <li><i class="fa fa-lg fa-unlink"></i>
                    <li><i class="fa fa-lg fa-code"></i>
                    <li><i class="fa fa-lg fa-quote-right"></i>
                    <li><i class="fa fa-lg fa-calendar"></i>
                    <li><i class="fa fa-lg fa-clock"></i>
                </ul>
            </div>
            <input type="radio" id="c-tab-3" name="tabular-1">
            <div class="tab">
            </div>
        </div>
    </div>
</div>

<div class="box w-100">
    <div class="tabular">
        <ul class="tab-links">
            <li><label for="c-tab2-1"><?= $this->getHtml('Text'); ?></label>
            <li><label for="c-tab2-2"><?= $this->getHtml('Preview'); ?></label>
        </ul>
        <div class="tab-content">
            <input type="radio" id="c-tab2-1" name="tabular-2" checked>
            <div class="tab">
                <textarea class="wf-100"></textarea>
            </div>
            <input type="radio" id="c-tab2-2" name="tabular-2">
            <div class="tab">
            </div>
        </div>
    </div>
</div>

<section class="box w-100">
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
