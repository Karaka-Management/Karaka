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

$media      = $this->getData('media');
$footerView = new \Web\Views\Lists\PaginationView($this->app, $this->request, $this->response);
$footerView->setTemplate('/Web/Templates/Lists/Footer/PaginationBig');
$footerView->setPages(count($media) / 25);
$footerView->setPage(1);

echo $this->getData('nav')->render(); ?>

<div class="row">
    <div class="col-xs-12">
        <div class="box wf-100">
            <table class="table red">
                <caption><?= $this->getHtml('Media') ?></caption>
                <thead>
                <tr>
                    <td>
                    <td class="wf-100"><?= $this->getHtml('Name') ?>
                    <td><?= $this->getHtml('Type') ?>
                    <td><?= $this->getHtml('Size') ?>
                    <td><?= $this->getHtml('Creator') ?>
                    <td><?= $this->getHtml('Created') ?>
                        <tfoot>
                <tr>
                    <td colspan="3"><?= $footerView->render(); ?>
                        <tbody>
                        <?php $count = 0; foreach ($media as $key => $value) : $count++;
                        $url = \phpOMS\Uri\UriFactory::build('{/base}/{/lang}/backend/media/single?{?}&id=' . $value->getId()); 

                        $icon = '';
                        $extensionType = \phpOMS\System\File\FileUtils::getExtensionType($value->getExtension());

                        if ($extensionType === \phpOMS\System\File\ExtensionType::CODE) {
                            $icon = 'file-code-o';
                        } elseif ($extensionType === \phpOMS\System\File\ExtensionType::TEXT) {
                            $icon = 'file-text-o';
                        } elseif ($extensionType === \phpOMS\System\File\ExtensionType::PRESENTATION) {
                           $icon = 'file-powerpoint-o';
                        } elseif ($extensionType === \phpOMS\System\File\ExtensionType::PDF) {
                            $icon = 'file-pdf-o';
                        } elseif ($extensionType === \phpOMS\System\File\ExtensionType::ARCHIVE) {
                            $icon = 'file-zip-o';
                        } elseif ($extensionType === \phpOMS\System\File\ExtensionType::AUDIO) {
                            $icon = 'file-audio-o';
                        } elseif ($extensionType === \phpOMS\System\File\ExtensionType::VIDEO) {
                            $icon = 'file-video-o';
                        } elseif ($extensionType === \phpOMS\System\File\ExtensionType::IMAGE) {
                            $icon = 'file-image-o';
                        } elseif ($extensionType === \phpOMS\System\File\ExtensionType::SPREADSHEET) {
                            $icon = 'file-excel-o';
                        } elseif ($value->getExtension() === 'collection') {
                            $icon = 'folder-open-o';
                        } else {
                            $icon = 'file-o';
                        }
                        ?>
                        <tr data-href="<?= $url; ?>">
                            <td data-label="<?= $this->getHtml('Type') ?>"><a href="<?= $url; ?>"><i class="fa fa-<?= $this->printHtml($icon); ?>"></i></a>
                            <td data-label="<?= $this->getHtml('Name') ?>"><a href="<?= $url; ?>"><?= $this->printHtml($value->getName()); ?></a>
                            <td data-label="<?= $this->getHtml('Extension') ?>"><a href="<?= $url; ?>"><?= $this->printHtml($value->getExtension()); ?></a>
                            <td data-label="<?= $this->getHtml('Size') ?>"><a href="<?= $url; ?>"><?= $this->printHtml($value->getSize()); ?></a>
                            <td data-label="<?= $this->getHtml('Creator') ?>"><a href="<?= $url; ?>"><?= $this->printHtml($value->getCreatedBy()->getName1()); ?></a>
                            <td data-label="<?= $this->getHtml('Created') ?>"><a href="<?= $url; ?>"><?= $this->printHtml($value->getCreatedAt()->format('Y-m-d H:i:s')); ?></a>
                        <?php endforeach; ?>
                        <?php if ($count === 0) : ?>
                <tr><td colspan="5" class="empty"><?= $this->getHtml('Empty', 0, 0); ?>
                        <?php endif; ?>
            </table>
        </div>
    </div>
</div>
