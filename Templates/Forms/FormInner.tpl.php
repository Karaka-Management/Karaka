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
 * @link       http://orange-management.com
 */
/**
 * @var \Web\Views\Form\FormView $this
 */
?>
<ul>
    <?php foreach ($this->elements as $row): ?>
    <?php foreach ($row as $element): ?>
    <?php if ($element['type'] === \phpOMS\Html\TagType::SYMMETRIC): ?>
    <?php if (isset($element['label'])): ?>
    <li><label for="n-<?= $this->printHtml($element['name']); ?>"><?= $this->printHtml($element['label']); ?></label>
        <?php endif; ?>
        <?= $this->printHtml('<' . $element['tag'] . (isset($element['class']) ? ' class="' . $element['class'] . '"' : '') . '>' . (isset($element['content']) ? $element['content'] : '') . '</' . $element['tag'] . '>'); ?>
        <?php elseif ($element['type'] === \phpOMS\Html\TagType::INPUT): ?>
        <?php if (isset($element['label']) && $element['subtype'] !== 'checkbox' && $element['subtype'] !== 'radio'): ?>
    <li><label for="n-<?= $this->printHtml($element['name']); ?>"><?= $this->printHtml($element['label']); ?></label>
        <?php endif; ?>
    <li>
        <input<?= $this->printHtml((isset($element['visible']) && !$element['visible'] ? ' class="hidden"' : '')); ?>
            name="<?= $this->printHtml($element['name']); ?>"
            id="<?= $this->printHtml(isset($element['id']) ? $element['id'] : 'n-' . $element['name']); ?>"
            type="<?= $this->printHtml($element['subtype']); ?>"
            value="<?= $this->printHtml((isset($element['value']) ? $element['value'] : '')); ?>"
            <?= $this->printHtml((isset($element['tabindex']) ? ' tabindex="' . $element['tabindex'] . '"' : '')); ?>
            <?= $this->printHtml((isset($element['placeholder']) ? ' placeholder="' . $element['placeholder'] . '"' : '')); ?>
            <?= $this->printHtml((isset($element['pattern']) ? ' pattern="' . $element['pattern'] . '"' : '')); ?>
            <?= $this->printHtml((isset($element['validate']) ? ' data-validate="' . $element['validate'] . '"' : '')); ?>
            <?= $this->printHtml((isset($element['active']) && !$element['active'] ? ' disabled' : '')); ?>
            <?= $this->printHtml((isset($element['autofocus']) && $element['autofocus'] ? ' autofocus' : '')); ?>
            <?= $this->printHtml((isset($element['checked']) && $element['checked'] ? ' checked' : '')); ?>
            <?= $this->printHtml((isset($element['multiple']) && $element['multiple'] ? ' multiple' : '')); ?>
            <?= $this->printHtml((isset($element['accept']) ? ' accept="' . $element['accept'] . '"' : '')); ?>
            <?= $this->printHtml((isset($element['class']) ? ' class="' . $element['class'] . '"' : '')); ?>>
        <?php if ($element['subtype'] === 'file') : ?>
            <input type="hidden" name="f-<?= $this->printHtml($element['name']); ?>">
        <?php endif; ?>
        <?php if (isset($element['label']) && $element['subtype'] === 'checkbox'): ?>
            <label for="<?= $this->printHtml($element['name']); ?>"><?= $this->printHtml($element['label']); ?></label>
        <?php endif; ?>
        <?php if (isset($element['info'])): ?>
            <i class="bt-1 b-3 vh"><?= $this->printHtml($element['info']); ?></i>
        <?php endif; ?>
        <?php elseif ($element['type'] === \phpOMS\Html\TagType::BUTTON): ?>
            <button<?= $this->printHtml((isset($element['class']) ? ' class="' . $element['class'] . '"' : '')); ?><?= $this->printHtml((isset($element['name']) ? ' data-name="' . $element['name'] . '"' : '')); ?>
                type="button"<?php if (isset($element['data'])) {
    foreach ($element['data'] as $key => $data) {
        echo ' data-' . $key . '=' . $data;
    }
} ?>><?= $this->printHtml($element['label']); ?></button>
        <?php elseif ($element['type'] === \phpOMS\Html\TagType::TEXTAREA): ?>
        <?php if (isset($element['label'])): ?>
    <li><label for="n-<?= $this->printHtml($element['name']); ?>"><?= $this->printHtml($element['label']); ?></label>
        <?php endif; ?>
    <li>
        <textarea name="<?= $this->printHtml($element['name']); ?>"
                  id="<?= $this->printHtml(isset($element['id']) ? $element['id'] : 'n-' . $element['name']); ?>"><?= $this->printHtml((isset($element['content']) ? $element['content'] : '')); ?></textarea>
        <?php elseif ($element['type'] === \phpOMS\Html\TagType::SELECT): ?>
        <?php if (isset($element['label'])): ?>
    <li><label for="n-<?= $this->printHtml($element['name']); ?>"><?= $this->printHtml($element['label']); ?></label>
        <?php endif; ?>
    <li>
        <select 
        name="<?= $this->printHtml($element['name']); ?>" id="<?= $this->printHtml(isset($element['id']) ? $element['id'] : 'n-' . $element['name']); ?>"
            <?= $this->printHtml((isset($element['id']) ? ' id="' . $element['id'] . '"' : '')); ?>
            <?= $this->printHtml((isset($element['class']) ? ' class="' . $element['class'] . '"' : '')); ?>>
            <?php foreach ($element['options'] as $option): ?>
                <option
                    value="<?= $this->printHtml($option['value']); ?>"<?= $this->printHtml((isset($option['selected']) && $option['selected'] ? ' selected' : '')); ?>><?= $this->printHtml($option['content']); ?></option>
            <?php endforeach; ?>
        </select>
        <?php elseif ($element['type'] === \phpOMS\Html\TagType::LABEL): ?>

            <label for="<?= $this->printHtml($element['for']); ?>"><?= $this->printHtml($element['content']); ?></label>
        <?php elseif ($element['type'] === \phpOMS\Html\TagType::ULIST): ?>
        <?php if (isset($element['label'])): ?>
    <li><label for="n-<?= $this->printHtml($element['name']); ?>"><?= $this->printHtml($element['label']); ?></label>
        <?php endif; ?>
    <li><input type="hidden" name="h-<?= $this->printHtml($element['name']); ?>" disabled="disabled"
            <?= $this->printHtml((isset($element['id']) ? ' id="' . $element['id'] . '"' : '')); ?>
            <?= $this->printHtml((isset($element['class']) ? ' class="' . $element['class'] . '"' : '')); ?>>
        <ul data-name="l-<?= $this->printHtml($element['name']); ?>">
            <?php foreach ($element['list'] as $li) : ?>
            <li><?= $this->printHtml($li); ?>
                <?php endforeach; ?>
        </ul>
        <?php endif; ?>
        <?php endforeach; ?>
        <?php endforeach; ?>
        <?php if (count($this->submit) > 0): ?>
    <li class="submit">
        <?php foreach ($this->submit as $key => $submit) : ?>
            <input class="<?php if (isset($submit[1]['float']) && $submit[1]['float'] === 1) {
    echo ' rf';
} elseif (isset($submit[1]['float']) && $submit[1]['float'] === -1) {
    echo 'lf';
} ?>" type="submit" name="<?= $this->printHtml($key); ?>"
                   value="<?= $this->printHtml($submit[0]); ?>"
                   <?= $this->printHtml((isset($submit[1]['visible']) && !$submit[1]['visible'] ? ' disabled' : '')); ?>>
        <?php endforeach; ?>
        <?php endif; ?>
</ul>
