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
/*
 * UI Logic
 */

$group = $this->getData('group');
$permissions = $this->getData('permissions');
$accounts = $this->getData('accounts');

echo $this->getData('nav')->render(); ?>

<div class="row">
    <div class="col-xs-12 col-md-4">
        <section class="box wf-100">
            <header><h1><?= $this->getHtml('Group'); ?></h1></header>
            <div class="inner">
                <form action="<?= \phpOMS\Uri\UriFactory::build('/{/lang}/api/admin/group'); ?>" method="post">
                    <table class="layout wf-100">
                        <tbody>
                        <tr><td><label for="iGid"><?= $this->getHtml('ID', 0, 0); ?></label>
                        <tr><td><input id="iGid" name="gid" type="text" value="<?= $this->printHtml($group->getId()); ?>" disabled>
                        <tr><td><label for="iGname"><?= $this->getHtml('Name'); ?></label>
                        <tr><td><input id="iGname" name="gname" type="text" placeholder="&#xf0c0; Guest" value="<?= $this->printHtml($group->getName()); ?>">
                        <tr><td><label for="iGstatus"><?= $this->getHtml('Status'); ?></label>
                        <tr><td><select id="iGstatus" status="gname">
                            <?php $status = \phpOMS\Account\GroupStatus::getConstants(); foreach ($status as $stat) : ?>
                            <option value="<?= $stat; ?>"<?= $stat === $group->getStatus() ? ' selected' : ''; ?>><?= $this->getHtml('GroupStatus' . $stat); ?>
                        <?php endforeach; ?>
                            </select>
                        <tr><td><label for="iGroupDescription"><?= $this->getHtml('Description'); ?></label>
                        <tr><td><textarea id="iGroupDescription" name="description" placeholder="&#xf040;"><?= $this->printHtml($group->getDescription()); ?></textarea>
                        <tr><td><input type="submit" value="<?= $this->getHtml('Save', 0, 0); ?>">
                    </table>
                </form>
            </div>
        </section>
    </div>

    <div class="col-xs-12 col-md-4">
        <table class="box table red">
            <caption><?= $this->getHtml('Parents') ?></caption>
            <thead>
                <tr>
                    <td><?= $this->getHtml('ID', 0, 0); ?>
                    <td>Name
            <tbody>
                <?php $c = 0; foreach ([] as $key => $value) : $c++; ?>
                <tr>
                    <td>
                    <td>
                <?php endforeach; ?>
                <?php if ($c === 0) : ?>
                <tr><td colspan="2" class="empty"><?= $this->getHtml('Empty', 0, 0); ?>
                <?php endif; ?>
        </table>

        <section class="box wf-100">
            <header><h1><?= $this->getHtml('Parent'); ?></h1></header>
            <div class="inner">
                <form action="<?= \phpOMS\Uri\UriFactory::build('/{/lang}/api/admin/group'); ?>" method="post">
                    <table class="layout wf-100">
                        <tbody>
                        <tr><td><label for="iGParentName"><?= $this->getHtml('Name'); ?></label>
                        <tr><td><input id="iGParentName" name="parentname" type="text" placeholder="&#xf0c0; Guest">
                        <tr><td><input type="submit" value="<?= $this->getHtml('Add', 0, 0); ?>">
                    </table>
                </form>
            </div>
        </section>
    </div>

    <div class="col-xs-12 col-md-4">
        <table class="box table red">
            <caption><?= $this->getHtml('Permissions') ?></caption>
            <thead>
                <tr>
                    <td><?= $this->getHtml('ID', 0, 0); ?>
                    <td>Unit
                    <td>App
                    <td>Module
                    <td>Type
                    <td>Ele.
                    <td>Comp.
                    <td>Perm.
            <tbody>
                <?php $c = 0; foreach ($permissions as $key => $value) : $c++; $permission = $value->getPermission(); ?>
                <tr>
                    <td><?= $value->getId(); ?>
                    <td><?= $value->getUnit(); ?>
                    <td><?= $value->getApp(); ?>
                    <td><?= $value->getModule(); ?>
                    <td><?= $value->getType(); ?>
                    <td><?= $value->getElement(); ?>
                    <td><?= $value->getComponent(); ?>
                    <td>
                        <?= (\phpOMS\Account\PermissionType::CREATE | $permission) === $permission ? 'C' : ''; ?>
                        <?= (\phpOMS\Account\PermissionType::READ | $permission) === $permission ? 'R' : ''; ?>
                        <?= (\phpOMS\Account\PermissionType::MODIFY | $permission) === $permission ? 'U' : ''; ?>
                        <?= (\phpOMS\Account\PermissionType::DELETE | $permission) === $permission ? 'D' : ''; ?>
                        <?= (\phpOMS\Account\PermissionType::PERMISSION | $permission) === $permission ? 'P' : ''; ?>
                <?php endforeach; ?>
                <?php if ($c === 0) : ?>
                <tr><td colspan="8" class="empty"><?= $this->getHtml('Empty', 0, 0); ?>
                <?php endif; ?>
        </table>

        <section class="box wf-100">
            <header><h1><?= $this->getHtml('Permissions'); ?></h1></header>
            <div class="inner">
                <form action="<?= \phpOMS\Uri\UriFactory::build('/{/lang}/api/admin/group'); ?>" method="post">
                    <table class="layout wf-100">
                        <tbody>
                        <tr><td><label for="iPermissionName"><?= $this->getHtml('Name'); ?></label>
                        <tr><td><input id="iPermissionName" name="permissionname" type="text" placeholder="&#xf084; Admin">
                        <tr><td><input type="submit" value="<?= $this->getHtml('Add', 0, 0); ?>">
                    </table>
                </form>
            </div>
        </section>
    </div>

    <div class="col-xs-12 col-md-4">
        <section class="box wf-100">
            <header><h1><?= $this->getHtml('Accounts'); ?></h1></header>
            <div class="inner">
                <form action="<?= \phpOMS\Uri\UriFactory::build('/{/lang}/api/admin/group'); ?>" method="post">
                    <table class="layout wf-100">
                        <tbody>
                        <tr><td><label for="iGParentName"><?= $this->getHtml('Name'); ?></label>
                        <tr><td><input id="iGParentName" name="parentname" type="text" placeholder="&#xf234; Donald Duck">
                        <tr><td><input type="submit" value="<?= $this->getHtml('Add', 0, 0); ?>">
                    </table>
                </form>
            </div>
        </section>
    </div>
</div>