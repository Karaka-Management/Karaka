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

$footerView  = new \Web\Views\Lists\PaginationView($this->app, $this->request, $this->response);
$footerView->setTemplate('/Web/Templates/Lists/Footer/PaginationBig');
$footerView->setPages(20);
$footerView->setPage(1);

$accounts = $this->getData('accounts');
?>

<div class="row">
    <div class="col-xs-12">
        <div class="box wf-100">
            <table class="table red">
                <caption><?= $this->getHtml('Profiles') ?></caption>
                <thead>
                <tr>
                    <td><?= $this->getHtml('ID', 0, 0); ?>
                    <td class="wf-100"><?= $this->getHtml('Name') ?>
                    <td><?= $this->getHtml('Activity') ?>
                <tfoot>
                <tr>
                    <td colspan="3"><?= $footerView->render(); ?>
                <tbody>
                <?php $count = 0; foreach ($accounts as $key => $account) : $count++;
                $url = \phpOMS\Uri\UriFactory::build('{/base}/{/lang}/backend/profile/single?{?}&id=' . $account->getAccount()->getId()); ?>
                    <tr data-href="<?= $url; ?>">
                        <td><a href="<?= $url; ?>"><?= $this->printHtml($account->getAccount()->getId()); ?></a>
                        <td><a href="<?= $url; ?>"><?= $this->printHtml($account->getAccount()->getName3() . ' ' . $account->getAccount()->getName2() . ' ' . $account->getAccount()->getName1()); ?></a>
                        <td><a href="<?= $url; ?>"><?= $this->printHtml($account->getAccount()->getLastActive()->format('Y-m-d')); ?></a>
                <?php endforeach; ?>
                <?php if ($count === 0) : ?>
                <tr><td colspan="3" class="empty"><?= $this->getHtml('Empty', 0, 0); ?>
                <?php endif; ?>
            </table>
        </div>
    </div>
</div>
