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

<section class="box w-100">
    <div class="inner">
        <div id="chart" class="chart" style="width: 100%; height: 350px"></div>
    </div>
</section>

<div class="tabular-2">
    <div class="box">
        <ul class="tab-links">
            <li><label for="c-tab-1"><?= $this->getHtml('Master'); ?></label>
            <li><label for="c-tab-2"><?= $this->getHtml('Text'); ?></label>
            <li><label for="c-tab-3"><?= $this->getHtml('Axis'); ?></label>
            <li><label for="c-tab-4"><?= $this->getHtml('Data'); ?></label>
            <li><label for="c-tab-5"><?= $this->getHtml('Legend'); ?></label>
        </ul>
    </div>
    <div class="tab-content">
        <input type="radio" id="c-tab-1" name="tabular-1" checked>
        <div class="tab">
            <section class="box w-50 floatLeft">
                <div class="inner">
                    <form>
                        <table class="wf-100">
                            <tr><td><label for="iName"><?= $this->getHtml('Name') ?></label>
                            <tr><td><input type="text" id="iName">
                            <tr><td><label for="iName"><?= $this->getHtml('Grid') ?></label>
                            <tr><td><select></select>
                            <tr><td><label for="iName"><?= $this->getHtml('Marker') ?></label>
                            <tr><td><select></select>
                            <tr><td><label for="iName"><?= $this->getHtml('Hover') ?></label>
                            <tr><td><select></select>
                            <tr><td><label for="iName"><?= $this->getHtml('Thickness') ?></label>
                            <tr><td><input type="text" id="iName">
                            <tr><td><label for="iName"><?= $this->getHtml('Color') ?></label>
                            <tr><td><select></select>
                            <tr><td><span class="check"><input type="checkbox"><label><?= $this->getHtml('ShowData') ?></label></span>
                        </table>
                    </form>
                </div>
            </section>
        </div>
        <input type="radio" id="c-tab-2" name="tabular-1">
        <div class="tab">
            <section class="box w-50 floatLeft">
                <div class="inner">
                    <form>
                        <table class="wf-100">
                            <tr><td><label for="iName"><?= $this->getHtml('Title') ?></label>
                            <tr><td><input type="text" id="iName">
                            <tr><td><label for="iName"><?= $this->getHtml('Size') ?></label>
                            <tr><td><input type="text" id="iName">
                            <tr><td><label for="iName"><?= $this->getHtml('Position') ?></label>
                            <tr><td><select></select>
                        </table>
                    </form>
                </div>
            </section>

            <section class="box w-50 floatLeft">
                <div class="inner">
                    <form>
                        <table class="wf-100">
                            <tr><td><label for="iName"><?= $this->getHtml('Subtitle') ?></label>
                            <tr><td><input type="text" id="iName">
                            <tr><td><label for="iName"><?= $this->getHtml('Size') ?></label>
                            <tr><td><input type="text" id="iName">
                            <tr><td><label for="iName"><?= $this->getHtml('Position') ?></label>
                            <tr><td><select></select>
                        </table>
                    </form>
                </div>
            </section>

            <section class="box w-50 floatLeft">
                <div class="inner">
                    <form>
                        <table class="wf-100">
                            <tr><td><label for="iName"><?= $this->getHtml('Footer') ?></label>
                            <tr><td><input type="text" id="iName">
                            <tr><td><label for="iName"><?= $this->getHtml('Size') ?></label>
                            <tr><td><input type="text" id="iName">
                            <tr><td><label for="iName"><?= $this->getHtml('Position') ?></label>
                            <tr><td><select></select>
                        </table>
                    </form>
                </div>
            </section>
        </div>
        <input type="radio" id="c-tab-3" name="tabular-1">
        <div class="tab">
            <section class="box w-50 floatLeft">
                <header><h1>X</h1></header>
                <div class="inner">
                    <form>
                        <table class="wf-100">
                            <tr><td><span class="check"><input type="checkbox"><label><?= $this->getHtml('Visible') ?></label></span>
                            <tr><td><span class="check"><input type="checkbox"><label><?= $this->getHtml('ShowAxis') ?></label></span>
                            <tr><td><span class="check"><input type="checkbox"><label><?= $this->getHtml('ShowTicks') ?></label></span>
                            <tr><td><label for="iName"><?= $this->getHtml('Minimum') ?></label>
                            <tr><td><input type="text" id="iName">
                            <tr><td><label for="iName"><?= $this->getHtml('Maximum') ?></label>
                            <tr><td><input type="text" id="iName">
                            <tr><td><label for="iName"><?= $this->getHtml('Steps') ?></label>
                            <tr><td><input type="text" id="iName">
                            <tr><td><label for="iName"><?= $this->getHtml('Label') ?></label>
                            <tr><td><input type="text" id="iName">
                            <tr><td><label for="iName"><?= $this->getHtml('Size') ?></label>
                            <tr><td><input type="text" id="iName">
                            <tr><td><label for="iName"><?= $this->getHtml('Position') ?></label>
                            <tr><td><select></select>
                        </table>
                    </form>
                </div>
            </section>

            <section class="box w-50 floatLeft">
                <header><h1>Y</h1></header>
                <div class="inner">
                    <form>
                        <table class="wf-100">
                            <tr><td><span class="check"><input type="checkbox"><label><?= $this->getHtml('Visible') ?></label></span>
                            <tr><td><span class="check"><input type="checkbox"><label><?= $this->getHtml('ShowAxis') ?></label></span>
                            <tr><td><span class="check"><input type="checkbox"><label><?= $this->getHtml('ShowTicks') ?></label></span>
                            <tr><td><label for="iName"><?= $this->getHtml('Minimum') ?></label>
                            <tr><td><input type="text" id="iName">
                            <tr><td><label for="iName"><?= $this->getHtml('Maximum') ?></label>
                            <tr><td><input type="text" id="iName">
                            <tr><td><label for="iName"><?= $this->getHtml('Steps') ?></label>
                            <tr><td><input type="text" id="iName">
                            <tr><td><label for="iName"><?= $this->getHtml('Label') ?></label>
                            <tr><td><input type="text" id="iName">
                            <tr><td><label for="iName"><?= $this->getHtml('Size') ?></label>
                            <tr><td><input type="text" id="iName">
                            <tr><td><label for="iName"><?= $this->getHtml('Position') ?></label>
                            <tr><td><select></select>
                        </table>
                    </form>
                </div>
            </section>
        </div>
        <input type="radio" id="c-tab-4" name="tabular-1">
        <div class="tab">
            <section class="box w-50 floatLeft">
                <div class="inner">
                    <form>
                        <table class="wf-100">
                            <tr><td><label for="iName"><?= $this->getHtml('Info') ?></label>
                            <tr><td><input type="text" id="iName">
                            <tr><td><label for="iName">X</label>
                            <tr><td><input type="text" id="iName">
                            <tr><td><label for="iName">Y</label>
                            <tr><td><input type="text" id="iName">
                            <tr><td><button><?= $this->getHtml('Add', 0, 0); ?></button>
                        </table>
                    </form>
                </div>
            </section>

            <section class="box w-50 floatLeft">
                <div class="inner">
                    <form>
                        <table class="wf-100">
                            <tr><td><label for="iName"><?= $this->getHtml('Data') ?></label>
                            <tr><td><textarea></textarea>
                        </table>
                    </form>
                </div>
            </section>
        </div>
        <input type="radio" id="c-tab-5" name="tabular-1">
        <div class="tab">
            <section class="box w-50 floatLeft">
                <div class="inner">
                    <form>
                        <table class="wf-100">
                            <tr><td><span class="check"><input type="checkbox"><label><?= $this->getHtml('Visible') ?></label></span>
                            <tr><td><label for="iName"><?= $this->getHtml('Position') ?></label>
                            <tr><td><select></select>
                        </table>
                    </form>
                </div>
            </section>
        </div>
    </div>
</div>
