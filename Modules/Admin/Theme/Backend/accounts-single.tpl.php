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

$account = $this->getData('account');
$permissions = $this->getData('permissions');

echo $this->getData('nav')->render(); ?>

<div class="row">
    <div class="col-xs-12 col-md-4">
        <section class="box wf-100">
            <header><h1><?= $this->getHtml('Account'); ?></h1></header>
            <div class="inner">
                <form action="<?= \phpOMS\Uri\UriFactory::build('/{/lang}/api/admin/account'); ?>" method="post">
                    <table class="layout wf-100">
                        <tbody>
                        <tr><td><label for="iId"><?= $this->getHtml('ID', 0, 0); ?></label>
                        <tr><td><input id="iId" name="id" type="text" value="<?= $this->printHtml($account->getId()); ?>" disabled>
                        <tr><td><label for="iType"><?= $this->getHtml('Type'); ?></label>
                        <tr><td><select id="iType" name="type">
                                    <option value="<?= $this->printHtml(\phpOMS\Account\AccountType::USER); ?>"<?= $this->printHtml($account->getType() === \phpOMS\Account\AccountType::USER ? ' selected' : ''); ?>><?= $this->getHtml('Person'); ?>
                                    <option value="<?= $this->printHtml(\phpOMS\Account\AccountType::GROUP); ?>"<?= $this->printHtml($account->getType() === \phpOMS\Account\AccountType::GROUP ? ' selected' : ''); ?>><?= $this->getHtml('Organization'); ?>
                                </select>
                        <tr><td><label for="iStatus"><?= $this->getHtml('Status'); ?></label>
                        <tr><td><select id="iStatus" name="status">
                                    <option value="<?= $this->printHtml(\phpOMS\Account\AccountStatus::ACTIVE); ?>"<?= $this->printHtml($account->getStatus() === \phpOMS\Account\AccountStatus::ACTIVE ? ' selected' : ''); ?>><?= $this->getHtml('Active'); ?>
                                    <option value="<?= $this->printHtml(\phpOMS\Account\AccountStatus::INACTIVE); ?>"<?= $this->printHtml($account->getStatus() === \phpOMS\Account\AccountStatus::INACTIVE ? ' selected' : ''); ?>><?= $this->getHtml('Inactive'); ?>
                                    <option value="<?= $this->printHtml(\phpOMS\Account\AccountStatus::TIMEOUT); ?>"<?= $this->printHtml($account->getStatus() === \phpOMS\Account\AccountStatus::TIMEOUT ? ' selected' : ''); ?>><?= $this->getHtml('Timeout'); ?>
                                    <option value="<?= $this->printHtml(\phpOMS\Account\AccountStatus::BANNED); ?>"<?= $this->printHtml($account->getStatus() === \phpOMS\Account\AccountStatus::BANNED ? ' selected' : ''); ?>><?= $this->getHtml('Banned'); ?>
                                </select>
                        <tr><td><label for="iUsername"><?= $this->getHtml('Username'); ?></label>
                        <tr><td><input id="iUsername" name="name" type="text" placeholder="&#xf007; Fred" value="<?= $this->printHtml($account->getName()); ?>" disabled>
                        <tr><td><label for="iName1"><?= $this->getHtml('Name1'); ?></label>
                        <tr><td><input id="iName1" name="name1" type="text" placeholder="&#xf007; Donald" value="<?= $this->printHtml($account->getName1()); ?>" required>
                        <tr><td><label for="iName2"><?= $this->getHtml('Name2'); ?></label>
                        <tr><td><input id="iName2" name="name2" type="text" placeholder="&#xf007; Fauntleroy" value="<?= $this->printHtml($account->getName2()); ?>">
                        <tr><td><label for="iName3"><?= $this->getHtml('Name3'); ?></label>
                        <tr><td><input id="iName3" name="name3" type="text" placeholder="&#xf007; Duck" value="<?= $this->printHtml($account->getName3()); ?>">
                        <tr><td><label for="iEmail"><?= $this->getHtml('Email'); ?></label>
                        <tr><td><input id="iEmail" name="email" type="email" placeholder="&#xf0e0; d.duck@duckburg.com" value="<?= $this->printHtml($account->getEmail()); ?>">
                        <tr><td><label for="iPassword"><?= $this->getHtml('Name3'); ?></label>
                        <tr><td><input id="iPassword" name="password" type="text" placeholder="&#xf023; Pa55ssw0rd?">
                        <tr><td><input type="submit" value="<?= $this->getHtml('Save', 0, 0); ?>">
                    </table>
                </form>
            </div>
        </section>
    </div>

    <div class="col-xs-12 col-md-4">
        <table class="box table red">
            <caption><?= $this->getHtml('Groups') ?></caption>
            <thead>
                <tr>
                    <td><?= $this->getHtml('ID', 0, 0); ?>
                    <td class="wf-100"><?= $this->getHtml('Name') ?>
            <tbody>
                <?php $c = 0; $groups = $account->getGroups(); foreach ($groups as $key => $value) : $c++; 
                $url = \phpOMS\Uri\UriFactory::build('/{/lang}/backend/admin/group/settings?{?}&id=' . $value->getId()); ?>
                <tr data-href="<?= $url; ?>">
                    <td><a href="<?= $url; ?>"><?= $this->printHtml($value->getId()); ?></a>
                    <td><a href="<?= $url; ?>"><?= $this->printHtml($value->getName()); ?></a>
                <?php endforeach; ?>
                <?php if ($c === 0) : ?>
                <tr><td colspan="2" class="empty"><?= $this->getHtml('Empty', 0, 0); ?>
                <?php endif; ?>
        </table>

        <section class="box wf-100">
            <header><h1><?= $this->getHtml('Groups'); ?></h1></header>
            <div class="inner">
                <form action="<?= \phpOMS\Uri\UriFactory::build('/{/lang}/api/admin/group'); ?>" method="post">
                    <table class="layout wf-100">
                        <tbody>
                        <tr><td><label for="iGroup"><?= $this->getHtml('Name'); ?></label>
                        <tr><td><input id="iGroup" name="group" type="text" placeholder="&#xf0c0; Guest">
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
                        <tr><td><label for="iGroup"><?= $this->getHtml('Name'); ?></label>
                        <tr><td><input id="iGroup" name="group" type="text" placeholder="&#xf084; news_create">
                        <tr><td><input type="submit" value="<?= $this->getHtml('Add', 0, 0); ?>">
                    </table>
                </form>
            </div>
        </section>
    </div>
</div>