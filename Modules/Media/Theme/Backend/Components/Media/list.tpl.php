<div class="box wf-100">
    <table class="table blue">
        <caption><?= $this->getHtml('Media', 'Media') ?></caption>
        <thead>
            <td>
            <td class="wf-100"><?= $this->getHtml('Name', 'Media') ?>
            <td><?= $this->getHtml('Type', 'Media') ?>
            <td><?= $this->getHtml('Size', 'Media') ?>
            <td><?= $this->getHtml('Creator', 'Media') ?>
            <td><?= $this->getHtml('Created', 'Media') ?>
        <tfoot>
        <tbody>
            <?php $count = 0; foreach ($this->media as $key => $value) : $count++;
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
        <tr><td colspan="6" class="empty"><?= $this->getHtml('Empty', 0, 0); ?>
        <?php endif; ?>
    </table>
</div>