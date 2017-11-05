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
 */ /** @var \Web\Views\Lists\ListView $this */ ?>
<table class="t t-data m-<?= $this->printHtml($this->module); ?> mp-<?= $this->printHtml(($this->module + $this->pageId)); ?>"
       id="i-<?= $this->printHtml(($this->module + $this->id)); ?>">
    <?php
    /** @var \Web\Views\Lists\HeaderView $header */
    $header = $this->getView('header');
    $footer = $this->getView('footer');
    if ($header !== false) {
        echo $header->render();
    } ?>
    <?php if (isset($this->elements)): ?>
        <tbody>
        <?php foreach ($this->elements as $rKey => $row): ?>
            <tr>
                <?php foreach ($row as $cKey => $column): ?>
                    <td><?= $this->printHtml($column); ?></td>
                <?php endforeach; ?>
            </tr>
        <?php endforeach; ?>
        </tbody>
    <?php endif; ?>
    <?php if ($footer): ?>
        <tfoot>
        <tr>
            <td colspan="<?= $this->printHtml(count($header->getHeaders())); ?>" class="cT">
                <?= $this->printHtml($footer->render()); ?>
            </td>
        </tr>
        </tfoot>
    <?php endif; ?>
</table>
