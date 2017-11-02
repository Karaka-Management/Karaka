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

echo $this->getData('nav')->render(); ?>

<div class="row">
    <div class="col-xs-12 col-md-6">
        <section class="box wf-100">
            <header><h1><?= $this->getHtml('Project') ?></h1></header>
            <div class="inner">
                <form>
                    <table class="layout wf-100">
                        <tr><td colspan="3"><label for="iName"><?= $this->getHtml('Name') ?></label>
                        <tr><td colspan="2"><input type="text" id="iName" name="name" placeholder="" required><td>
                        <tr><td colspan="3"><label for="iDescription"><?= $this->getHtml('Description') ?></label>
                        <tr><td colspan="2"><textarea id="iDescription" name="description"></textarea><td>
                        <tr><td colspan="3"><label for="iStatus"><?= $this->getHtml('Status') ?></label>
                        <tr><td colspan="2"><select id="iStatus" name="status">
                                    <option value="<?= $this->printHtml(\Modules\ProjectManagement\Models\ProjectStatus::ACTIVE ); ?>"><?= $this->getHtml('Active') ?>
                                    <option value="<?= $this->printHtml(\Modules\ProjectManagement\Models\ProjectStatus::INACTIVE ); ?>"><?= $this->getHtml('Inactive') ?>
                                    <option value="<?= $this->printHtml(\Modules\ProjectManagement\Models\ProjectStatus::FINISHED ); ?>"><?= $this->getHtml('Finished') ?>
                                    <option value="<?= $this->printHtml(\Modules\ProjectManagement\Models\ProjectStatus::CANCELED ); ?>"><?= $this->getHtml('Canceled') ?>
                                    <option value="<?= $this->printHtml(\Modules\ProjectManagement\Models\ProjectStatus::HOLD ); ?>"><?= $this->getHtml('Hold') ?>
                                </select><td>
                        <tr><td colspan="3"><label for="iFiles"><?= $this->getHtml('Files') ?></label>
                        <tr><td colspan="2"><input type="file" id="iFiles" name="file" multiple><td>
                        <tr><td><label for="iDue"><?= $this->getHtml('Start') ?></label><td><label for="iDue"><?= $this->getHtml('Due') ?></label><td>
                        <tr><td><input type="datetime-local" id="iDue" name="due"><td><input type="datetime-local" id="iDue" name="due"><td>
                        <tr><td><label for="iResponsibility"><?= $this->getHtml('Responsibility') ?></label><td><label for="iUser"><?= $this->getHtml('UserGroup') ?></label><td>
                        <tr><td><select id="iStatus" name="status">
                                    <option value="<?= $this->printHtml(\Modules\ProjectManagement\Models\ProjectResponsibility::MANAGER ); ?>"><?= $this->getHtml('Manager') ?>
                                    <option value="<?= $this->printHtml(\Modules\ProjectManagement\Models\ProjectResponsibility::OTHER ); ?>"><?= $this->getHtml('Other') ?>
                                </select>
                            <td><span class="input"><button type="button" formaction=""><i class="fa fa-book"></i></button><input type="text" id="iUser" name="user" placeholder=""></span><td><button><?= $this->getHtml('Add', 0, 0); ?></button>
                        <tr><td colspan="3"><label for="iBudget"><?= $this->getHtml('Budget') ?></label>
                        <tr><td colspan="2"><input type="text" id="iBudget" name="budget" placeholder=""><td>
                        <tr><td colspan="3"><input type="submit" value="<?= $this->getHtml('Create', 0, 0); ?>">
                    </table>
                </form>
            </div>
        </section>
    </div>
</div>