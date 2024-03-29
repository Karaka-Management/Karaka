<?php declare(strict_types=1);

use phpOMS\Uri\UriFactory;

?>
<label for="<?= $this->id; ?>-sort-<?= $this->counter; ?>-up">
    <?php if ($this->exportUri !== '') : ?>
        <a href="<?= UriFactory::build('{/base}/{/base}{/}{?}&element=' . $this->id . '&sort_by=' . $data[1] . '&sort_order=ASC'); ?>">
    <?php endif; ?>
        <input
        id="<?= $this->id; ?>-sort-<?= $this->counter; ?>-up"
        type="radio"
        name="<?= $this->id; ?>-sort"
        <?= $this->id === $this->request->getData('element')
                && $this->request->getData('sort_order') === 'ASC'
                && $data[1] === ($this->request->getData('sort_by') ?? '')
                ? ' checked' : '';
                ?>>
        <i class="sort-asc g-icon">expand_less</i>
        <?php if ($this->exportUri !== '') : ?>
            </a>
        <?php endif; ?>
    </label>

    <label for="<?= $this->id; ?>-sort-<?= $this->counter; ?>-down">
    <?php if ($this->exportUri !== '') : ?>
        <a href="<?= UriFactory::build('{/base}/{/base}{/}{?}&element=' . $this->id . '&sort_by=' . $data[1] . '&sort_order=DESC'); ?>">
    <?php endif; ?>
        <input
        id="<?= $this->id; ?>-sort-<?= $this->counter; ?>-down"
        type="radio"
        name="<?= $this->id; ?>-sort"
        <?= $this->id === $this->request->getData('element')
                && $this->request->getData('sort_order') === 'DESC'
                && $data[1] === ($this->request->getData('sort_by') ?? '')
                ? ' checked' : '';
                ?>>
        <i class="sort-desc g-icon">expand_more</i>
    <?php if ($this->exportUri !== '') : ?>
        </a>
    <?php endif; ?>
</label>