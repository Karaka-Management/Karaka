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
echo $this->getData('nav')->render(); ?>

<div class="row">
    <div class="col-xs-12 col-md-6">
        <section class="box wf-100">
            <header><h1><?= $this->getHtml('Survey'); ?></h1></header>
            <div class="inner">
                <form>
                    <table class="layout wf-100">
                        <tr><td colspan="3"><label for="iName"><?= $this->getHtml('Name'); ?><label>
                        <tr><td colspan="2"><input type="text" id="iName" name="name" required><td>
                        <tr><td><label for="iStart"><?= $this->getHtml('Start'); ?><label><td><label for="iEnd"><?= $this->getHtml('End'); ?><label><td>
                        <tr><td><input type="datetime-local" id="iStart" name="start" required><td><input type="datetime-local" id="iEnd" name="end" required><td>
                        <tr><td colspan="3"><label for="iDesc"><?= $this->getHtml('Description'); ?><label>
                        <tr><td colspan="2"><textarea id="iDesc" name="desc"></textarea><td>
                        <tr><td colspan="3"><span class="check"><input type="checkbox" id="iResult" name="result"><label for="iResult"><?= $this->getHtml('ResultPublic'); ?><label></span>
                        <tr><td><label for="iResponsibility"><?= $this->getHtml('Responsibility'); ?><label><td colspan="2"><label for="iPerm"><?= $this->getHtml('UserGroup'); ?><label>
                        <tr><td><select id="iResponsibility" name="responsibility">
                                <option value=""><?= $this->getHtml('Questionee'); ?>
                                <option value=""><?= $this->getHtml('Manager'); ?>
                            </select><td><span class="input"><button type="button" formaction=""><i class="fa fa-book"></i></button><input type="text" id="iPerm" name="permission"></span><td><button><?= $this->getHtml('Add', 0, 0); ?></button>
                        <tr><td colspan="3"><input type="submit" value="<?= $this->getHtml('Create', 0, 0); ?>">
                    </table>
                </form>
            </div>
        </section>
    </div>

    <div class="col-xs-12 col-md-6">
        <section class="box wf-100">
            <header><h1><?= $this->getHtml('Section'); ?></h1></header>
            <div class="inner">
                <form>
                    <table class="layout wf-100">
                        <tr><td colspan="2"><label for="iSection"><?= $this->getHtml('Section'); ?><label>
                        <tr><td colspan="2"><input type="text" id="iSection" name="section">
                        <tr><td colspan="2"><label for="iSDesc"><?= $this->getHtml('Description'); ?><label>
                        <tr><td colspan="2"><textarea id="iSDesc" name="sdesc"></textarea>
                        <tr><td colspan="2"><label for="iSType"><?= $this->getHtml('Type'); ?><label>
                        <tr><td colspan="2"><select id="iSType" name="stype">
                                    <option>
                                </select>
                        <tr><td colspan="2"><input type="submit" value="<?= $this->getHtml('Add', 0, 0); ?>">
                    </table>
                </form>
            </div>
        </section>
    </div>
</div>

<div class="row">
    <div class="col-xs-12 col-md-6">
        <section class="box wf-100">
            <header><h1><?= $this->getHtml('Question'); ?></h1></header>
            <div class="inner">
                <form>
                    <table class="layout wf-100">
                        <tr><td colspan="2"><label for="iQuestion"><?= $this->getHtml('Question'); ?><label>
                        <tr><td colspan="2"><input type="text" id="iQuestion" name="question">
                        <tr><td colspan="2"><label for="iQDesc"><?= $this->getHtml('Description'); ?><label>
                        <tr><td colspan="2"><textarea id="iQDesc" name="qdesc"></textarea>
                        <tr><td colspan="2"><label for="iQSection"><?= $this->getHtml('Section'); ?><label>
                        <tr><td colspan="2"><select id="iQSection" name="iqsection">
                                                    <option>
                                            </select>
                        <tr><td colspan="2"><input type="submit" value="<?= $this->getHtml('Add', 0, 0); ?>">
                    </table>
                </form>
            </div>
        </section>
        </div>
</div>