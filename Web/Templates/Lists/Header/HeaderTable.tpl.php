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
 */ /** @var \Web\Views\Lists\HeaderView $this */ ?>
<thead>
<tr>
    <th colspan="<?= $this->printHtml(count($this->header) - 1); ?>" class="lT">
        <i class="fa fa-filter p f dim"></i>

        <header><h1><?= $this->printHtml($this->title); ?></h1></header>
    </th>
    <th class="rT">
        <i class="fa fa-minus min"></i>
        <i class="fa fa-plus max vh"></i>
    </th>
</tr>
<tr>
    <?php foreach ($this->header as $key => $element): ?>
        <td<?= $this->printHtml((isset($element['full']) ? ' class="full"' : '')); ?>>
            <?php if (isset($element['title'])): ?>
                <span><?= $this->printHtml($element['title']); ?></span>
                <?php if ($element['sortable']): ?>
                    <i class="fa fa-sort vh"></i>
                    <i class="fa fa-caret-up vh"></i>
                    <i class="fa fa-caret-down vh"></i>
                    <i class="fa fa-times vh"></i>
                <?php endif; ?>
            <?php endif; ?>
        </td>
    <?php endforeach; ?>
</tr>
</thead>
