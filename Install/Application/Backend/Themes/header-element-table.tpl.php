<label class="checkbox" for="<?= $this->id; ?>-primary-<?= $this->counter; ?>">
    <input id="<?= $this->id; ?>-primary-<?= $this->counter; ?>"
        class="oms-ui-state"
        type="checkbox"
        name="<?= $this->id; ?>-primary-<?= $this->counter; ?>"
        value="1" checked>
    <span class="checkmark"></span>
    <?= $data[0]; ?>
</label>
<?= $this->renderSort(...$data); ?>
<?= $this->renderFilter(...$data); ?>