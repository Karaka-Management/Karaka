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

$employee = $this->getData('employee');

echo $this->getData('nav')->render(); ?>

<div class="row">
    <div class="col-xs-12 col-md-6">
        <section itemscope itemtype="http://schema.org/Person" class="box wf-100">
            <header><h1><span itemprop="familyName"><?= $this->printHtml($employee->getAccount()->getName3()); ?></span>, <span itemprop="givenName"><?= $this->printHtml($employee->getAccount()->getName1()); ?></span></h1></header>
            <div class="inner">
                <!-- @formatter:off -->
                        <table class="list">
                            <tr>
                                <th><?= $this->getHtml('Position') ?>
                                <td itemprop="jobTitle"><?= $this->printHtml($employee->getPosition()->getName()); ?>
                            <tr>
                                <th><?= $this->getHtml('Department') ?>
                                <td itemprop="jobTitle"><?= $this->printHtml($employee->getDepartment()->getName()); ?>
                            <tr>
                                <th><?= $this->getHtml('Unit') ?>
                                <td itemprop="jobTitle"><?= $this->printHtml($employee->getUnit()->getName()); ?>
                            <tr>
                                <th><?= $this->getHtml('Birthday') ?>
                                <td itemprop="birthDate">06.09.1934
                            <tr>
                                <th><?= $this->getHtml('Email') ?>
                                <td itemprop="email"><a href="mailto:>donald.duck@email.com<"><?= $this->printHtml($employee->getAccount()->getEmail()); ?></a>
                            <tr>
                                <th>Address
                                <td>
                            <tr>
                                <th class="vT">Private
                                <td itemprop="address">SMALLSYS INC<br>795 E DRAGRAM<br>TUCSON AZ 85705<br>USA
                            <tr>
                                <th class="vT">Work
                                <td itemprop="address">SMALLSYS INC<br>795 E DRAGRAM<br>TUCSON AZ 85705<br>USA
                            <tr>
                                <th><?= $this->getHtml('Phone') ?>
                                <td>
                            <tr>
                                <th>Private
                                <td itemprop="telephone">+01 12345-4567
                            <tr>
                                <th>Mobile
                                <td itemprop="telephone">+01 12345-4567
                            <tr>
                                <th>Work
                                <td itemprop="telephone">+01 12345-4567
                            <tr>
                                <th><?= $this->getHtml('Status') ?>
                                <td><span class="tag green"><?= $this->printHtml($employee->getAccount()->getStatus()); ?></span>
                        </table>
                    <!-- @formatter:on -->
            </div>
        </section>
    </div>

    <div class="col-xs-12 col-md-6">
        <section class="box wf-100">
        <header><h1><?= $this->getHtml('Clocking') ?></h1></header>
            <div class="inner">
            </div>
        </section>
    </div>
</div>

<div class="row">
    <div class="col-xs-12 col-md-6">
        <section class="box wf-100">
            <header><h1><?= $this->getHtml('Clocking') ?></h1></header>
            <div class="inner">
            </div>
        </section>
    </div>

    <div class="col-xs-12 col-md-6">
        <section class="box wf-100">
            <header><h1><?= $this->getHtml('History') ?></h1></header>
            <div class="inner">
            </div>
        </section>
    </div>
</div>