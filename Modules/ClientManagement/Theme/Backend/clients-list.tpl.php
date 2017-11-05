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

$footerView   = new \Web\Views\Lists\PaginationView($this->app, $this->request, $this->response);
$footerView->setTemplate('/Web/Templates/Lists/Footer/PaginationBig');
$footerView->setPages(20);
$footerView->setPage(1);

$clients = $this->getData('client');

echo $this->getData('nav')->render(); ?>

<!-- Hover may be better here?!?!?!
<section class="box w-100">
    <header><h1><?= $this->getHtml('Client'); ?></h1></header>
    <div class="inner floatLeft wf-100">
        <form class="wf-33 floatLeft">
            <table class="layout w-100">
                <tr><td><label for="iName1"><?= $this->getHtml('Name1') ?></label>
                <tr><td><input type="text" id="iName1" disabled>
                <tr><td><label for="iName2"><?= $this->getHtml('Name2') ?></label>
                <tr><td><input type="text" id="iName2" disabled>
                <tr><td><label for="iName3"><?= $this->getHtml('Name3') ?></label>
                <tr><td><input type="text" id="iName3" disabled>
            </table>
        </form>
        <form class="wf-33 floatLeft">
            <table class="layout w-100">
                <tr><td><label for="iAddress"><?= $this->getHtml('Address') ?></label>
                <tr><td><input type="text" id="iAddress" disabled>
                <tr><td><label for="iZip"><?= $this->getHtml('Zip') ?></label>
                <tr><td><input type="text" id="iZip" disabled>
                <tr><td><label for="iCountry"><?= $this->getHtml('Country') ?></label>
                <tr><td><input type="text" id="iCountry" disabled>
            </table>
        </form>
        <form class="wf-33 floatLeft">
            <table class="layout w-100">
                <tr><td><label for="iPhone"><?= $this->getHtml('Phone') ?></label>
                <tr><td><input type="text" id="iPhone" disabled>
                <tr><td><label for="iFax"><?= $this->getHtml('Fax') ?></label>
                <tr><td><input type="text" id="iFax" disabled>
                <tr><td><label for="iEmail"><?= $this->getHtml('Email') ?></label>
                <tr><td><input type="text" id="iEmail" disabled>
            </table>
        </form>
    </div>
</section>
-->

<div class="row">
    <div class="col-xs-12">
        <div class="box wf-100">
            <table class="table red">
                <caption><?= $this->getHtml('Clients'); ?></caption>
                <thead>
                <tr>
                    <td><?= $this->getHtml('ID', 0, 0); ?>
                    <td><?= $this->getHtml('Name1') ?>
                    <td><?= $this->getHtml('Name2') ?>
                    <td class="wf-100"><?= $this->getHtml('Name3') ?>
                    <td><?= $this->getHtml('City') ?>
                    <td><?= $this->getHtml('Zip') ?>
                    <td><?= $this->getHtml('Address') ?>
                    <td><?= $this->getHtml('Country') ?>
                <tfoot>
                <tr>
                    <td colspan="8"><?= $footerView->render(); ?>
                <tbody>
                <?php $count = 0; foreach ($clients as $key => $value) : $count++; 
                 $url = \phpOMS\Uri\UriFactory::build('{/base}/{/lang}/backend/sales/client/profile?{?}&id=' . $value->getId()); ?>
                <tr data-href="<?= $url; ?>">
                    <td><a href="<?= $url; ?>"><?= $this->printHtml($value->getNumber()); ?></a>
                    <td><a href="<?= $url; ?>"><?= $this->printHtml($value->getProfile()->getAccount()->getName1()); ?></a>
                    <td><a href="<?= $url; ?>"><?= $this->printHtml($value->getProfile()->getAccount()->getName2()); ?></a>
                    <td><a href="<?= $url; ?>"><?= $this->printHtml($value->getProfile()->getAccount()->getName3()); ?></a>
                    <td>
                    <td>
                    <td>
                    <td>
                <?php endforeach; ?>
                <?php if ($count === 0) : ?>
                <tr><td colspan="8" class="empty"><?= $this->getHtml('Empty', 0, 0); ?>
                        <?php endif; ?>
            </table>
        </div>
    </div>
</div>
