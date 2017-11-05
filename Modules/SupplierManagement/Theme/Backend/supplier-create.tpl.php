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

<div class="tabular-2">
    <div class="box">
        <ul class="tab-links">
            <li><label for="c-tab-1"><?= $this->getHtml('Master'); ?></label></li>
            <li><label for="c-tab-2"><?= $this->getHtml('Contact'); ?></label></li>
            <li><label for="c-tab-3"><?= $this->getHtml('Addresses'); ?></label></li>
            <li><label for="c-tab-4"><?= $this->getHtml('PaymentTerm'); ?></label></li>
            <li><label for="c-tab-5"><?= $this->getHtml('Payment'); ?></label></li>
            <li><label for="c-tab-6"><?= $this->getHtml('Files'); ?></label></li>
            <li><label for="c-tab-7"><?= $this->getHtml('Logs'); ?></label>
        </ul>
    </div>
    <div class="tab-content">
        <input type="radio" id="c-tab-1" name="tabular-2" checked>
        <div class="tab">
            <section class="box w-33 floatLeft">
                <header><h1><?= $this->getHtml('Supplier'); ?></h1></header>
                <div class="inner">
                    <form>
                        <table class="layout w-100">
                            <tr><td><label for="iId"><?= $this->getHtml('ID', 0, 0); ?></label>
                            <tr><td><span class="input"><button type="button" formaction=""><i class="fa fa-book"></i></button><input type="number" id="iId" min="1" name="id" required></span>
                            <tr><td><label for="iName1"><?= $this->getHtml('Name1') ?></label>
                            <tr><td><input type="text" id="iName1" name="name1" placeholder="&#xf040;" required>
                            <tr><td><label for="iName2"><?= $this->getHtml('Name2') ?></label>
                            <tr><td><input type="text" id="iName2" name="name2" placeholder="&#xf040;">
                            <tr><td><label for="iName3"><?= $this->getHtml('Name3') ?></label>
                            <tr><td><input type="text" id="iName3" name="name3" placeholder="&#xf040;">
                            <tr><td colspan="2"><input type="submit" value="<?= $this->getHtml('Create', 0, 0); ?>">
                        </table>
                    </form>
                </div>
            </section>
        </div>
        <input type="radio" id="c-tab-2" name="tabular-2">
        <div class="tab">
            <section class="box w-33 floatLeft">
                <header><h1><?= $this->getHtml('Contact'); ?></h1></header>
                <div class="inner">
                    <form>
                        <table class="layout w-100">
                            <tr><td><label for="iCType"><?= $this->getHtml('Type') ?></label>
                            <tr><td><select id="iCType" name="actype">
                                        <option><?= $this->getHtml('Email') ?>
                                        <option><?= $this->getHtml('Fax') ?>
                                        <option><?= $this->getHtml('Phone') ?>
                                    </select>
                            <tr><td><label for="iCStype"><?= $this->getHtml('Subtype') ?></label>
                            <tr><td><select id="iCStype" name="acstype">
                                        <option><?= $this->getHtml('Office') ?>
                                        <option><?= $this->getHtml('Sales') ?>
                                        <option><?= $this->getHtml('Purchase') ?>
                                        <option><?= $this->getHtml('Accounting') ?>
                                        <option><?= $this->getHtml('Support') ?>
                                    </select>
                            <tr><td><label for="iCInfo"><?= $this->getHtml('Info') ?></label>
                            <tr><td><input type="text" id="iCInfo" name="cinfo">
                            <tr><td><label for="iCData"><?= $this->getHtml('Contact') ?></label>
                            <tr><td><input type="text" id="iCData" name="cdata">
                            <tr><td colspan="2"><input type="submit" value="<?= $this->getHtml('Add', 0, 0); ?>">
                        </table>
                    </form>
                </div>
            </section>
        </div>
        <input type="radio" id="c-tab-3" name="tabular-2">
        <div class="tab">
            <section class="box w-33 floatLeft">
                <header><h1><?= $this->getHtml('Address'); ?></h1></header>
                <div class="inner">
                    <form>
                        <table class="layout w-100">
                            <tr><td><label for="iAType"><?= $this->getHtml('Type') ?></label>
                            <tr><td><select id="iAType" name="atype">
                                        <option><?= $this->getHtml('Default') ?>
                                        <option><?= $this->getHtml('Delivery') ?>
                                        <option><?= $this->getHtml('Invoice') ?>
                                    </select>
                            <tr><td><label for="iAddress"><?= $this->getHtml('Address') ?></label>
                            <tr><td><input type="text" id="iAddress" name="address">
                            <tr><td><label for="iZip"><?= $this->getHtml('Zip') ?></label>
                            <tr><td><input type="text" id="iZip" name="zip">
                            <tr><td><label for="iCountry"><?= $this->getHtml('Country') ?></label>
                            <tr><td><input type="text" id="iCountry" name="country">
                            <tr><td><label for="iAInfo"><?= $this->getHtml('Info') ?></label>
                            <tr><td><input type="text" id="iAInfo" name="ainfo">
                            <tr><td><span class="check"><input type="checkbox" id="iDefault" name="default" checked><label for="iDefault"><?= $this->getHtml('IsDefault') ?></label></span>
                            <tr><td colspan="2"><input type="submit" value="<?= $this->getHtml('Add', 0, 0); ?>">
                        </table>
                    </form>
                </div>
            </section>
        </div>
        <input type="radio" id="c-tab-4" name="tabular-2">
        <div class="tab">
            <section class="box w-33 floatLeft">
                <header><h1><?= $this->getHtml('PaymentTerm'); ?></h1></header>
                <div class="inner">
                    <form>
                        <table class="layout w-100">
                            <tr><td><label for="iSource"><?= $this->getHtml('ID'); ?></label>
                            <tr><td><span class="input"><button type="button" formaction=""><i class="fa fa-book"></i></button><input id="iSource" name="source" type="text" placeholder=""></span>
                            <tr><td><label for="iSegment"><?= $this->getHtml('Segment'); ?></label>
                            <tr><td><input id="iSegment" name="segment" type="text" placeholder="">
                            <tr><td><label for="iProductgroup"><?= $this->getHtml('Productgroup'); ?></label>
                            <tr><td><input id="iProductgroup" name="productgroup" type="text" placeholder="">
                            <tr><td><label for="iGroup"><?= $this->getHtml('Group'); ?></label>
                            <tr><td><input id="iGroup" name="group" type="text" placeholder="">
                            <tr><td><label for="iArticlegroup"><?= $this->getHtml('Articlegroup'); ?></label>
                            <tr><td><input id="iArticlegroup" name="articlegroup" type="text" placeholder="">
                            <tr><td><label for="iTerm"><?= $this->getHtml('Type'); ?></label>
                            <tr><td><select id="iTerm" name="term" required>
                                        <option>
                                    </select>
                            <tr><td><span class="check"><input type="checkbox" id="iFreightage" name="freightage"><label for="iFreightage"><?= $this->getHtml('Freightage'); ?></label></span>
                            <tr><td colspan="2"><input type="submit" value="<?= $this->getHtml('Add', 0, 0); ?>">
                        </table>
                    </form>
                </div>
            </section>
        </div>
        <input type="radio" id="c-tab-5" name="tabular-2">
        <div class="tab">
            <section class="box w-33 floatLeft">
                <header><h1><?= $this->getHtml('Payment'); ?></h1></header>
                <div class="inner">
                    <form>
                        <table class="layout w-100">
                            <tr><td><label for="iACType"><?= $this->getHtml('Type') ?></label>
                            <tr><td><select id="iACType" name="actype">
                                        <option><?= $this->getHtml('Wire') ?>
                                        <option><?= $this->getHtml('Creditcard') ?>
                                    </select>
                            <tr><td colspan="2"><input type="submit" value="<?= $this->getHtml('Add', 0, 0); ?>">
                        </table>
                    </form>
                </div>
            </section>
        </div>
        <input type="radio" id="c-tab-6" name="tabular-2">
        <div class="tab">
        </div>
        <input type="radio" id="c-tab-7" name="tabular-2">
        <div class="tab">
            <?php
            $footerView = new \Web\Views\Lists\PaginationView($this->app, $this->request, $this->response);
            $footerView->setTemplate('/Web/Templates/Lists/Footer/PaginationBig');
            $footerView->setPages(20);
            $footerView->setPage(1);
            ?>
            <div class="box w-100">
                <table class="table red">
                    <caption><?= $this->getHtml('Logs'); ?></caption>
                    <thead>
                    <tr>
                        <td>IP
                        <td><?= $this->getHtml('ID', 0, 0); ?>
                        <td><?= $this->getHtml('Name') ?>
                        <td class="wf-100"><?= $this->getHtml('Log') ?>
                        <td><?= $this->getHtml('Date') ?>
                    <tfoot>
                    <tr>
                        <td colspan="6"><?= $footerView->render(); ?>
                    <tbody>
                    <tr>
                        <td><?= $this->printHtml($this->request->getOrigin()); ?>
                        <td><?= $this->printHtml($this->request->getHeader()->getAccount()); ?>
                        <td><?= $this->printHtml($this->request->getHeader()->getAccount()); ?>
                        <td>Creating suppier
                        <td><?= $this->printHtml((new \DateTime('now'))->format('Y-m-d H:i:s')); ?>
                </table>
            </div>
        </div>
    </div>
</div>
