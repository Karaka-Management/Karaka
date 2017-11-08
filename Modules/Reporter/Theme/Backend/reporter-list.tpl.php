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
 * @var \phpOMS\Views\View $this
 */


$templates = $this->getData('reports');
$footerView = new \Web\Views\Lists\PaginationView($this->app, $this->request, $this->response);
$footerView->setTemplate('/Web/Templates/Lists/Footer/PaginationBig');

$footerView->setPages(count($templates) / 25);
$footerView->setPage(1);
$footerView->setResults(count($templates));

echo $this->getData('nav')->render(); ?>

<div class="row">
    <div class="col-xs-12">
        <div class="box wf-100">
            <table class="table red">
                <caption><?= $this->getHtml('Reports') ?></caption>
                <thead>
                <tr>
                    <td><?= $this->getHtml('ID', 0, 0); ?>
                    <td class="wf-100"><?= $this->getHtml('Name') ?>
                    <td><?= $this->getHtml('Creator') ?>
                    <td><?= $this->getHtml('Updated') ?>
                <tfoot>
                <tr>
                    <td colspan="4"><?= $footerView->render(); ?>
                <tbody>
                <?php if (count($templates) == 0) : ?>
                <tr class="empty">
                    <td colspan="4"><?= $this->getHtml('Empty', 0, 0); ?>
                        <?php endif; ?>
                        <?php foreach ($templates as $key => $template) :
                        $url = \phpOMS\Uri\UriFactory::build('{/base}/{/lang}/backend/reporter/report/view?{?}&id=' . $template->getId()); ?>
                <tr data-href="<?= $url; ?>">
                    <td data-label="<?= $this->getHtml('ID', 0, 0) ?>"><a href="<?= $url; ?>"><?= $this->printHtml($template->getId()); ?></a>
                    <td data-label="<?= $this->getHtml('Name') ?>"><a href="<?= $url; ?>"><?= $this->printHtml($template->getName()); ?></a>
                    <td data-label="<?= $this->getHtml('Creator') ?>"><a href="<?= $url; ?>"><?= $this->printHtml($template->getCreatedBy()->getName1()); ?></a>
                    <td data-label="<?= $this->getHtml('Updated') ?>"><a href="<?= $url; ?>"><?= $this->printHtml($template->getCreatedAt()->format('Y-m-d')); ?></a>
                        <?php endforeach; ?>
            </table>
        </div>
    </div>
</div>
