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

<div class="row">
    <div class="col-xs-12 col-md-6">
        <section class="box wf-100">
            <header><h1><?= $this->getHtml('Unit') ?></h1></header>
            <div class="inner">
                <form id="fUnitCreate" method="POST" action="<?= \phpOMS\Uri\UriFactory::build('{/rootPath}{/lang}/api/organization/unit'); ?>">
                    <table class="layout wf-100">
                        <tr><td><label for="iName"><?= $this->getHtml('Name') ?></label>
                        <tr><td><input type="text" name="name" id="iName" placeholder="&#xf040; Orange Management" required>
                        <tr><td><label for="iParent"><?= $this->getHtml('Parent') ?></label>
                        <tr><td><span class="input"><button type="button" formaction=""><i class="fa fa-book"></i></button><input type="text" name="parent" id="iParent"></span>
                        <tr><td><label for="iStatus"><?= $this->getHtml('Status') ?></label>
                        <tr><td><select name="status" id="iStatus">
                                    <option value="<?= $this->printHtml(\Modules\Organization\Models\Status::ACTIVE); ?>"><?= $this->getHtml('Active') ?>
                                    <option value="<?= $this->printHtml(\Modules\Organization\Models\Status::INACTIVE); ?>"><?= $this->getHtml('Inactive') ?>
                                    </select>
                        <tr><td><label for="iDescription"><?= $this->getHtml('Description') ?></label>
                        <tr><td><textarea name="description" id="iDescription" placeholder="&#xf040;"></textarea>
                        <tr><td><input type="submit" value="<?= $this->getHtml('Create', 0, 0); ?>">
                    </table>
                </form>
            </div>
        </section>
    </div>
</div>
