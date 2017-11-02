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
 */ /** @var \Web\Views\Lists\ListView $this */ ?>
<table class="tc-1 m-<?= $this->printHtml($this->module); ?> mp-<?= $this->printHtml(($this->module + $this->pageId)); ?>"
       id="i-<?= $this->printHtml(($this->module + $this->id)); ?>">
    <?php foreach ($this->elements as $rKey => $row): ?>
        <tr>
            <th>
                <label><?= $this->printHtml($row[0]); ?></label>
            </th>
            <?php for ($i = 1; $i < count($row); $i++): ?>
                <td><?= $this->printHtml($row[$i]); ?></td>
            <?php endfor; ?>
        </tr>
    <?php endforeach; ?>
</table>
