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

$footerView = new \Web\Views\Lists\PaginationView($this->app, $this->request, $this->response);
$footerView->setTemplate('/Web/Templates/Lists/Footer/PaginationBig');

$footerView->setPages(1 / 25);
$footerView->setPage(1);
$footerView->setResults(1);

echo $this->getData('nav')->render(); ?>

<div class="row">
    <div class="col-xs-12">
        <div class="box wf-100">
            <table class="table red">
                <caption><?= $this->getHtml('AccountsReceivable'); ?></caption>
                <thead>
                <tr>
                    <td><?= $this->getHtml('ID', 0, 0); ?>
                    <td><?= $this->getHtml('Name1') ?>
                    <td><?= $this->getHtml('Name2') ?>
                    <td class="wf-100"><?= $this->getHtml('Name3') ?>
                    <td><?= $this->getHtml('City') ?>
                    <td><?= $this->getHtml('Zip') ?>
                    <td><?= $this->getHtml('Address') ?>
                    <td><?= $this->getHtml('Country') ?>
                <tfoot>
                <tr>
                    <td colspan="8"><?= $footerView->render(); ?>
                <tbody>
                <?php $count = 0; foreach ([] as $key => $value) : $count++; ?>
                <?php endforeach; ?>
                <?php if ($count === 0) : ?>
                <tr><td colspan="8" class="empty"><?= $this->getHtml('Empty', 0, 0); ?>
                        <?php endif; ?>
            </table>
        </div>
    </div>
</div>
