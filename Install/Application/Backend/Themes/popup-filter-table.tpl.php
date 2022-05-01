<span class="clickPopup">
    <input id="<?= $this->id; ?>-filter-<?= $this->counter; ?>" name="<?= $this->id; ?>-filter-<?= $this->counter; ?>" type="checkbox">
    <label for="<?= $this->id; ?>-filter-<?= $this->counter; ?>"><i class="filter fa fa-filter btn"></i></label>
    <div class="popup">
        <ul>
            <li><?= $this->getHtml('Filter', '0', '0'); ?>
            <?php if ($data[1] === 'text') : ?>
            <li>
                <input type="text" name="<?= $this->id; ?>-filter-<?= $this->counter; ?>-f1">
            <?php elseif ($data[1] === 'select') : ?>
            <li>
                <select name="<?= $this->id; ?>-filter-<?= $this->counter; ?>-f2" multiple>
                    <?php foreach ($data[2] as $value => $option) : ?>
                        <option value="<?= $value; ?>"><?= $option; ?>
                    <?php endforeach; ?>
                </select>
            <?php elseif ($data[1] === 'number' || $data[1] === 'date'): ?>
            <li>
                <select name="<?= $this->id; ?>-filter-<?= $this->counter; ?>-o1">
                    <option>=
                    <option>>
                    <option>>=
                    <option><=
                    <option><
                </select>
                <?php if ($data[1] === 'number') : ?>
                    <input type="text" name="<?= $this->id; ?>-filter-<?= $this->counter; ?>-f3">
                <?php else : ?>
                    <input type="date" name="<?= $this->id; ?>-filter-<?= $this->counter; ?>-f4">
                <?php endif; ?>
            <li><?= $this->getHtml('AND'); ?>
            <li>
                <select name="<?= $this->id; ?>-filter-<?= $this->counter; ?>-o2">
                    <option>=
                    <option>>
                    <option>>=
                    <option><=
                    <option><
                </select>
                <?php if ($data[1] === 'number') : ?>
                    <input type="text" name="<?= $this->id; ?>-filter-<?= $this->counter; ?>-f5">
                <?php else : ?>
                    <input type="date" name="<?= $this->id; ?>-filter-<?= $this->counter; ?>-f6">
                <?php endif; ?>
            <?php endif; ?>
            <li><label class="button close" for="<?= $this->id; ?>-filter-<?= $this->counter; ?>"><?= $this->getHtml('Cancel', '0', '0'); ?></label>
            <li><label class="button save" for="<?= $this->id; ?>-filter-<?= $this->counter; ?>"><?= $this->getHtml('Filter', '0', '0'); ?></label>
            <li><label class="button cancel" for="<?= $this->id; ?>-filter-<?= $this->counter; ?>"><?= $this->getHtml('Reset', '0', '0'); ?></label>
        </ul>
    </div>
</span>