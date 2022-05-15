<?php
    $dropdownId   ??= '';
    $dropdownName ??= '';

    /**
     * [
     *      'text'  => '',
     *      'value' => '',
     *      'dropdownText' => '', (not required if text === dropdownText)
     *      'selected' => false, (default = false)
     *      'placeholder' => false, (e.g. "Please select" element, default = false)
     * ]
     */
    $dropdownElements ??= [];
?>
<label for="<?= $dropdownId; ?>" class="dropdown" data-src="http://">
    <div class="dropdown-closed">
        <?php foreach ($dropdownElements as $key => $element) : ?>
            <input id="<?= $dropdownId . '-e' . $key; ?>"
                name="<?= $dropdownName; ?>"
                value="<?= $element['value']; ?>"
                type="radio"<?= ($element['selected'] ?? false) ? ' checked' : ''; ?>>
            <label for="<?= $dropdownId; ?>"><?= $element['text']; ?></label>
        <?php endforeach; ?>
    </div>
    <input id="<?= $dropdownId; ?>" type="checkbox">
    <div class="dropdown-container">
        <div class="dropdown-search"></div>
        <div class="dropdown-content">
            <?php
                foreach ($dropdownElements as $key => $element) :
                    if ($element['placeholder'] ?? false) {
                        continue;
                    }
            ?>
                <label for="<?= $dropdownId; ?>">
                    <?= $element['dropdownText'] !== '' ? $element['dropdownText'] : $element['text']; ?>
                </label>
            <?php endforeach; ?>
            <label for="<?= $dropdownId; ?>">Close</label>
        <div>
    <div>
</label>