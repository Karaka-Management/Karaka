<?php

use phpOMS\Uri\UriFactory;
?>
<span class="clickPopup floatRight">
    <label for="<?= $this->id; ?>-export"><i class="fa lni lni-download download btn"></i></label>
    <input id="<?= $this->id; ?>-export" name="<?= $this->id; ?>-export" type="checkbox">
    <div class="portlet popup">
            <div class="portlet-head"><?= $this->getHtml('Export', '0', '0'); ?></div>
            <table class="default">
                <thead>
                    <tr>
                        <td><?= $this->getHtml('Name', '0', '0'); ?>
                <tbody>
                    <?php foreach ($this->exportTemplates as $template) : ?>
                    <tr data-href="<?= $url = UriFactory::build($this->exportUri . '{?}&template=' . $template->getId()); ?>">
                        <td><a href="<?= $url; ?>"><?= $this->printHtml($template->name); ?></a>
                    <?php endforeach; ?>
            </table>
            <div class="portlet-foot">
                <label class="button cancel" for="<?= $this->id; ?>-export"><?= $this->getHtml('Cancel', '0', '0'); ?></label>
            </div>
    </div>
</span>