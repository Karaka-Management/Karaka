<?php
/**
 * Orange Management
 *
 * PHP Version 7.4
 *
 * @package   Web\Backend\tpl
 * @copyright Dennis Eichhorn
 * @license   OMS License 1.0
 * @version   1.0.0
 * @link      https://orange-management.org
 */

use phpOMS\Uri\UriFactory;

/** @var \phpOMS\Views\PaginationView $this */
$page     = $this->getPage();
$pages    = $this->getPages();
$maxPages = $this->getMaxPages();
$results  = $this->getResults();

$offset = (int) (($maxPages - 1) / 2);

$leftOffset  = $offset - $page;
$rightOffset = $page + $offset - $pages - 1;

$start = \max($page - ($rightOffset > 0 ? $rightOffset : 0) - $offset, 1);
$end   = \min($page + ($leftOffset > 0 ? $leftOffset : 0) + $offset, $pages);
?>
<ul class="pagination">
    <?php if ($start !== 1) : ?>
        <li><a href="<?= UriFactory::build('{%}&page=1'); ?>"<?= $page === 1 ? ' class="active"' : ''; ?>>1</a>
    <?php endif; ?>
    <?php for ($i = $start; $i <= $end; ++$i) : ?>
        <li><a href="<?= UriFactory::build('{%}&page=' . $i); ?>"<?= $page === $i ? ' class="active"' : ''; ?>><?= $i; ?></a>
    <?php endfor; ?>

    <?php if ($pages !== $i - 1) : ?>
        <li><a href="<?= UriFactory::build('{%}&page=' . $pages); ?>"<?= $page === $pages ? ' class="active"' : ''; ?>><?= $pages; ?></a>
    <?php endif; ?>
</ul>