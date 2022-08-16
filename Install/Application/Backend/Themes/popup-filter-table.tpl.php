<?php if ($data[5]) : ?>
<span class="clickPopup">
    <input form="<?= $this->id; ?>-search" id="<?= $this->id; ?>-f-<?= $this->counter; ?>" name="<?= $this->id; ?>-f-<?= $data[0]; ?>-t" type="hidden" value="<?= $data[2]; ?>">
    <input id="<?= $this->id; ?>-f-<?= $this->counter; ?>-popup" name="<?= $this->id; ?>-f-<?= $this->counter; ?>-popup" type="checkbox">
    <label for="<?= $this->id; ?>-f-<?= $this->counter; ?>-popup"><i class="filter lni lni-funnel btn"></i></label>
    <div class="popup">
        <ul>
            <li><?= $this->getHtml('Filter', '0', '0'); ?>
            <?php if ($data[2] === 'text') : ?>
            <li>
                <input form="<?= $this->id; ?>-search" type="text" name="<?= $this->id; ?>-f-<?= $data[0]; ?>-f1">
            <?php elseif ($data[2] === 'select') : ?>
            <li>
                <select form="<?= $this->id; ?>-search" name="<?= $this->id; ?>-f-<?= $data[0]; ?>-f1" multiple>
                    <?php foreach ($data[3] as $value => $option) : ?>
                        <option value="<?= $value; ?>"><?= $option; ?>
                    <?php endforeach; ?>
                </select>
            <?php elseif ($data[2] === 'number' || $data[2] === 'date'): ?>
            <li>
                <select form="<?= $this->id; ?>-search" name="<?= $this->id; ?>-f-<?= $data[0]; ?>-o1">
                    <option value="=">=
                    <option value=">">>
                    <option value=">=">>=
                    <option value="<="><=
                    <option value="<"><
                </select>
                <?php if ($data[2] === 'number') : ?>
                    <input form="<?= $this->id; ?>-search" type="text" name="<?= $this->id; ?>-f-<?= $data[0]; ?>-f1">
                <?php else : ?>
                    <input form="<?= $this->id; ?>-search" type="date" name="<?= $this->id; ?>-f-<?= $data[0]; ?>-f1">
                <?php endif; ?>
            <li><?= $this->getHtml('AND'); ?>
            <li>
                <select form="<?= $this->id; ?>-search" name="<?= $this->id; ?>-f-<?= $data[0]; ?>-o2">
                    <option value="=">=
                    <option value=">">>
                    <option value=">=">>=
                    <option value="<="><=
                    <option value="<"><
                </select>
                <?php if ($data[2] === 'number') : ?>
                    <input form="<?= $this->id; ?>-search" type="text" name="<?= $this->id; ?>-f-<?= $data[0]; ?>-f2">
                <?php else : ?>
                    <input form="<?= $this->id; ?>-search" type="date" name="<?= $this->id; ?>-f-<?= $data[0]; ?>-f2">
                <?php endif; ?>
            <?php endif; ?>
            <li><label class="button close" for="<?= $this->id; ?>-f-<?= $this->counter; ?>-popup"><?= $this->getHtml('Cancel', '0', '0'); ?></label>
            <li><label class="button save" for="<?= $this->id; ?>-f-<?= $this->counter; ?>-popup"><?= $this->getHtml('Filter', '0', '0'); ?></label>
            <li><label class="button cancel" for="<?= $this->id; ?>-f-<?= $this->counter; ?>-popup"><?= $this->getHtml('Reset', '0', '0'); ?></label>
        </ul>
    </div>
</span>
<?php endif; ?>