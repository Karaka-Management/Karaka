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

$footerView   = new \Web\Views\Lists\PaginationView($this->app, $this->request, $this->response);
$footerView->setTemplate('/Web/Templates/Lists/Footer/PaginationBig');
$footerView->setPages(20);
$footerView->setPage(1);

$items = $this->getData('items');

echo $this->getData('nav')->render(); ?>

<div class="row">
    <div class="col-xs-12">
        <div class="box wf-100">
            <table class="table red">
                <caption><?= $this->getHtml('Items'); ?></caption>
                <thead>
                <tr>
                    <td><?= $this->getHtml('ID', 0, 0); ?>
                    <td class="wf-100"><?= $this->getHtml('Name') ?>
                    <td><?= $this->getHtml('Price') ?>
                    <td><?= $this->getHtml('Available') ?>
                    <td><?= $this->getHtml('Reserved') ?>
                    <td><?= $this->getHtml('Ordered') ?>
                <tfoot>
                <tr>
                    <td colspan="6"><?= $footerView->render(); ?>
                <tbody>
                <?php $count = 0; foreach ($items as $key => $value) : $count++; 
                $url = \phpOMS\Uri\UriFactory::build('{/base}/{/lang}/backend/sales/item/single?{?}&id=' . $value->getId()); ?>
                <tr data-href="<?= $url; ?>">
                    <td><a href="<?= $url; ?>"><?= $this->printHtml($value->getNumber()); ?></a>
                    <td>
                    <td>
                    <td>
                    <td>
                    <td>
                <?php endforeach; ?>
                <?php if ($count === 0) : ?>
                <tr><td colspan="6" class="empty"><?= $this->getHtml('Empty', 0, 0); ?>
                        <?php endif; ?>
            </table>
        </div>
    </div>
</div>
