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

<div class="tabular-2">
    <div class="box">
        <ul class="tab-links">
            <li><label for="c-tab-1"><?= $this->getHtml('Master'); ?></label>
            <li><label for="c-tab-2"><?= $this->getHtml('Properties'); ?></label>
            <li><label for="c-tab-4"><?= $this->getHtml('Sales'); ?></label>
            <li><label for="c-tab-5"><?= $this->getHtml('Purchase'); ?></label>
            <li><label for="c-tab-6"><?= $this->getHtml('Accounting'); ?></label>
            <li><label for="c-tab-7"><?= $this->getHtml('Production'); ?></label>
            <li><label for="c-tab-8"><?= $this->getHtml('StockList'); ?></label>
            <li><label for="c-tab-9"><?= $this->getHtml('QM'); ?></label>
            <li><label for="c-tab-10"><?= $this->getHtml('Packaging'); ?></label>
            <li><label for="c-tab-11"><?= $this->getHtml('Media'); ?></label>
            <li><label for="c-tab-12"><?= $this->getHtml('Stock'); ?></label>
            <li><label for="c-tab-13"><?= $this->getHtml('Disposal'); ?></label>
            <li><label for="c-tab-14"><?= $this->getHtml('Files'); ?></label>
            <li><label for="c-tab-15"><?= $this->getHtml('Logs'); ?></label>
        </ul>
    </div>
    <div class="tab-content">
        <input type="radio" id="c-tab-1" name="tabular-2" checked>
        <div class="tab">
            <div class="row">
                <div class="col-xs-12 col-md-6 col-lg-4">
                    <section class="box wf-100">
                        <header><h1><?= $this->getHtml('Item'); ?></h1></header>
                        <div class="inner">
                            <form action="<?= \phpOMS\Uri\UriFactory::build('{/base}/{/lang}/api/...'); ?>" method="post">
                                <table class="layout wf-100">
                                    <tbody>
                                    <tr><td><label for="iSource"><?= $this->getHtml('ID'); ?></label>
                                    <tr><td><span class="input"><button type="button" formaction=""><i class="fa fa-book"></i></button><input id="iSource" name="source" type="text" placeholder="" required></span>
                                    <tr><td><label for="iSegment"><?= $this->getHtml('Segment'); ?></label>
                                    <tr><td><input id="iSegment" name="segment" type="text" placeholder="" required>
                                    <tr><td><label for="iProductgroup"><?= $this->getHtml('Productgroup'); ?></label>
                                    <tr><td><input id="iProductgroup" name="productgroup" type="text" placeholder="" required>
                                    <tr><td><label for="iGroup"><?= $this->getHtml('Group'); ?></label>
                                    <tr><td><input id="iGroup" name="group" type="text" placeholder="" required>
                                    <tr><td><label for="iArticlegroup"><?= $this->getHtml('Articlegroup'); ?></label>
                                    <tr><td><input id="iArticlegroup" name="articlegroup" type="text" placeholder="" required>
                                    <tr><td><label for="iSSuccessor"><?= $this->getHtml('Successor'); ?></label>
                                    <tr><td><span class="input"><button type="button" formaction=""><i class="fa fa-book"></i></button><input id="iSource" name="source" type="text" placeholder=""></span>
                                    <tr><td><input type="submit" value="<?= $this->getHtml('Create', 0, 0); ?>">
                                </table>
                            </form>
                        </div>
                    </section>
                </div>

                <div class="col-xs-12 col-md-6 col-lg-4">
                    <section class="box wf-100">
                        <header><h1><?= $this->getHtml('Language'); ?></h1></header>
                        <div class="inner">
                            <form action="<?= \phpOMS\Uri\UriFactory::build('{/base}/{/lang}/api/...'); ?>" method="post">
                                <table class="layout wf-100">
                                    <tbody>
                                    <tr><td><label for="iLanguage"><?= $this->getHtml('Language'); ?></label>
                                    <tr><td><select id="iLanguage" name="language">
                                                <option>
                                            </select>
                                    <tr><td><label for="iName"><?= $this->getHtml('Name1'); ?></label>
                                    <tr><td><input id="iName" name="name" type="text" placeholder="">
                                    <tr><td><label for="iName"><?= $this->getHtml('Name2'); ?></label>
                                    <tr><td><input id="iName" name="name" type="text" placeholder="">
                                    <tr><td><label for="iName"><?= $this->getHtml('Name3'); ?></label>
                                    <tr><td><input id="iName" name="name" type="text" placeholder="">
                                    <tr><td><label for="iDescription"><?= $this->getHtml('Description'); ?></label>
                                    <tr><td><textarea id="iDescription" name="description"></textarea>
                                    <tr><td><input type="submit" value="<?= $this->getHtml('Add', 0, 0); ?>">
                                </table>
                            </form>
                        </div>
                    </section>
                </div>
            </div>
        </div>
        <input type="radio" id="c-tab-2" name="tabular-2">
        <div class="tab">
            <section class="box w-33 floatLeft">
                <header><h1><?= $this->getHtml('Property'); ?></h1></header>
                <div class="inner">
                    <form action="<?= \phpOMS\Uri\UriFactory::build('{/base}/{/lang}/api/...'); ?>" method="post">
                        <table class="layout wf-100">
                            <tbody>
                            <tr><td><label for="iPCustomsId"><?= $this->getHtml('Name'); ?></label>
                            <tr><td><span class="input"><button type="button" formaction=""><i class="fa fa-book"></i></button><input id="iPCustomsId" name="customsid" type="text" placeholder=""></span>
                            <tr><td><label for="iPTradingUnit"><?= $this->getHtml('Unit'); ?></label>
                            <tr><td><select id="iPTracking" name="tracking">
                                        <option>
                                    </select>
                            <tr><td><label for="iPCustomsId"><?= $this->getHtml('Value'); ?></label>
                            <tr><td><input id="iPCustomsId" name="customsid" type="text" placeholder="">
                            <tr><td><input type="submit" value="<?= $this->getHtml('Add', 0, 0); ?>">
                        </table>
                    </form>
                </div>
            </section>
            <section class="box w-33 floatLeft">
                <header><h1><?= $this->getHtml('Language'); ?></h1></header>
                <div class="inner">
                    <form action="<?= \phpOMS\Uri\UriFactory::build('{/base}/{/lang}/api/...'); ?>" method="post">
                        <table class="layout wf-100">
                            <tbody>
                            <tr><td><label for="iPTradingUnit"><?= $this->getHtml('Language'); ?></label>
                            <tr><td><select id="iPTracking" name="tracking">
                                        <option>
                                    </select>
                            <tr><td><label for="iPCustomsId"><?= $this->getHtml('Property'); ?></label>
                            <tr><td><span class="input"><button type="button" formaction=""><i class="fa fa-book"></i></button><input id="iPCustomsId" name="customsid" type="text" placeholder=""></span>
                            <tr><td><label for="iPCustomsId"><?= $this->getHtml('Translation'); ?></label>
                            <tr><td><input id="iPCustomsId" name="customsid" type="text" placeholder="">
                            <tr><td><input type="submit" value="<?= $this->getHtml('Add', 0, 0); ?>">
                        </table>
                    </form>
                </div>
            </section>
            <section class="box w-33 floatLeft">
                <header><h1><?= $this->getHtml('Language'); ?></h1></header>
                <div class="inner">
                    <form action="<?= \phpOMS\Uri\UriFactory::build('{/base}/{/lang}/api/...'); ?>" method="post">
                        <table class="layout wf-100">
                            <tbody>
                            <tr><td><label for="iPTradingUnit"><?= $this->getHtml('Language'); ?></label>
                            <tr><td><select id="iPTracking" name="tracking">
                                        <option>
                                    </select>
                            <tr><td><label for="iPCustomsId"><?= $this->getHtml('Value'); ?></label>
                            <tr><td><span class="input"><button type="button" formaction=""><i class="fa fa-book"></i></button><input id="iPCustomsId" name="customsid" type="text" placeholder=""></span>
                            <tr><td><label for="iPCustomsId"><?= $this->getHtml('Translation'); ?></label>
                            <tr><td><input id="iPCustomsId" name="customsid" type="text" placeholder="">
                            <tr><td><input type="submit" value="<?= $this->getHtml('Add', 0, 0); ?>">
                        </table>
                    </form>
                </div>
            </section>

            <section class="box w-33 floatLeft">
                <header><h1><?= $this->getHtml('Attribute'); ?></h1></header>
                <div class="inner">
                    <form action="<?= \phpOMS\Uri\UriFactory::build('{/base}/{/lang}/api/...'); ?>" method="post">
                        <table class="layout wf-100">
                            <tbody>
                            <tr><td><label for="iPCustomsId"><?= $this->getHtml('Name'); ?></label>
                            <tr><td><span class="input"><button type="button" formaction=""><i class="fa fa-book"></i></button><input id="iPCustomsId" name="customsid" type="text" placeholder=""></span>
                            <tr><td><label for="iPTradingUnit"><?= $this->getHtml('Unit'); ?></label>
                            <tr><td><select id="iPTracking" name="tracking">
                                        <option>
                                    </select>
                            <tr><td><label for="iPCustomsId"><?= $this->getHtml('Value'); ?></label>
                            <tr><td><input id="iPCustomsId" name="customsid" type="text" placeholder="">
                            <tr><td><input type="submit" value="<?= $this->getHtml('Add', 0, 0); ?>">
                        </table>
                    </form>
                </div>
            </section>
            <section class="box w-33 floatLeft">
                <header><h1><?= $this->getHtml('Language'); ?></h1></header>
                <div class="inner">
                    <form action="<?= \phpOMS\Uri\UriFactory::build('{/base}/{/lang}/api/...'); ?>" method="post">
                        <table class="layout wf-100">
                            <tbody>
                            <tr><td><label for="iPTradingUnit"><?= $this->getHtml('Language'); ?></label>
                            <tr><td><select id="iPTracking" name="tracking">
                                        <option>
                                    </select>
                            <tr><td><label for="iPCustomsId"><?= $this->getHtml('Attribute'); ?></label>
                            <tr><td><span class="input"><button type="button" formaction=""><i class="fa fa-book"></i></button><input id="iPCustomsId" name="customsid" type="text" placeholder=""></span>
                            <tr><td><label for="iPCustomsId"><?= $this->getHtml('Translation'); ?></label>
                            <tr><td><input id="iPCustomsId" name="customsid" type="text" placeholder="">
                            <tr><td><input type="submit" value="<?= $this->getHtml('Add', 0, 0); ?>">
                        </table>
                    </form>
                </div>
            </section>
            <section class="box w-33 floatLeft">
                <header><h1><?= $this->getHtml('Language'); ?></h1></header>
                <div class="inner">
                    <form action="<?= \phpOMS\Uri\UriFactory::build('{/base}/{/lang}/api/...'); ?>" method="post">
                        <table class="layout wf-100">
                            <tbody>
                            <tr><td><label for="iPTradingUnit"><?= $this->getHtml('Language'); ?></label>
                            <tr><td><select id="iPTracking" name="tracking">
                                        <option>
                                    </select>
                            <tr><td><label for="iPCustomsId"><?= $this->getHtml('Value'); ?></label>
                            <tr><td><span class="input"><button type="button" formaction=""><i class="fa fa-book"></i></button><input id="iPCustomsId" name="customsid" type="text" placeholder=""></span>
                            <tr><td><label for="iPCustomsId"><?= $this->getHtml('Translation'); ?></label>
                            <tr><td><input id="iPCustomsId" name="customsid" type="text" placeholder="">
                            <tr><td><input type="submit" value="<?= $this->getHtml('Add', 0, 0); ?>">
                        </table>
                    </form>
                </div>
            </section>
        </div>
        <input type="radio" id="c-tab-4" name="tabular-2">
        <div class="tab">
            <section class="box w-33 floatLeft">
                <header><h1><?= $this->getHtml('Sales'); ?></h1></header>
                <div class="inner">
                    <form action="<?= \phpOMS\Uri\UriFactory::build('{/base}/{/lang}/api/...'); ?>" method="post">
                        <table class="layout wf-100">
                            <tbody>
                            <tr><td><label for="iPType"><?= $this->getHtml('Status'); ?></label>
                            <tr><td><select id="iPType" name="ptye">
                                        <option>
                                    </select>
                            <tr><td><label for="iPrice">GTIN</label>
                            <tr><td><input id="iPrice" name="price" type="text" placeholder="">
                            <tr><td colspan="2"><label for="iPPriceUnit"><?= $this->getHtml('PriceUnit'); ?></label>
                            <tr><td><select id="iPPriceUnit" name="ppriceunit">
                                        <option value="0">
                                    </select><td>
                            <tr><td colspan="2"><label for="iPQuantityUnit"><?= $this->getHtml('QuantityUnit'); ?></label>
                            <tr><td><select id="iPQuantityUnit" name="pquantityunit">
                                        <option value="0">
                                    </select><td>
                            <tr><td><label for="iPTradingUnit"><?= $this->getHtml('TradingUnit'); ?></label>
                            <tr><td><input id="iPTradingUnit" name="tradingunit" type="number" min="0" step="any" placeholder="">
                            <tr><td><label for="iPTracking"><?= $this->getHtml('Tracking'); ?></label>
                            <tr><td><select id="iPTracking" name="tracking">
                                        <option><?= $this->getHtml('None'); ?>
                                        <option><?= $this->getHtml('Lot'); ?>
                                        <option><?= $this->getHtml('SN'); ?>
                                        <option><?= $this->getHtml('Purchase'); ?>
                                    </select>
                            <tr><td><label for="iPVariation"><?= $this->getHtml('Commission'); ?></label>
                            <tr><td><select id="iPVariation" name="pvariation">
                                        <option value="0">
                                    </select>
                            <tr><td><label for="iPCustomsId"><?= $this->getHtml('CustomsID'); ?></label>
                            <tr><td><input id="iPCustomsId" name="customsid" type="text" placeholder="">
                            <tr><td><label for="iSInfo"><?= $this->getHtml('Info'); ?></label>
                            <tr><td><textarea id="iSInfo" name="sinfo"></textarea>
                        </table>
                    </form>
                </div>
            </section>

            <section class="box w-33 floatLeft">
                <header><h1><?= $this->getHtml('Price'); ?></h1></header>
                <div class="inner">
                    <form action="<?= \phpOMS\Uri\UriFactory::build('{/base}/{/lang}/api/...'); ?>" method="post">
                        <table class="layout wf-100">
                            <tbody>
                            <tr><td colspan="2"><label for="iPName"><?= $this->getHtml('Name'); ?></label>
                            <tr><td><input id="iPName" name="pname" type="text" placeholder=""><td>
                            <tr><td colspan="2"><label for="iPrice"><?= $this->getHtml('Start'); ?></label>
                            <tr><td><input id="iPrice" name="price" type="datetime-local"><td>
                            <tr><td colspan="2"><label for="iPrice"><?= $this->getHtml('End'); ?></label>
                            <tr><td><input id="iPrice" name="price" type="datetime-local"><td>
                            <tr><td colspan="2"><label for="iPType"><?= $this->getHtml('Country'); ?></label>
                            <tr><td><select id="iPType" name="ptye">
                                        <option>
                                    </select><td>
                            <tr><td colspan="2"><label for="iPQuantity"><?= $this->getHtml('Quantity'); ?></label>
                            <tr><td><input id="iPQuantity" name="quantity" type="text" placeholder=""><td>
                            <tr><td colspan="2"><label for="iPrice"><?= $this->getHtml('Price'); ?></label>
                            <tr><td><input id="iPrice" name="price" type="number" step="any" min="0" placeholder=""><td>
                            <tr><td colspan="2"><label for="iDiscount"><?= $this->getHtml('Discount'); ?></label>
                            <tr><td><input id="iDiscount" name="discount" type="number" step="any" min="0" placeholder=""><td>
                            <tr><td colspan="2"><label for="iDiscount"><?= $this->getHtml('DiscountP'); ?></label>
                            <tr><td><input id="iDiscountP" name="discountp" type="number" step="any" min="0" placeholder=""><td>
                            <tr><td colspan="2"><label for="iBonus"><?= $this->getHtml('Bonus'); ?></label>
                            <tr><td><input id="iBonus" name="bonus" type="number" step="any" min="0" placeholder=""><td>
                            <tr><td colspan="2"><label for="iGroup"><?= $this->getHtml('ClientGroup'); ?></label>
                            <tr><td><input id="iGroup" name="price" type="text" placeholder=""><td><button><?= $this->getHtml('Add', 0, 0); ?></button>
                            <tr><td colspan="2"><input type="submit" value="<?= $this->getHtml('Add', 0, 0); ?>">
                        </table>
                    </form>
                </div>
            </section>
        </div>
        <input type="radio" id="c-tab-5" name="tabular-2">
        <div class="tab">
            <section class="box w-33 floatLeft">
                <header><h1><?= $this->getHtml('Purchase'); ?></h1></header>
                <div class="inner">
                    <form action="<?= \phpOMS\Uri\UriFactory::build('{/base}/{/lang}/api/...'); ?>" method="post">
                        <table class="layout wf-100">
                            <tbody>
                            <tr><td><label for="iSupplierId"><?= $this->getHtml('Supplier'); ?></label>
                            <tr><td><span class="input"><button type="button" formaction=""><i class="fa fa-book"></i></button><input id="iSupplierId" name="supplierid" type="text" placeholder="" required></span>
                            <tr><td><label for="iPrice">GTIN</label>
                            <tr><td><input id="iPrice" name="price" type="text" placeholder="">
                            <tr><td><label for="iPPriceUnit"><?= $this->getHtml('PriceUnit'); ?></label>
                            <tr><td><select id="iPPriceUnit" name="ppriceunit">
                                        <option value="0">
                                    </select><td>
                            <tr><td><label for="iPQuantityUnit"><?= $this->getHtml('QuantityUnit'); ?></label>
                            <tr><td><select id="iPQuantityUnit" name="pquantityunit">
                                        <option value="0">
                                    </select><td>
                            <tr><td><label for="iPTradingUnit"><?= $this->getHtml('TradingUnit'); ?></label>
                            <tr><td><input id="iPTradingUnit" name="tradingunit" type="number" min="0" step="any" placeholder="">
                            <tr><td><label for="iPTracking"><?= $this->getHtml('Tracking'); ?></label>
                            <tr><td><select id="iPTracking" name="tracking">
                                        <option><?= $this->getHtml('None'); ?>
                                        <option><?= $this->getHtml('Lot'); ?>
                                        <option><?= $this->getHtml('SN'); ?>
                                    </select>
                            <tr><td><label for="iPInfo"><?= $this->getHtml('Info'); ?></label>
                            <tr><td><textarea id="iPInfo" name="pinfo"></textarea>
                        </table>
                    </form>
                </div>
            </section>

            <section class="box w-33 floatLeft">
                <header><h1><?= $this->getHtml('Price'); ?></h1></header>
                <div class="inner">
                    <form action="<?= \phpOMS\Uri\UriFactory::build('{/base}/{/lang}/api/...'); ?>" method="post">
                        <table class="layout wf-100">
                            <tbody>
                            <tr><td><label for="iPName"><?= $this->getHtml('Name'); ?></label>
                            <tr><td><input id="iPName" name="pname" type="text" placeholder="">
                            <tr><td><label for="iPQuantity"><?= $this->getHtml('Quantity'); ?></label>
                            <tr><td><input id="iPQuantity" name="quantity" type="text" placeholder="">
                            <tr><td><label for="iPrice"><?= $this->getHtml('Price'); ?></label>
                            <tr><td><input id="iPrice" name="price" type="number" step="any" min="0" placeholder=""><td>
                            <tr><td><label for="iDiscount"><?= $this->getHtml('Discount'); ?></label>
                            <tr><td><input id="iDiscount" name="discount" type="number" step="any" min="0" placeholder="">
                            <tr><td><label for="iDiscount"><?= $this->getHtml('DiscountP'); ?></label>
                            <tr><td><input id="iDiscountP" name="discountp" type="number" step="any" min="0" placeholder="">
                            <tr><td><label for="iBonus"><?= $this->getHtml('Bonus'); ?></label>
                            <tr><td><input id="iBonus" name="bonus" type="number" step="any" min="0" placeholder="">
                            <tr><td><input type="submit" value="<?= $this->getHtml('Add', 0, 0); ?>">
                        </table>
                    </form>
                </div>
            </section>

            <section class="box w-33 floatLeft">
                <header><h1><?= $this->getHtml('Stock'); ?></h1></header>
                <div class="inner">
                    <form action="<?= \phpOMS\Uri\UriFactory::build('{/base}/{/lang}/api/...'); ?>" method="post">
                        <table class="layout wf-100">
                            <tbody>
                            <tr><td><label for="iPVariation"><?= $this->getHtml('Stock'); ?></label>
                            <tr><td><select id="iPVariation" name="pvariation">
                                        <option value="0">
                                    </select>
                            <tr><td><label for="iPName"><?= $this->getHtml('ReorderLevel'); ?></label>
                            <tr><td><input id="iPName" name="pname" type="text" placeholder="">
                            <tr><td><label for="iPName"><?= $this->getHtml('MinimumLevel'); ?></label>
                            <tr><td><input id="iPName" name="pname" type="text" placeholder="">
                            <tr><td><label for="iPName"><?= $this->getHtml('MaximumLevel'); ?></label>
                            <tr><td><input id="iPName" name="pname" type="text" placeholder="">
                            <tr><td><label for="iPName"><?= $this->getHtml('Leadtime'); ?></label>
                            <tr><td><input id="iPName" name="pname" type="number" min="0" step="1" placeholder="">
                            <tr><td><input type="submit" value="<?= $this->getHtml('Save', 0); ?>">
                        </table>
                    </form>
                </div>
            </section>

            <section class="box w-33 floatLeft">
                <header><h1><?= $this->getHtml('Supplier'); ?></h1></header>
                <div class="inner">
                    <form action="<?= \phpOMS\Uri\UriFactory::build('{/base}/{/lang}/api/...'); ?>" method="post">
                        <table class="layout wf-100">
                            <tbody>
                            <tr><td><label for="iPName"><?= $this->getHtml('Name'); ?></label>
                            <tr><td><input id="iPName" name="pname" type="text" placeholder="">
                            <tr><td><label for="iPName"><?= $this->getHtml('Description'); ?></label>
                            <tr><td><textarea></textarea>
                            <tr><td><input type="submit" value="<?= $this->getHtml('Add', 0, 0); ?>">
                        </table>
                    </form>
                </div>
            </section>
        </div>
        <input type="radio" id="c-tab-6" name="tabular-2">
        <div class="tab">
            <section class="box w-33 floatLeft">
                <header><h1><?= $this->getHtml('Accounting'); ?></h1></header>
                <div class="inner">
                    <form action="<?= \phpOMS\Uri\UriFactory::build('{/base}/{/lang}/api/...'); ?>" method="post">
                        <table class="layout wf-100">
                            <tbody>
                            <tr><td colspan="2"><label for="iACostIndicator"><?= $this->getHtml('CostIndicator'); ?></label>
                            <tr><td><input id="iACostIndicator" name="costindicator" type="text" placeholder="">
                            <tr><td colspan="2"><label for="iAEarningIndicator"><?= $this->getHtml('EarningIndicator'); ?></label>
                            <tr><td><input id="iAEarningIndicator" name="earningindicator" type="text" placeholder="">
                            <tr><td colspan="2"><label for="iACostIndicator"><?= $this->getHtml('CostCenter'); ?></label>
                            <tr><td><input id="iACostIndicator" name="costindicator" type="text" placeholder="">
                            <tr><td colspan="2"><label for="iAEarningIndicator"><?= $this->getHtml('CostObject'); ?></label>
                            <tr><td><input id="iAEarningIndicator" name="earningindicator" type="text" placeholder="">
                        </table>
                    </form>
                </div>
            </section>
        </div>
        <input type="radio" id="c-tab-7" name="tabular-2">
        <div class="tab">
            <section class="box w-33 floatLeft">
                <header><h1><?= $this->getHtml('Production'); ?></h1></header>
                <div class="inner">
                    <form action="<?= \phpOMS\Uri\UriFactory::build('{/base}/{/lang}/api/...'); ?>" method="post">
                        <table class="layout wf-100">
                            <tbody>
                            <tr><td><label for="iPType"><?= $this->getHtml('Status'); ?></label>
                            <tr><td><select id="iPType" name="ptye">
                                        <option>
                                    </select>
                            <tr><td><label for="iDiscount"><?= $this->getHtml('Makespan'); ?></label>
                            <tr><td><input id="iDiscount" name="discount" type="number" step="any" min="0" placeholder="">
                            <tr><td><label for="iPType"><?= $this->getHtml('TimeUnit'); ?></label>
                            <tr><td><select id="iPType" name="ptye">
                                        <option value="0">ms
                                        <option value="1">s
                                        <option value="2">m
                                        <option value="3">h
                                        <option value="4">d
                                    </select>
                            <tr><td><label for="iPName"><?= $this->getHtml('Info'); ?></label>
                            <tr><td><textarea></textarea>
                            <tr><td><input type="submit" value="<?= $this->getHtml('Add', 0, 0); ?>">
                        </table>
                    </form>
                </div>
            </section>
        </div>
        <input type="radio" id="c-tab-8" name="tabular-2">
        <div class="tab">
            <section class="box w-33 floatLeft">
                <header><h1><?= $this->getHtml('StockList'); ?></h1></header>
                <div class="inner">
                    <form action="<?= \phpOMS\Uri\UriFactory::build('{/base}/{/lang}/api/...'); ?>" method="post">
                        <table class="layout wf-100">
                            <tbody>
                            <tr><td><label for="iSource"><?= $this->getHtml('ID'); ?></label>
                            <tr><td><span class="input"><button type="button" formaction=""><i class="fa fa-book"></i></button><input id="iSource" name="source" type="text" placeholder=""></span>
                            <tr><td><label for="iDiscount"><?= $this->getHtml('Quantity'); ?></label>
                            <tr><td><input id="iDiscount" name="discount" type="number" step="any" min="0" placeholder="">
                            <tr><td><input type="submit" value="<?= $this->getHtml('Add', 0, 0); ?>">
                        </table>
                    </form>
                </div>
            </section>
        </div>
        <input type="radio" id="c-tab-9" name="tabular-2">
        <div class="tab">
            <section class="box w-33 floatLeft">
                <header><h1><?= $this->getHtml('QM'); ?></h1></header>
                <div class="inner">
                    <form action="<?= \phpOMS\Uri\UriFactory::build('{/base}/{/lang}/api/...'); ?>" method="post">
                        <table class="layout wf-100">
                            <tbody>
                        </table>
                    </form>
                </div>
            </section>
        </div>
        <input type="radio" id="c-tab-10" name="tabular-2">
        <div class="tab">
            <section class="box w-33 floatLeft">
                <header><h1><?= $this->getHtml('Packaging'); ?></h1></header>
                <div class="inner">
                    <form action="<?= \phpOMS\Uri\UriFactory::build('{/base}/{/lang}/api/...'); ?>" method="post">
                        <table class="layout wf-100">
                            <tbody>
                            <tr><td><label for="iPVariation"><?= $this->getHtml('Container'); ?></label>
                            <tr><td><select id="iPVariation" name="pvariation">
                                        <option value="0">
                                    </select>
                            <tr><td><label for="iDiscount"><?= $this->getHtml('Quantity'); ?></label>
                            <tr><td><input id="iDiscount" name="discount" type="number" step="any" min="0" placeholder="">
                            <tr><td><label for="iDiscount"><?= $this->getHtml('GrossWeight'); ?></label>
                            <tr><td><input id="iDiscount" name="discount" type="number" step="any" min="0" placeholder="">
                            <tr><td><label for="iDiscount"><?= $this->getHtml('NetWeight'); ?></label>
                            <tr><td><input id="iDiscount" name="discount" type="number" step="any" min="0" placeholder="">
                            <tr><td><label for="iDiscount"><?= $this->getHtml('Width'); ?></label>
                            <tr><td><input id="iDiscount" name="discount" type="number" step="any" min="0" placeholder="">
                            <tr><td><label for="iDiscount"><?= $this->getHtml('Height'); ?></label>
                            <tr><td><input id="iDiscount" name="discount" type="number" step="any" min="0" placeholder="">
                            <tr><td><label for="iDiscount"><?= $this->getHtml('Length'); ?></label>
                            <tr><td><input id="iDiscount" name="discount" type="number" step="any" min="0" placeholder="">
                            <tr><td><label for="iDiscount"><?= $this->getHtml('Volume'); ?></label>
                            <tr><td><input id="iDiscount" name="discount" type="number" step="any" min="0" placeholder="">
                            <tr><td><input type="submit" value="<?= $this->getHtml('Add', 0, 0); ?>">
                        </table>
                    </form>
                </div>
            </section>
        </div>
        <input type="radio" id="c-tab-11" name="tabular-2">
        <div class="tab">
            <section class="box w-33 floatLeft">
                <header><h1><?= $this->getHtml('Media'); ?></h1></header>
                <div class="inner">
                    <form action="<?= \phpOMS\Uri\UriFactory::build('{/base}/{/lang}/api/...'); ?>" method="post">
                        <table class="layout wf-100">
                            <tbody>
                            <tr><td><label for="iDiscount"><?= $this->getHtml('Media'); ?></label>
                            <tr><td><input id="iDiscount" name="discount" type="file" multiple>
                            <tr><td><input type="submit" value="<?= $this->getHtml('Add', 0, 0); ?>">
                        </table>
                    </form>
                </div>
            </section>
        </div>
        <input type="radio" id="c-tab-12" name="tabular-2">
        <div class="tab">
            <section class="box w-33 floatLeft">
                <header><h1><?= $this->getHtml('Stock'); ?></h1></header>
                <div class="inner">
                    <form action="<?= \phpOMS\Uri\UriFactory::build('{/base}/{/lang}/api/...'); ?>" method="post">
                        <table class="layout wf-100">
                            <tbody>
                            <tr><td><label for="iPVariation"><?= $this->getHtml('ShelfLife'); ?></label>
                            <tr><td><input id="iDiscount" name="discount" type="number" min="0" step="1">
                        </table>
                    </form>
                </div>
            </section>

            <section class="box w-33 floatLeft">
                <header><h1><?= $this->getHtml('Stock'); ?></h1></header>
                <div class="inner">
                    <form action="<?= \phpOMS\Uri\UriFactory::build('{/base}/{/lang}/api/...'); ?>" method="post">
                        <table class="layout wf-100">
                            <tbody>
                            <tr><td><label for="iPVariation"><?= $this->getHtml('Stock'); ?></label>
                            <tr><td><select id="iPVariation" name="pvariation">
                                        <option value="0">
                                    </select>
                            <tr><td><label for="iPVariation"><?= $this->getHtml('Warehouse'); ?></label>
                            <tr><td><select id="iPVariation" name="pvariation">
                                        <option value="0">
                                    </select>
                            <tr><td><label for="iPVariation"><?= $this->getHtml('Location'); ?></label>
                            <tr><td><input id="iDiscount" name="discount" type="text"><!-- can also be empty if dynamically assigned instead of fixed -->
                            <tr><td><input type="submit" value="<?= $this->getHtml('Add', 0, 0); ?>">
                        </table>
                    </form>
                </div>
            </section>
        </div>
        <input type="radio" id="c-tab-13" name="tabular-2">
        <div class="tab">
            <section class="box w-33 floatLeft">
                <header><h1><?= $this->getHtml('Disposal'); ?></h1></header>
                <div class="inner">
                    <form action="<?= \phpOMS\Uri\UriFactory::build('{/base}/{/lang}/api/...'); ?>" method="post">
                        <table class="layout wf-100">
                            <tbody>
                        </table>
                    </form>
                </div>
            </section>
        </div>
        <input type="radio" id="c-tab-14" name="tabular-2">
        <div class="tab">
            <section class="box w-33 floatLeft">
                <header><h1><?= $this->getHtml('Files'); ?></h1></header>
                <div class="inner">
                    <form action="<?= \phpOMS\Uri\UriFactory::build('{/base}/{/lang}/api/...'); ?>" method="post">
                        <table class="layout wf-100">
                            <tbody>
                            <tr><td><label for="iDiscount"><?= $this->getHtml('Files'); ?></label>
                            <tr><td><input id="iDiscount" name="discount" type="file" multiple>
                            <tr><td><input type="submit" value="<?= $this->getHtml('Add', 0, 0); ?>">
                        </table>
                    </form>
                </div>
            </section>
        </div>
        <input type="radio" id="c-tab-15" name="tabular-2">
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
                        <td>Creating item
                        <td><?= $this->printHtml((new \DateTime('now'))->format('Y-m-d H:i:s')); ?>
                </table>
            </div>
        </div>
    </div>
</div>

<!--
@todo:
    maybe put a master variations selection at the beginning so that you need to change it for other variations...
    this way you will however not be able to see all at once only one at a time
    make container in packaging department that can be used by packaging for sales and purchase
    Shelf life (stock???)
    Packaging dimension+weight+units for different types (pallet, case etc.)
    Language for all variations based on variables: e.g. ${size} T-shirt in ${color}

    stock vergleichbar mit filiale
    warehouse lager in einer filiale (sd e.g. werkstatt, impla, safe, etc),
-->
