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
?>
<div id="calendar-dashboard" class="ol-xs-12 col-md-6" draggable="true">
    <?= $this->getData('calendar')->render($this->getData('cal')); ?>
</div>
