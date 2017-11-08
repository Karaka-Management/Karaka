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
$risk = $this->getData('risk');
echo $this->getData('nav')->render(); ?>

<div class="tabular-2">
    <div class="box">
        <ul class="tab-links">
            <li><label for="c-tab-1"><?= $this->getHtml('Risk'); ?></label>
            <li><label for="c-tab-2"><?= $this->getHtml('RiskStatus'); ?></label>
            <li><label for="c-tab-3"><?= $this->getHtml('RiskObjects'); ?></label>
            <li><label for="c-tab-4"><?= $this->getHtml('RiskObjectStatus'); ?></label>
            <li><label for="c-tab-5"><?= $this->getHtml('Solutions'); ?></label>
        </ul>
    </div>
    <div class="tab-content">
        <input type="radio" id="c-tab-1" name="tabular-2" checked>
        <div class="tab">
            <div class="row">
                <div class="col-xs-12 col-md-6">
                    <section class="box wf-100">
                        <header><h1><?= $this->getHtml('Risk') ?></h1></header>

                        <div class="inner">
                            <form id="fRisk"  method="POST" action="<?= \phpOMS\Uri\UriFactory::build('/{/lang}/api/controlling/riskmanagement?{?}&csrf={$CSRF}'); ?>">
                                <table class="layout wf-100">
                                    <tbody>
                                    <tr><td><?= $this->getHtml('Name') ?><td><?= $this->printHtml($risk->getName()); ?>
                                    <tr><td><?= $this->getHtml('Description') ?><td><?= $this->printHtml($risk->getDescription()); ?>
                                    <tr><td><?= $this->getHtml('Unit') ?><td><?= $this->printHtml($risk->getUnit()->getName()); ?>
                                    <tr><td><?= $this->getHtml('Category') ?><td><?= $this->printHtml($risk->getCategory()->getTitle()); ?>
                                    <tr><td><?= $this->getHtml('Department') ?><td><?= $this->printHtml($risk->getDepartment()->getDepartment()->getName()); ?>
                                    <tr><td><?= $this->getHtml('Process') ?><td><?= $this->printHtml($risk->getProcess()->getTitle()); ?>
                                    <tr><td><?= $this->getHtml('Project') ?><td><?= $this->printHtml($risk->getProject()->getProject()->getName()); ?>
                                </table>
                            </form>
                        </div>
                    </section>
                </div>
            
                <div class="col-xs-12 col-md-6">
                    <section class="box wf-100">
                        <header><h1><?= $this->getHtml('Media') ?></h1></header>

                        <div class="inner">
                            <form>
                                <table class="layout wf-100">
                                    <tbody>
                                    <tr><td colspan="2"><label for="iMedia"><?= $this->getHtml('Media') ?></label>
                                    <tr><td><input type="text" id="iMedia" placeholder="&#xf15b; File"><td><button><?= $this->getHtml('Select') ?></button>
                                    <tr><td colspan="2"><label for="iUpload"><?= $this->getHtml('Upload') ?></label>
                                    <tr><td><input type="file" id="iUpload" form="fTask"><input form="fTask" type="hidden" name="type"><td>
                                </table>
                            </form>
                        </div>
                    </section>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 col-md-6">
                    <section class="box wf-100">
                        <header><h1><?= $this->getHtml('Responsibility') ?></h1></header>

                        <div class="inner">
                            <form>
                                <table class="layout wf-100">
                                    <tbody>
                                    <tr><td><label for="iResponsibility"><?= $this->getHtml('Responsibility') ?></label><td><label for="iUser"><?= $this->getHtml('UserGroup') ?></label><td>
                                    <tr><td><select id="iStatus" name="status">
                                                <option value="">
                                            </select>
                                        <td><span class="input"><button type="button" formaction=""><i class="fa fa-book"></i></button><input type="text" id="iUser" name="user" placeholder=""></span><td><button><?= $this->getHtml('Add', 0, 0); ?></button>
                                </table>
                            </form>
                        </div>
                    </section>
                </div>
            </div>
        </div>
        <input type="radio" id="c-tab-2" name="tabular-2">
        <div class="tab">
            <div class="row">
                <div class="col-xs-12 col-md-6">
                    <section class="box wf-100">
                        <header><h1><?= $this->getHtml('RiskStatus') ?></h1></header>

                        <div class="inner">
                            <form id="fRisk"  method="POST" action="<?= \phpOMS\Uri\UriFactory::build('/{/lang}/api/controlling/riskmanagement?{?}&csrf={$CSRF}'); ?>">
                                <table class="layout wf-100">
                                    <tbody>
                                    <tr><td><label for="iRiskConsequence"><?= $this->getHtml('RiskConsequence') ?></label>
                                    <tr><td><select id="iRiskConsequence" name="riskconsequence">

                                            </select>
                                    <tr><td><label for="iRiskLikelihood"><?= $this->getHtml('RiskLikelihood') ?></label>
                                    <tr><td><select id="iRiskLikelihood" name="risklikelihood">

                                            </select>
                                    <tr><td><label for="iRiskConsequence"><?= $this->getHtml('RiskConsequence') ?></label>
                                    <tr><td><select id="iRiskConsequence" name="riskconsequence">

                                            </select>
                                    <tr><td><label for="iRiskLikelihood"><?= $this->getHtml('RiskLikelihood') ?></label>
                                    <tr><td><select id="iRiskLikelihood" name="risklikelihood">

                                            </select>
                                    <tr><td><label for="iRiskStatusDescription"><?= $this->getHtml('Description') ?></label>
                                    <tr><td><textarea id="iRiskStatusDescription" name="riskstatusdescription"></textarea>
                                    <tr><td><input type="submit" value="<?= $this->getHtml('Create', 0, 0); ?>">
                                </table>
                            </form>
                        </div>
                    </section>
                </div>

                <div class="col-xs-12 col-md-6">
                    <section class="box wf-100">
                        <header><h1><?= $this->getHtml('Media') ?></h1></header>

                        <div class="inner">
                            <form>
                                <table class="layout wf-100">
                                    <tbody>
                                    <tr><td colspan="2"><label for="iMedia"><?= $this->getHtml('Media') ?></label>
                                    <tr><td><input type="text" id="iMedia" placeholder="&#xf15b; File"><td><button><?= $this->getHtml('Select') ?></button>
                                    <tr><td colspan="2"><label for="iUpload"><?= $this->getHtml('Upload') ?></label>
                                    <tr><td><input type="file" id="iUpload" form="fTask"><input form="fTask" type="hidden" name="type"><td>
                                </table>
                            </form>
                        </div>
                    </section>
                </div>
            </div>
        </div>
        <input type="radio" id="c-tab-3" name="tabular-2">
        <div class="tab">
            <div class="row">
                <div class="col-xs-12 col-md-6">
                    <section class="box wf-100">
                        <header><h1><?= $this->getHtml('RiskObjects') ?></h1></header>

                        <div class="inner">
                            <form id="fRisk"  method="POST" action="<?= \phpOMS\Uri\UriFactory::build('/{/lang}/api/controlling/riskmanagement?{?}&csrf={$CSRF}'); ?>">
                                <table class="layout wf-100">
                                    <tbody>
                                    <tr><td><label for="iRiskObjectName"><?= $this->getHtml('Name') ?></label>
                                    <tr><td><input type="text" id="iRiskObjectName" name="riskobjectname" placeholder="&#xf040; <?= $this->getHtml('Name') ?>">
                                    <tr><td><label for="iRiskObjectDescription"><?= $this->getHtml('Description') ?></label>
                                    <tr><td><textarea id="iRiskObjectDescription" name="riskobjectdescription"></textarea>
                                    <tr><td><input type="submit" value="<?= $this->getHtml('Create', 0, 0); ?>">
                                </table>
                            </form>
                        </div>
                    </section>
                </div>

                <div class="col-xs-12 col-md-6">
                    <section class="box wf-100">
                        <header><h1><?= $this->getHtml('Media') ?></h1></header>

                        <div class="inner">
                            <form>
                                <table class="layout wf-100">
                                    <tbody>
                                    <tr><td colspan="2"><label for="iMedia"><?= $this->getHtml('Media') ?></label>
                                    <tr><td><input type="text" id="iMedia" placeholder="&#xf15b; File"><td><button><?= $this->getHtml('Select') ?></button>
                                    <tr><td colspan="2"><label for="iUpload"><?= $this->getHtml('Upload') ?></label>
                                    <tr><td><input type="file" id="iUpload" form="fTask"><input form="fTask" type="hidden" name="type"><td>
                                </table>
                            </form>
                        </div>
                    </section>
                </div>
            </div>
        </div>
        <input type="radio" id="c-tab-4" name="tabular-2">
        <div class="tab">
            <div class="row">
                <div class="col-xs-12 col-md-6">
                    <section class="box wf-100">
                        <header><h1><?= $this->getHtml('RiskObjectStatus') ?></h1></header>

                        <div class="inner">
                            <form id="fRisk"  method="POST" action="<?= \phpOMS\Uri\UriFactory::build('/{/lang}/api/controlling/riskmanagement?{?}&csrf={$CSRF}'); ?>">
                                <table class="layout wf-100">
                                    <tbody>
                                    <tr><td><label for="iRiskObjectNameValue"><?= $this->getHtml('RiskObject') ?></label>
                                    <tr><td><select id="iRiskObjectNameValue" name="riskobjectnamevalue">

                                            </select>
                                    <tr><td><label for="iRiskObjecValue"><?= $this->getHtml('Value') ?></label>
                                    <tr><td><input type="text" id="iRiskObjecValue" name="riskobjectvalue">
                                    <tr><td><label for="iRiskObjecValueDescription"><?= $this->getHtml('Description') ?></label>
                                    <tr><td><textarea id="iRiskObjecValueDescription" name="riskobjectvaluedescription"></textarea>
                                    <tr><td><input type="submit" value="<?= $this->getHtml('Create', 0, 0); ?>">
                                </table>
                            </form>
                        </div>
                    </section>
                </div>

                <div class="col-xs-12 col-md-6">
                    <section class="box wf-100">
                        <header><h1><?= $this->getHtml('Media') ?></h1></header>

                        <div class="inner">
                            <form>
                                <table class="layout wf-100">
                                    <tbody>
                                    <tr><td colspan="2"><label for="iMedia"><?= $this->getHtml('Media') ?></label>
                                    <tr><td><input type="text" id="iMedia" placeholder="&#xf15b; File"><td><button><?= $this->getHtml('Select') ?></button>
                                    <tr><td colspan="2"><label for="iUpload"><?= $this->getHtml('Upload') ?></label>
                                    <tr><td><input type="file" id="iUpload" form="fTask"><input form="fTask" type="hidden" name="type"><td>
                                </table>
                            </form>
                        </div>
                    </section>
                </div>
            </div>
        </div>
        <input type="radio" id="c-tab-5" name="tabular-2">
        <div class="tab">
            <div class="row">
                <div class="col-xs-12 col-md-6">
                    <section class="box wf-100">
                        <header><h1><?= $this->getHtml('Solution') ?></h1></header>

                        <div class="inner">
                            <form id="fRisk"  method="POST" action="<?= \phpOMS\Uri\UriFactory::build('/{/lang}/api/controlling/riskmanagement?{?}&csrf={$CSRF}'); ?>">
                                <table class="layout wf-100">
                                    <tbody>
                                    <tr><td><label for="iSolutionName"><?= $this->getHtml('Name') ?></label>
                                    <tr><td><input type="text" id="iSolutionName" name="solutionname">
                                    <tr><td><label for="iSolutioType"><?= $this->getHtml('Type') ?></label>
                                    <tr><td><select id="iSolutioType" name="solutiontype">
                                                <option>Preventing
                                                <option>Disclosing
                                            </select>
                                    <tr><td><label for="iSolutioFrequency"><?= $this->getHtml('Frequency') ?></label>
                                    <tr><td><select id="iSolutioFrequency" name="solutionfrequency">
                                                <option>Permanently
                                                <option>Daily
                                                <option>Weekly
                                                <option>Monthly
                                                <option>Quarterly
                                                <option>Semiannual
                                                <option>Annual
                                            </select>
                                    <tr><td><label for="iSolutioAssessment"><?= $this->getHtml('Assessment') ?></label>
                                    <tr><td><select id="iSolutioAssessment" name="solutionassessment">
                                                <option>Manual
                                                <option>IT-dependent
                                                <option>IT
                                            </select>
                                    <tr><td><label for="iSolutionDescription"><?= $this->getHtml('Description') ?></label>
                                    <tr><td><textarea id="iSolutionDescription" name="solutionDescription"></textarea>
                                    <tr><td><input type="submit" value="<?= $this->getHtml('Create', 0, 0); ?>">
                                </table>
                            </form>
                        </div>
                    </section>
                </div>

                <div class="col-xs-12 col-md-6">
                    <section class="box wf-100">
                        <header><h1><?= $this->getHtml('Media') ?></h1></header>

                        <div class="inner">
                            <form>
                                <table class="layout wf-100">
                                    <tbody>
                                    <tr><td colspan="2"><label for="iMedia"><?= $this->getHtml('Media') ?></label>
                                    <tr><td><input type="text" id="iMedia" placeholder="&#xf15b; File"><td><button><?= $this->getHtml('Select') ?></button>
                                    <tr><td colspan="2"><label for="iUpload"><?= $this->getHtml('Upload') ?></label>
                                    <tr><td><input type="file" id="iUpload" form="fTask"><input form="fTask" type="hidden" name="type"><td>
                                </table>
                            </form>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</div>