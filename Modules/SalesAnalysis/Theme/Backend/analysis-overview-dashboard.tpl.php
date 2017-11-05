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

<div class="box w-100">
    <div class="tabular-2">
        <ul class="tab-links">
            <li><label for="c-tab2-1"><?= $this->getHtml('Overview') ?></label>
            <li><label for="c-tab2-2"><?= $this->getHtml('Month') ?></label>
            <li><label for="c-tab2-3"><?= $this->getHtml('Year') ?></label>
            <li><label for="c-tab2-4"><?= $this->getHtml('Top10') ?></label>
            <li><label for="c-tab2-5"><?= $this->getHtml('Charts') ?></label>
        </ul>
        <div class="tab-content">
            <input type="radio" id="c-tab2-1" name="tabular-2" checked>
            <div class="tab">
                <section class="box wf-100 floatLeft">
                    <table class="table red">
                        <caption><?= $this->getHtml('Overview'); ?></caption>
                        <thead>
                        <tr>
                            <td><?= $this->getHtml('Type') ?>
                            <td><?= $this->getHtml('LastMonth') ?>
                            <td><?= $this->getHtml('CurrentMonth') ?>
                            <td><?= $this->getHtml('Change') ?>
                            <td><?= $this->getHtml('LastYear') ?>
                            <td><?= $this->getHtml('CurrentYear') ?>
                            <td><?= $this->getHtml('Change') ?>
                            <td><?= $this->getHtml('LastYearAcc') ?>
                            <td><?= $this->getHtml('CurrentYearAcc') ?>
                            <td><?= $this->getHtml('Change') ?>
                            <td><?= $this->getHtml('LastYear') ?>
                            <td><?= $this->getHtml('Forecast') ?>
                            <td><?= $this->getHtml('Change') ?>
                        <tbody>
                            <tr><th><?= $this->getHtml('Domestic') ?><td><td><td><td><td><td><td><td><td><td><td><td>
                            <tr><th><?= $this->getHtml('Export') ?><td><td><td><td><td><td><td><td><td><td><td><td>
                            <tr><th><?= $this->getHtml('Developed') ?><td><td><td><td><td><td><td><td><td><td><td><td>
                            <tr><th><?= $this->getHtml('Undeveloped') ?><td><td><td><td><td><td><td><td><td><td><td><td>
                            <tr><th><?= $this->getHtml('Europe') ?><td><td><td><td><td><td><td><td><td><td><td><td>
                            <tr><th><?= $this->getHtml('America') ?><td><td><td><td><td><td><td><td><td><td><td><td>
                            <tr><th><?= $this->getHtml('Asia') ?><td><td><td><td><td><td><td><td><td><td><td><td>
                            <tr><th><?= $this->getHtml('Africa') ?><td><td><td><td><td><td><td><td><td><td><td><td>
                            <tr><th><?= $this->getHtml('Total') ?><td><td><td><td><td><td><td><td><td><td><td><td>
                    </table>
                </section>

                <section class="box wf-100 floatLeft">
                    <table class="table red">
                        <caption><?= $this->getHtml('Misc'); ?></caption>
                        <thead>
                        <tr>
                            <td><?= $this->getHtml('Type') ?>
                            <td><?= $this->getHtml('LastYear') ?>
                            <td><?= $this->getHtml('CurrentYear') ?>
                            <td><?= $this->getHtml('LastMonth') ?>
                            <td><?= $this->getHtml('CurrentMonth') ?>
                            <td><?= $this->getHtml('Yesterday') ?>
                            <td><?= $this->getHtml('Today') ?>
                        <tbody>
                            <tr><th><?= $this->getHtml('Customers') ?><td><td><td><td><td><td>
                            <tr><th><?= $this->getHtml('Invoices') ?><td><td><td><td><td><td>
                    </table>
                </section>
            </div>
            <input type="radio" id="c-tab2-2" name="tabular-2">
            <div class="tab tab-2">
                <section class="box wf-100 floatLeft">
                    <table class="table red">
                        <caption><?= $this->getHtml('Month'); ?></caption>
                        <thead>
                        <tr>
                            <td><?= $this->getHtml('Day') ?>
                            <td><?= $this->getHtml('Day') ?>
                            <td><?= $this->getHtml('LastMonth') ?>
                            <td><?= $this->getHtml('CurrentMonth') ?>
                            <td><?= $this->getHtml('Change') ?>
                            <td><?= $this->getHtml('ChangeAcc') ?>
                        <tbody>
                        <tr><td><td><td><td><td><td>
                    </table>
                </section>
            </div>
            <input type="radio" id="c-tab2-3" name="tabular-2">
            <div class="tab tab-3">
                <section class="box wf-100 floatLeft">
                    <table class="table red">
                        <caption><?= $this->getHtml('Year'); ?></caption>
                        <thead>
                        <tr>
                            <td><?= $this->getHtml('Year') ?>
                            <td><?= $this->getHtml('January') ?>
                            <td><?= $this->getHtml('February') ?>
                            <td><?= $this->getHtml('March') ?>
                            <td><?= $this->getHtml('April') ?>
                            <td><?= $this->getHtml('May') ?>
                            <td><?= $this->getHtml('June') ?>
                            <td><?= $this->getHtml('July') ?>
                            <td><?= $this->getHtml('August') ?>
                            <td><?= $this->getHtml('September') ?>
                            <td><?= $this->getHtml('October') ?>
                            <td><?= $this->getHtml('November') ?>
                            <td><?= $this->getHtml('December') ?>
                        <tbody>
                        <tr><th>2013<td><td><td><td><td><td><td><td><td><td><td><td>
                        <tr><th>2014<td><td><td><td><td><td><td><td><td><td><td><td>
                        <tr><th>2015<td><td><td><td><td><td><td><td><td><td><td><td>
                        <tr><th>CY 2016<td><td><td><td><td><td><td><td><td><td><td><td>
                        <tr><th>2017<td><td><td><td><td><td><td><td><td><td><td><td>
                        <tr><th>2018<td><td><td><td><td><td><td><td><td><td><td><td>
                        <tr><th>2019<td><td><td><td><td><td><td><td><td><td><td><td>
                        <tr><th>2020<td><td><td><td><td><td><td><td><td><td><td><td>
                        <tr><th>2021<td><td><td><td><td><td><td><td><td><td><td><td>
                    </table>
                </section>
            </div>
            <input type="radio" id="c-tab2-4" name="tabular-2">
            <div class="tab tab-4">
                <section class="box w-33 floatLeft">
                    <header>
                        <h1><?= $this->getHtml('Customers') ?></h1>
                    </header>
                    <div class="inner">
                    </div>
                </section>
                <section class="box w-33 floatLeft">
                    <header>
                        <h1><?= $this->getHtml('Products') ?></h1>
                    </header>
                    <div class="inner">
                    </div>
                </section>
                <section class="box w-33 floatLeft">
                    <header>
                        <h1><?= $this->getHtml('Employees') ?></h1>
                    </header>
                    <div class="inner">
                    </div>
                </section>
            </div>
            <input type="radio" id="c-tab2-5" name="tabular-2">
            <div class="tab tab-5">
                <section class="box w-33 floatLeft">
                    <header>
                        <h1><?= $this->getHtml('Domestic/Export') ?></h1>
                    </header>
                    <div class="inner">
                    </div>
                </section>
                <section class="box w-33 floatLeft">
                    <header>
                        <h1><?= $this->getHtml('Developed/Undeveloped') ?></h1>
                    </header>
                    <div class="inner">
                    </div>
                </section>
                <section class="box w-33 floatLeft">
                    <header>
                        <h1><?= $this->getHtml('Continents') ?></h1>
                    </header>
                    <div class="inner">
                    </div>
                </section>
                <section class="box w-100 floatLeft">
                    <header>
                        <h1><?= $this->getHtml('Development') ?></h1>
                    </header>
                    <div class="inner">
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>