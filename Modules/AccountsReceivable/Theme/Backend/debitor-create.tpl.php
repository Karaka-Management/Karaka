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

<section class="box w-33 floatLeft">
    <header><h1><?= $this->getHtml('AccountsReceivable'); ?></h1></header>
    <div class="inner">
        <form>
            <table class="layout w-100">
                <tr><td><label for="iStatus"><?= $this->getHtml('Status'); ?></label>
                <tr><td><select id="iStatus" name="status">
                            <option>
                        </select>
                <tr><td><label for="iStatus"><?= $this->getHtml('DeliveryStatus'); ?></label>
                <tr><td><select id="iStatus" name="status">
                            <option>
                        </select>
                <tr><td><label for="iId"><?= $this->getHtml('ID', 0, 0); ?></label>
                <tr><td><span class="input"><button type="button" formaction=""><i class="fa fa-book"></i></button><input type="number" id="iId" min="1" name="id" required></span>
                <tr><td><label for="iName1"><?= $this->getHtml('Name1') ?></label>
                <tr><td><input type="text" id="iName1" name="name1" placeholder="&#xf040;" required>
                <tr><td><label for="iName2"><?= $this->getHtml('Name2') ?></label>
                <tr><td><input type="text" id="iName2" name="name2" placeholder="&#xf040;">
                <tr><td><label for="iName3"><?= $this->getHtml('Name3') ?></label>
                <tr><td><input type="text" id="iName3" name="name3" placeholder="&#xf040;">
                <tr><td colspan="2"><input type="submit" value="<?= $this->getHtml('Create', 0, 0); ?>">
            </table>
        </form>
    </div>
</section>
