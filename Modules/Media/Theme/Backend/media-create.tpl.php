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
            <header><h1><?= $this->getHtml('Upload') ?></h1></header>
            <div class="inner">
                <form method="POST" id="media-uploader" action="<?= \phpOMS\Uri\UriFactory::build('/{/lang}/api/media'); ?>">
                    <table class="layout wf-100">
                        <tr><td><label for="iName"><?= $this->getHtml('Name') ?></label>
                        <tr><td><input type="text" id="iName" name="name" placeholder="&#xf040;">
                        <tr><td><label for="iDescription"><?= $this->getHtml('Description') ?></label>
                        <tr><td><textarea id="iDescription" name="description"></textarea>
                        <tr><td><label for="iFiles"><?= $this->getHtml('Files') ?></label>
                        <tr><td><input type="file" id="iFiles" name="files" multiple><input name="media" type="hidden">
                        <tr><td><input type="submit" value="<?= $this->getHtml('Create', 0, 0); ?>">
                    </table>
                </form>
            </div>
        </section>
    </div>
</div>