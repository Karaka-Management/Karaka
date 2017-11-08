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

$footerView = new \Web\Views\Lists\PaginationView($this->app, $this->request, $this->response);
$footerView->setTemplate('/Web/Templates/Lists/Footer/PaginationBig');

$modules   = $this->app->moduleManager->getAllModules();
$active    = $this->app->moduleManager->getActiveModules();
$installed = $this->app->moduleManager->getInstalledModules();

$footerView->setPages(count($modules) / 25);
$footerView->setPage(1);
$footerView->setResults(count($modules));
?>

<div class="row">
    <div class="col-xs-12">
        <div class="box wf-100">
            <table class="table red">
                <caption><?= $this->getHtml('Modules') ?></caption>
                <thead>
                <tr>
                    <td><?= $this->getHtml('ID', 0, 0); ?>
                    <td class="wf-100"><?= $this->getHtml('Name') ?>
                    <td><?= $this->getHtml('Version') ?>
                    <td><?= $this->getHtml('Status') ?>
                        <tfoot>
                <tr>
                    <td colspan="4"><?= $footerView->render(); ?>
                        <tbody>
                        <?php $count = 0; foreach ($modules as $key => $module) : $count++;
                        $url = \phpOMS\Uri\UriFactory::build('{/base}/{/lang}/backend/admin/module/settings?{?}&id=' . $module['name']['internal']); ?>
                <tr data-href="<?= $url; ?>">
                    <td data-label="<?= $this->getHtml('ID', 0, 0) ?>"><a href="<?= $url; ?>"><?= $this->printHtml($module['name']['id']); ?></a>
                    <td data-label="<?= $this->getHtml('Name') ?>"><a href="<?= $url; ?>"><?= $this->printHtml($module['name']['external']); ?></a>
                    <td data-label="<?= $this->getHtml('Version') ?>"><a href="<?= $url; ?>"><?= $this->printHtml($module['version']); ?></a>
                    <td data-label="<?= $this->getHtml('Status') ?>"><a href="<?= $url; ?>"><?php if (in_array($module['name']['internal'], $active))
                            echo strtolower($this->getHtml('Active'));
                        elseif (in_array($module['name']['internal'], $installed))
                            echo strtolower($this->getHtml('Inactive'));
                        else
                            echo strtolower($this->getHtml('Available')); ?></a>
                        <?php endforeach; ?>
                <?php if ($count === 0) : ?>
                    <tr><td colspan="4" class="empty"><?= $this->getHtml('Empty', 0, 0); ?>
                <?php endif; ?>
            </table>
        </div>
    </div>
</div>
