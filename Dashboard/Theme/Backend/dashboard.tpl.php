<div class="row">
<?php $panels = $this->getData('panels'); ?>
<?php foreach ($panels as $panel) : ?>
    <?= $panel->render(); ?>
<?php endforeach; ?>
</div>