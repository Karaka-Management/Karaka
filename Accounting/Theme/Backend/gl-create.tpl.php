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

<section class="box w-50">
    <header><h1><?= $this->getHtml('GL') ?></h1></header>
    <div class="inner">
        <form>
            <table class="layout wf-100">
                <tr><td><label for="iId"><?= $this->getHtml('ID', 0, 0); ?></label>
                <tr><td><input type="text" id="iId" name="id">
                <tr><td><label for="iName"><?= $this->getHtml('Name') ?></label>
                <tr><td><input type="text" id="iName" name="name">
                <tr><td><label for="iParent"><?= $this->getHtml('Parent') ?></label>
                <tr><td><input type="text" id="iParent" name="parent">
                <tr><td><input type="submit" value="<?= $this->getHtml('Create', 0, 0); ?>">
            </table>
        </form>
    </div>
</section>
