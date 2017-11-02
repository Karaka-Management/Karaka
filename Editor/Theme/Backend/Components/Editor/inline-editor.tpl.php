<div class="tabular">
    <ul class="tab-links">
        <li><label for="c-tab-1"><?= $this->getHtml('Text', 'Editor'); ?></label>
        <li><label for="c-tab-2"><?= $this->getHtml('Preview', 'Editor'); ?></label>
    </ul>
    <div class="tab-content">
        <input type="radio" id="c-tab-1" name="tabular-1" checked>

        <div class="tab">
            <textarea style="height: 300px" placeholder="&#xf040;" name="plain" form="docForm"><?= $this->printHtml(isset($doc) ? $doc->getPlain() : ''); ?></textarea><input type="hidden" id="iParsed" name="parsed">
        </div>
        <input type="radio" id="c-tab-2" name="tabular-1">

        <div class="tab">
            <?= $this->printHtml(isset($doc) ? $doc->getContent() : ''); ?>
        </div>
    </div>
</div>