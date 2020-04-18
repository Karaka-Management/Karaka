<?php
/**
 * Orange Management
 *
 * PHP Version 7.4
 *
 * @package   Modules\CMS
 * @copyright Dennis Eichhorn
 * @license   OMS License 1.0
 * @version   1.0.0
 * @link      https://orange-management.org
 */
declare(strict_types=1);

use phpOMS\Uri\UriFactory;

/**
 * @var \phpOMS\Views\View                $this
 * @var \Modules\CMS\Models\Application[] $applications
 */
$applications = $this->getData('applications') ?? [];

$previous = empty($applications) ? '{/prefix}cms/application/list' : '{/prefix}cms/application/list?{?}&id=' . \reset($applications)->getId() . '&ptype=-';
$next     = empty($applications) ? '{/prefix}cms/application/list' : '{/prefix}cms/application/list?{?}&id=' . \end($applications)->getId() . '&ptype=+';

echo $this->getData('nav')->render();
?>
<div class="row">
    <div class="col-xs-12">
        <div class="portlet">
            <div class="portlet-head"><?= $this->getHtml('Applications') ?><i class="fa fa-download floatRight download btn"></i></div>
            <table id="applicationList" class="default">
                <thead>
                <tr>
                    <td>
                    <td class="wf-100"><?= $this->getHtml('Name') ?>
                <tbody>
                <?php $count = 0; foreach ($applications as $key => $application) : ++$count;
                $url = UriFactory::build('{/prefix}cms/application/single?{?}&id=' . $application->getId()); ?>
                    <tr data-href="<?= $url; ?>">
                        <td data-label="<?= $this->getHtml('Name') ?>"><a href="<?= $url; ?>"><?= $this->printHtml($application->getName()); ?></a>
                <?php endforeach; ?>
                <?php if ($count === 0) : ?>
                <tr><td colspan="3" class="empty"><?= $this->getHtml('Empty', '0', '0'); ?>
                <?php endif; ?>
            </table>
            <div class="portlet-foot">
                <a class="button" href="<?= UriFactory::build($previous); ?>"><?= $this->getHtml('Previous', '0', '0'); ?></a>
                <a class="button" href="<?= UriFactory::build($next); ?>"><?= $this->getHtml('Next', '0', '0'); ?></a>
            </div>
        </div>
    </div>
</div>
