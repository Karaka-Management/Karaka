<?php
/**
 * Orange Management
 *
 * PHP Version 7.4
 *
 * @package   Modules\Messages
 * @copyright Dennis Eichhorn
 * @license   OMS License 1.0
 * @version   1.0.0
 * @link      https://orange-management.org
 */
declare(strict_types=1);

echo $this->getData('nav')->render(); ?>

<section class="box w-100">
    <div class="inner">
        <form>
            <table class="layout wf-100">
                <tr><td style="width: 1%"><button class="simple"><i class="fa fa-book"></i></button><td><input type="text" placeholder="&#xf007; <?= $this->getHtml('To') ?>" name="to">
                <tr><td style="width: 1%"><button class="simple"><i class="fa fa-book"></i></button><td><input type="text" placeholder="&#xf007; <?= $this->getHtml('CC') ?>" name="cc">
                <tr><td style="width: 1%"><button class="simple"><i class="fa fa-book"></i></button><td><input type="text" placeholder="&#xf007; <?= $this->getHtml('BCC') ?>" name="bcc">
                <tr><td><td><input type="text" placeholder="&#xf040; <?= $this->getHtml('Subject') ?>" name="subject">
                <tr><td><td><input type="file" name="files" multiple>
                <tr><td><td><div class="textarea" contenteditable="true" style="height: 400px;"></div><textarea placeholder="&#xf040;" style="display: none" name="mail"></textarea>
                <tr><td><td><input type="submit" value="<?= $this->getHtml('Send', '0', '0') ?>"> <input type="submit" value="<?= $this->getHtml('Save', '0', '0') ?>">
            </table>
        </form>
    </div>
</section>
