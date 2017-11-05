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
    <div class="col-xs-6">
        <section class="box wf-100">
            <header><h1><?= $this->getHtml('Ticket'); ?></h1></header>
            <div class="inner">
                <form action="<?= \phpOMS\Uri\UriFactory::build('{/base}/{/lang}/api/reporter/template'); ?>" method="post">
                    <table class="layout wf-100">
                        <tbody>
                        <tr><td><label for="iTitle"><?= $this->getHtml('Department'); ?></label>
                        <tr><td><select></select>
                        <tr><td><label for="iTitle"><?= $this->getHtml('Topic'); ?></label>
                        <tr><td><select></select>
                        <tr><td><label for="iTitle"><?= $this->getHtml('Title'); ?></label>
                        <tr><td><input id="iTitle" name="name" type="text" required>
                        <tr><td><label for="iTitle"><?= $this->getHtml('Description'); ?></label>
                        <tr><td><textarea required></textarea>
                        <tr><td><label for="iFile"><?= $this->getHtml('Files'); ?></label>
                        <tr><td><input id="iFile" name="fileVisual" type="file" multiple><input id="iFileHidden" name="files" type="hidden">
                        <tr><td><input type="submit" value="<?= $this->getHtml('Create', 0, 0); ?>">
                    </table>
                </form>
            </div>
        </section>
    </div>
</div>