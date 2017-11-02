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

$categories = $this->getData('categories');

/**
 * @var \phpOMS\Views\View $this
 */
echo $this->getData('nav')->render();
?>

<div class="row">
    <div class="col-xs-12">
        <div class="box wf-100">
            <table class="table red">
                <caption><?= $this->getHtml('Categories') ?></caption>
                <thead>
                <tr>
                    <td><?= $this->getHtml('ID', 0, 0); ?>
                    <td class="wf-100"><?= $this->getHtml('Name') ?>
                        <tfoot>
                <tr><td colspan="2">
                        <tbody>
                        <?php $c = 0; foreach ($categories as $key => $value) : $c++;
                        $url = \phpOMS\Uri\UriFactory::build('{/base}/{/lang}/backend/admin/account/settings?{?}&id=' . $value->getId()); ?>
                <tr data-href="<?= $url; ?>">
                    <td><a href="<?= $url; ?>"><?= $this->printHtml($value->getId()); ?></a>
                    <td><a href="<?= $url; ?>"><?= $this->printHtml($value->getName()); ?></a>
                        <?php endforeach; ?>
                        <?php if ($c === 0) : ?>
                        <tr><td colspan="2" class="empty"><?= $this->getHtml('Empty', 0, 0); ?>
                                <?php endif; ?>
            </table>
        </div>
    </div>
</div>