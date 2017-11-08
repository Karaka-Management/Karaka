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
$risks = $this->getData('risks');
echo $this->getData('nav')->render(); ?>

<div class="row">
    <div class="col-xs-12">
        <div class="box wf-100">
            <table class="table red">
                <caption><?= $this->getHtml('Risks') ?></caption>
                <thead>
                <tr>
                    <td><?= $this->getHtml('ID', 0, 0); ?>
                    <td class="wf-100"><?= $this->getHtml('Title') ?>
                    <td><?= $this->getHtml('Causes') ?>
                    <td><?= $this->getHtml('Solutions') ?>
                    <td><?= $this->getHtml('RiskObjects') ?>
                        <tfoot>
                <tr><td colspan="5">
                        <tbody>
                        <?php $c = 0; foreach ($risks as $key => $value) : $c++;
                        $url = \phpOMS\Uri\UriFactory::build('/{/lang}/backend/riskmanagement/risk/single?{?}&id=' . $value->getId()); ?>
                <tr data-href="<?= $url; ?>">
                    <td><a href="<?= $url; ?>"><?= $this->printHtml($value->getId()); ?></a>
                    <td><a href="<?= $url; ?>"><?= $this->printHtml($value->getName()); ?></a>
                    <td><a href="<?= $url; ?>"><?= $this->printHtml(count($value->getCauses())); ?></a>
                    <td><a href="<?= $url; ?>"><?= $this->printHtml(count($value->getSolutions())); ?></a>
                    <td><a href="<?= $url; ?>"><?= $this->printHtml(count($value->getRiskObjects())); ?></a>
                        <?php endforeach; ?>
                        <?php if ($c === 0) : ?>
                        <tr><td colspan="5" class="empty"><?= $this->getHtml('Empty', 0, 0); ?>
                                <?php endif; ?>
            </table>
        </div>
    </div>
</div>