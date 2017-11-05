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

$modules   = $this->app->moduleManager->getAllModules();
$active    = $this->app->moduleManager->getActiveModules();
$installed = $this->app->moduleManager->getInstalledModules();

$id = $this->request->getData('id') ?? 1;
?>

<div class="row">
    <div class="col-xs-12 col-md-4">
        <section class="box wf-100">
            <header><h1><?= $this->printHtml($modules[$id]['name']['external'] ); ?></h1></header>

            <div class="inner">
                <table class="list wf-100">
                    <tbody>
                    <tr>
                        <td><?= $this->getHtml('Name'); ?>
                        <td><?= $this->printHtml($modules[$id]['name']['external']); ?>
                    <tr>
                        <td><?= $this->getHtml('Version'); ?>
                        <td><?= $this->printHtml($modules[$id]['version'] ); ?>
                    <tr>
                        <td><?= $this->getHtml('CreatedBy'); ?>
                        <td><?= $this->printHtml($modules[$id]['creator']['name'] ); ?>
                    <tr>
                        <td><?= $this->getHtml('Website'); ?>
                        <td><?= $this->printHtml($modules[$id]['creator']['website'] ); ?>
                    <tr>
                        <td><?= $this->getHtml('Description'); ?>
                        <td><?= $this->printHtml($modules[$id]['description'] ); ?>
                    <tr>
                        <td colspan="2">
                            <?php if (in_array($id, $active)) : ?>
                                <button
                                    data-reload="<?= \phpOMS\Uri\UriFactory::build('POST:/{/lang}/backend/admin/module/status?{?}&status=deactivate&module=' . $id); ?>"><?= $this->getHtml('Deactivate'); ?></button>
                            <?php elseif (in_array($id, $installed)) : ?>
                                <button data-reload="<?= \phpOMS\Uri\UriFactory::build('POST:/{/lang}/backend/admin/module/deactivate?{?}&id=' . $id); ?>"><?= $this->getHtml('Uninstall'); ?></button>
                                <button data-reload="<?= \phpOMS\Uri\UriFactory::build('POST:/{/lang}/backend/admin/module/deactivate?{?}&id=' . $id); ?>"><?= $this->getHtml('Activate'); ?></button>
                            <?php elseif (isset($modules[$id])) : ?>
                                <button data-reload="<?= \phpOMS\Uri\UriFactory::build('PUT:/{/lang}/backend/admin/module/install?{?}&id=' . $id); ?>"><?= $this->getHtml('Install'); ?></button>
                                <button data-reload="<?= \phpOMS\Uri\UriFactory::build('DELETE:/{/lang}/backend/admin/module/delete?{?}&id=' . $id); ?>"><?= $this->getHtml('Delete', 0); ?></button>
                            <?php endif; ?>
                </table>
            </div>
        </section>
    </div>

    <div class="col-xs-12 col-md-4">
        <section class="box wf-100">
            <header><h1><?= $this->getHtml('Settings'); ?></h1></header>

            <div class="inner">

            </div>
        </section>
    </div>

    <div class="col-xs-12 col-md-4">
        <section class="box wf-100">
            <header><h1><?= $this->getHtml('Groups'); ?></h1></header>

            <div class="inner">

            </div>
        </section>
    </div>

    <div class="col-xs-12 col-md-4">
        <section class="box wf-100">
            <header><h1><?= $this->getHtml('Permissions'); ?></h1></header>

            <div class="inner">

            </div>
        </section>
    </div>
</div>
