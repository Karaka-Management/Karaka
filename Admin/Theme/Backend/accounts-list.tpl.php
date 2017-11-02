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

$footerView->setPages($this->getData('list:count') / 25);
$footerView->setPage(1);
$footerView->setResults($this->getData('list:count'));

echo $this->getData('nav')->render();
?>

<div class="row">
    <div class="col-xs-12">
        <div class="box wf-100">
            <table class="table red">
                <caption><?= $this->getHtml('Groups') ?></caption>
                <thead>
                <tr>
                    <td><?= $this->getHtml('ID', 0, 0); ?>
                    <td><?= $this->getHtml('Status') ?>
                    <td class="wf-100"><?= $this->getHtml('Name') ?>
                    <td><?= $this->getHtml('Activity') ?>
                    <td><?= $this->getHtml('Created') ?>
                        <tfoot>
                <tr><td colspan="5"><?= $footerView->render(); ?>
                        <tbody>
                        <?php $c = 0; foreach ($this->getData('list:elements') as $key => $value) : $c++;
                        $url = \phpOMS\Uri\UriFactory::build('{/base}/{/lang}/backend/admin/account/settings?{?}&id=' . $value->getId()); 
                        $color = 'darkred';
                        if ($value->getStatus() === \phpOMS\Account\AccountStatus::ACTIVE) { $color = 'green'; }
                        elseif ($value->getStatus() === \phpOMS\Account\AccountStatus::INACTIVE) { $color = 'darkblue'; }
                        elseif ($value->getStatus() === \phpOMS\Account\AccountStatus::TIMEOUT) { $color = 'purple'; }
                        elseif ($value->getStatus() === phpOMS\Account\AccountStatus::BANNED) { $color = 'red'; } ?>
                <tr data-href="<?= $url; ?>">
                    <td><a href="<?= $url; ?>"><?= $this->printHtml($value->getId()); ?></a>
                    <td><a href="<?= $url; ?>"><span class="tag <?= $color; ?>"><?= $this->getHtml('Status'. $value->getStatus()); ?></span></a>
                    <td><a href="<?= $url; ?>"><?= $this->printHtml($value->getName1()); ?></a>
                    <td><a href="<?= $url; ?>"><?= $this->printHtml($value->getLastActive()->format('Y-m-d H:i:s')); ?></a>
                    <td><a href="<?= $url; ?>"><?= $this->printHtml($value->getCreatedAt()->format('Y-m-d H:i:s')); ?></a>
                        <?php endforeach; ?>
                        <?php if ($c === 0) : ?>
                        <tr><td colspan="5" class="empty"><?= $this->getHtml('Empty', 0, 0); ?>
                                <?php endif; ?>
            </table>
        </div>
    </div>
</div>
