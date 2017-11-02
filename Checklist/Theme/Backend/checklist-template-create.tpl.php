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
            <header><h1><?= $this->getHtml('General') ?></h1></header>
            <div class="inner">
                <form id="fChecklist">
                    <table class="layout wf-100">
                        <tr><td><label for="iName"><?= $this->getHtml('Name') ?></label><td>
                        <tr><td><input type="text" id="iName" name="name" required><td>
                        <tr><td><label for="iDescription"><?= $this->getHtml('Description') ?></label><td>
                        <tr><td><textarea id="iDescription" name="description"></textarea><td>
                        <tr><td><label for="iPermission"><?= $this->getHtml('Permissions') ?></label><td>
                        <tr><td><span class="input"><button type="button" formaction=""><i class="fa fa-book"></i></button>
                                    <input type="text" id="iPermission" name="permission"></span>
                            <td><button><?= $this->getHtml('Add', 0, 0); ?></button>
                        <tr><td><label for="iFiles"><?= $this->getHtml('Files') ?></label><td>
                        <tr><td><input id="iFiles" name="files" type="file" multiple><td>
                        <tr><td><input type="submit" value="<?= $this->getHtml('Create', 0, 0); ?>"><td>
                    </table>
                </form>
            </div>
        </section>
    </div>

    <div class="col-xs-12 col-md-6">
        <section class="box wf-100">
            <header><h1><?= $this->getHtml('Tasks') ?></h1></header>
            <div class="inner">
                <form>
                    <table class="layout wf-100">
                        <tr><td><label for="iETitle"><?= $this->getHtml('Title') ?></label><td>
                        <tr><td><input type="text" id="iETitle" name="eTitle" required><td>
                        <tr><td><label for="iEDescription"><?= $this->getHtml('Description') ?></label><td>
                        <tr><td><textarea id="iEDescription" name="eDescription"></textarea><td>
                        <tr><td><label for="iETime"><?= $this->getHtml('TimeInMinutes') ?></label><td>
                        <tr><td><input type="number" min="0" step="1" id="iETime" name="eTime" value="0"><td>
                        <tr><td><label for="iEPermission"><?= $this->getHtml('Permissions') ?></label><td>
                        <tr><td><span class="input"><button type="button" formaction=""><i class="fa fa-book"></i></button>
                                    <input type="text" id="iEPermission" name="ePermission"></span>
                            <td><button data-action=""><?= $this->getHtml('Add', 0, 0); ?></button>
                        <tr><td><label for="iEFiles"><?= $this->getHtml('Files') ?></label><td>
                        <tr><td><input id="iEFiles" name="eFiles" type="file" multiple><td>
                        <tr><td><input type="submit" value="<?= $this->getHtml('Add', 0, 0); ?>" data-action=""><td>
                    </table>
                </form>
            </div>
        </section>
    </div>
</div>