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
/**
 * @var $media \Modules\Media\Models\Media
 */
$media = $this->getData('media');
echo $this->getData('nav')->render();
?>

<div class="row">
    <div class="col-xs-12">
        <section class="box wf-100">
            <header><h1><?= $this->printHtml($media->getName()); ?></h1></header>
            <div class="inner">
                <table class="list w-100">
                    <tbody>
                        <tr><td>Name<td class="wf-100"><?= $this->printHtml($media->getName()); ?>
                        <tr><td>Size<td class="wf-100"><?= $this->printHtml($media->getSize()); ?>
                        <tr><td>Created at<td><?= $this->printHtml($media->getCreatedAt()->format('Y-m-d')); ?>
                        <tr><td>Created by<td><?= $this->printHtml($media->getCreatedBy()->getName1()); ?>
                        <tr><td>Description<td><?= $this->printHtml($media->getDescription()); ?>
                </table>
            </div>
        </section>
    </div>
</div>

<div class="row">
    <?php if (
        (
            $media->getExtension() === 'collection'
            && !is_file($media->getPath() . $this->request->getData('sub'))
        ) || (
            is_dir($media->getPath()) 
            && ($this->request->getData('sub') === null || is_dir($media->getPath() . $this->request->getData('sub')))
        )
    ) : ?>
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
                <tbody>
                    <?php if (!is_dir($media->getPath())) : foreach ($media as $key => $value) :
                        $url = \phpOMS\Uri\UriFactory::build('/{/lang}/backend/media/single?{?}&id=' . $value->getId()); 

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
                            <td><a href="<?= $url; ?>"><i class="fa fa-<?= $this->printHtml($icon); ?>"></i></a>
                            <td><a href="<?= $url; ?>"><?= $this->printHtml($value->getName()); ?></a>
                            <td><a href="<?= $url; ?>"><?= $this->printHtml($value->getExtension()); ?></a>
                            <td><a href="<?= $url; ?>"><?= $this->printHtml($value->getSize()); ?></a>
                            <td><a href="<?= $url; ?>"><?= $this->printHtml($value->getCreatedBy()->getName1()); ?></a>
                            <td><a href="<?= $url; ?>"><?= $this->printHtml($value->getCreatedAt()->format('Y-m-d H:i:s')); ?></a>
                    <?php endforeach; else : $path = is_dir($media->getPath() . $this->request->getData('sub')) && phpOMS\Utils\StringUtils::startsWith(str_replace('\\', '/', realpath($media->getPath() . $this->request->getData('sub'))), $media->getPath()) ? $media->getPath() . $this->request->getData('sub') : $media->getPath(); ?>
                        <?php $list = \phpOMS\System\File\Local\Directory::list($path); 
                            foreach ($list as $key => $value) : 
                                $url = \phpOMS\Uri\UriFactory::build('/{/lang}/backend/media/single?{?}&id=' . $media->getId() . '&sub=' . substr($value, strlen($media->getPath()))); 
                                $icon = '';
                                $extensionType = \phpOMS\System\File\FileUtils::getExtensionType(!is_dir($value) ? \phpOMS\System\File\Local\File::extension($value) : 'collection');
        
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
                                } elseif ($extensionType === 'collection') {
                                    $icon = 'folder-open-o';
                                } else {
                                    $icon = 'file-o';
                                }
                        ?>
                        <tr data-href="<?= $url; ?>">
                            <td><a href="<?= $url; ?>"><i class="fa fa-<?= $this->printHtml($icon); ?>"></i></a>
                            <td><a href="<?= $url; ?>"><?= substr($value, strlen($media->getPath())); ?></a>
                            <td><a href="<?= $url; ?>"><?= !is_dir($value) ? \phpOMS\System\File\Local\File::extension($value) : 'collection'; ?></a>
                            <td><a href="<?= $url; ?>"><?= !is_dir($value) ? \phpOMS\System\File\Local\File::size($value) : ''; ?></a>
                            <td><a href="<?= $url; ?>"><?= \phpOMS\System\File\Local\File::owner($value); ?></a>
                            <td><a href="<?= $url; ?>"><?= \phpOMS\System\File\Local\File::created($value)->format('Y-m-d'); ?></a>
                    <?php endforeach; endif; ?>
            </table>
        </div>
    </div>
    <?php else: ?>
    <div class="col-xs-12">
        <section class="box wf-100">
            <div class="inner">
                <?php 
                $path = is_file($media->getPath() . $this->request->getData('sub')) && phpOMS\Utils\StringUtils::startsWith(str_replace('\\', '/', realpath($media->getPath() . $this->request->getData('sub'))), $media->getPath()) ? $media->getPath() . $this->request->getData('sub') : $media->getPath();
                if (\phpOMS\System\File\FileUtils::getExtensionType($media->getExtension()) === \phpOMS\System\File\ExtensionType::IMAGE || \phpOMS\System\File\FileUtils::getExtensionType(\phpOMS\System\File\Local\File::extension($path)) === \phpOMS\System\File\ExtensionType::IMAGE) : ?>
                    <div class="h-overflow"><img src="<?= $media->isAbsolute() ? $this->printHtml($path) : $this->printHtml($this->request->getUri()->getBase() . $path); ?>"></div>
                <?php else : ?>
                    <pre>
                    <?php
                    $output = file_get_contents($media->isAbsolute() ? $path : __DIR__ . '/../../../../' . $path);
                    $output = str_replace(["\r\n", "\r"], "\n", $output);
                    $output = explode("\n", $output);
                    foreach ($output as $line) : ?><span><?= $this->printHtml($line); ?></span><?php endforeach; ?>
                    </pre>
                <?php endif; ?>
            </div>
        </section>
    </div>
    <?php endif; ?>
</div>