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

<div class="row">
    <div class="col-xs-12 col-md-6">
        <section class="box wf-100">
            <header><h1><?= $this->getHtml('Account') ?></h1></header>
            <div class="inner">
                <form>
                    <table class="layout wf-100">
                        <tr><td><label for="iAccount"><?= $this->getHtml('Account') ?></label>
                        <tr><td><span class="input"><button type="button" formaction=""><i class="fa fa-book"></i></button><input type="number" min="1" id="iAccount" name="account" placeholder="&#xf007; Guest" required></span>
                        <tr><td><label for="iFrom"><?= $this->getHtml('From') ?></label>
                        <tr><td><input type="datetime-local" id="iFrom" name="from" value="<?= $this->printHtml((new \DateTime('NOW'))->format('Y-m-d\TH:i:s')); ?>">
                        <tr><td><label for="iTo"><?= $this->getHtml('To') ?></label>
                        <tr><td><input type="datetime-local" id="iTo" name="to" value="<?= $this->printHtml((new \DateTime('NOW'))->format('Y-m-d\TH:i:s')); ?>">
                        <tr><td><input type="submit" value="<?= $this->getHtml('Submit', 0, 0); ?>">
                    </table>
                </form>
            </div>
        </section>
    </div>

    <div class="col-xs-12 col-md-6">
        <section class="box wf-100">
            <header><h1><?= $this->getHtml('Statistics') ?></h1></header>
            <div class="inner">
                <table class="list wf-100">
                    <tr><td><?= $this->getHtml('Received') ?><td>0
                    <tr><td><?= $this->getHtml('Created') ?><td>0
                    <tr><td><?= $this->getHtml('Forwarded') ?><td>0
                    <tr><td><?= $this->getHtml('AverageAmount') ?><td>0
                    <tr><td><?= $this->getHtml('AverageProcessTime') ?><td>0
                    <tr><td><?= $this->getHtml('InTime') ?><td>0
                </table>
            </div>
        </section>
    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        <section class="box wf-100">
            <header><h1><?= $this->getHtml('History') ?></h1></header>
            <div class="inner" style="height: 300px">
            </div>
        </section>
    </div>
</div>
