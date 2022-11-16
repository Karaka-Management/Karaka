<label class="checkbox" for="<?= $this->id; ?>-p-<?= $this->counter; ?>">
    <?php if ($data[6]) : ?>
    <input id="<?= $this->id; ?>-p-<?= $this->counter; ?>"
        class="oms-ui-state"
        type="checkbox"
        name="<?= $this->id; ?>-p-<?= $data[0]; ?>"
        form="<?= $this->id; ?>-search"
        value="1" checked>
        <span class="checkmark"></span>
    <?php endif; ?>
    <?= $data[1]; ?>
</label>
<?= $data[4] ? $this->renderSort(...$data) : ''; ?>
<?= $data[5] ? $this->renderFilter(...$data) : ''; ?>