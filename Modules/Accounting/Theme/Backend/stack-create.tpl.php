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

<section class="box w-50">
    <header><h1><?= $this->getHtml('Stack') ?></h1></header>
    <div class="inner">
        <form>
            <table class="layout wf-100">
                <tr><td><label for="iName"><?= $this->getHtml('Name') ?></label>
                <tr><td><input id="iName" name="name" type="text">
                <tr><td><label for="iType"><?= $this->getHtml('Type') ?></label>
                <tr><td><select id="iType" name="type">
                            <option value=""><?= $this->getHtml('TAccount') ?>
                            <option value=""><?= $this->getHtml('Incoming') ?>
                            <option value=""><?= $this->getHtml('Outgoing') ?>
                        </select>
                <tr><td><input name="submit" type="submit" value="<?= $this->getHtml('Create', 0, 0); ?>">
            </table>
        </form>
    </div>
</section>
