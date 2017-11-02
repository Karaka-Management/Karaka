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
echo $this->getData('nav')->render();
?>

<div class="box w-100">
    <table class="table red">
        <caption><?= $this->getHtml('Times') ?></caption>
        <thead>
        <tr>
            <td><?= $this->getHtml('Start') ?>
            <td><?= $this->getHtml('End') ?>
            <td class="wf-100"><?= $this->getHtml('Type') ?>
        <tfoot>
        <tr><td colspan="4"><?= $footerView->render(); ?>
        <tbody>
        <?php $c = 0; foreach ($employees as $key => $value) : $c++;
            $url = \phpOMS\Uri\UriFactory::build('{/base}/{/lang}/backend/admin/group/settings?{?}&id=' . $value->getId()); ?>
            <tr>
                <td><a href="<?= $url; ?>"><?= $this->printHtml($value->getId()); ?></a>
                <td><a href="<?= $url; ?>"><?= $this->printHtml($value->getNewestHistory()->getPosition()); ?></a>
                <td><a href="<?= $url; ?>"><?= $this->printHtml($value->getNewestHistory()->getPosition()); ?></a>
        <?php endforeach; ?>
        <?php if ($c === 0) : ?>
            <tr><td colspan="4" class="empty"><?= $this->getHtml('Empty', 0, 0); ?>
        <?php endif; ?>
    </table>
</div>
