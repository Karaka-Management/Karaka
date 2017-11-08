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

$footerView   = new \Web\Views\Lists\PaginationView($this->app, $this->request, $this->response);
$footerView->setTemplate('/Web/Templates/Lists/Footer/PaginationBig');
$footerView->setPages(20);
$footerView->setPage(1);

$list = $this->getData('projects');

echo $this->getData('nav')->render(); ?>

<div class="row">
    <div class="col-xs-12">
        <div class="box wf-100">
            <table class="table red">
                <caption><?= $this->getHtml('Projects'); ?></caption>
                <thead>
                <tr>
                    <td class="wf-100"><?= $this->getHtml('Title') ?>
                    <td><?= $this->getHtml('Start') ?>
                    <td><?= $this->getHtml('Due') ?>
                <tfoot>
                <tr>
                    <td colspan="5"><?= $footerView->render(); ?>
                <tbody>
                <?php $count = 0; foreach ($list as $key => $value) : $count++; 
                $url = \phpOMS\Uri\UriFactory::build('/{/lang}/backend/projectmanagement/profile?{?}&id=' . $value->getId());?>
                <tr data-href="<?= $url; ?>">
                    <td data-label="<?= $this->getHtml('Title') ?>"><a href="<?= $url; ?>"><?= $this->printHtml($value->getName()); ?></a>
                    <td data-label="<?= $this->getHtml('Start') ?>"><a href="<?= $url; ?>"><?= $this->printHtml($value->getStart()->format('Y-m-d')); ?></a>
                    <td data-label="<?= $this->getHtml('Due') ?>"><a href="<?= $url; ?>"><?= $this->printHtml($value->getEnd()->format('Y-m-d')); ?></a>
                <?php endforeach; ?>
                <?php if ($count === 0) : ?>
                <tr><td colspan="5" class="empty"><?= $this->getHtml('Empty', 0, 0); ?>
                        <?php endif; ?>
            </table>
        </div>
    </div>
</div>
