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

echo $this->getData('nav')->render(); ?>

<div class="row">
    <div class="col-xs-12">
        <div class="box wf-100">
            <table class="table red">
                <caption><?= $this->getHtml('Surveys'); ?></caption>
                <thead>
                <tr>
                    <td><?= $this->getHtml('Status') ?>
                    <td class="wf-100"><?= $this->getHtml('Title') ?>
                    <td><?= $this->getHtml('Created') ?>
                    <td><?= $this->getHtml('Creator') ?>
                <tfoot>
                <tr>
                    <td colspan="4"><?= $footerView->render(); ?>
                <tbody>
                <?php $count = 0; foreach ([] as $key => $value) : $count++; ?>
                <?php endforeach; ?>
                <?php if ($count === 0) : ?>
                <tr><td colspan="4" class="empty"><?= $this->getHtml('Empty', 0, 0); ?>
                        <?php endif; ?>
            </table>
        </div>
    </div>
</div>