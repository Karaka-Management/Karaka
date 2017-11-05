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
 * @var \Web\Views\Form\FormView $this
 */
?>
<form action="<?= $this->printHtml($this->action); ?>" 
    method="<?= $this->printHtml($this->method); ?>" 
    id="<?= $this->printHtml($this->formId); ?>" 
    class="<?= $this->printHtml($this->class); ?>"
    <?= $this->printHtml(isset($this->formFields) ? ' data-formfields=\'' . json_encode($this->formFields) . '\'' : ''); ?>>
    <?php include 'FormInner.tpl.php'; ?>
</form>
