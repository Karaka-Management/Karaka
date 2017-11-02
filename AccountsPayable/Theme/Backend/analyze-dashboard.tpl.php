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

<section class="box w-25 floatLeft">
    <div class="inner centerText">
        <a href="">
            <p><i class="fa fa-5x fa-clock-o"></i></p>
            <p><?= $this->getHtml('Due'); ?></p>
        </a>
    </div>
</section>

<section class="box w-25 floatLeft">
    <div class="inner centerText">
        <a href="">
            <p><i class="fa fa-5x fa-dollar"></i></p>
            <p><?= $this->getHtml('DSO'); ?></p>
        </a>
    </div>
</section>

<section class="box w-25 floatLeft">
    <div class="inner centerText">
        <a href="">
            <p><i class="fa fa-5x fa-calendar"></i></p>
            <p><?= $this->getHtml('AgePattern'); ?></p>
        </a>
    </div>
</section>
