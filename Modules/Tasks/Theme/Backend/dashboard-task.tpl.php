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
<div id="task-dashboard" class="col-xs-12 col-md-6" draggable="true">
    <div class="box wf-100">
        <?= $this->getData('tasklist')->render($this->getData('tasks')); ?>
    </div>
</div>