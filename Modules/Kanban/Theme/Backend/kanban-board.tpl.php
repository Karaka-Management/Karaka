<?php
$board = $this->getData('board');
$columns = $board->getColumns();
// todo: column width should be % but with min-width and on small screens full width
?>
<div class="row">
    <?php $i = 0; foreach ($columns as $column) : $i++; $cards = $column->getCards(); ?>
    <div id="kanban-column-<?= $this->printHtml($i); ?>" class="col-xs-12 col-sm-3" draggable="true">
        <header><?= $this->printHtml($column->getName()); ?></header>
        <?php $j = 0; foreach ($cards as $card) : $j++; $labels = $card->getLabels(); ?>
            <a href="<?= $this->printHtml(\phpOMS\Uri\UriFactory::build('/{/lang}/backend/kanban/card?{?}&id=' . $card->getId())); ?>">
            <section id="kanban-card-<?= $this->printHtml($i . '-' . $j); ?>" class="box wf-100" draggable="true">
                <header><h1><?= $this->printHtml($card->getName()); ?></h1></header>
                <div class="inner">
                    <?= $this->printHtml($card->getDescription()); ?>
                    <?php foreach ($labels as $label) : ?>
                    <span class="tag" style="background: #<?= $this->printHtml(dechex($label->getColor())); ?>"><?= $this->printHtml($label->getName()); ?></span>
                    <?php endforeach; ?>
                </div>
            </section>
            </a>
        <?php endforeach; ?>
    </div>
    <?php endforeach; ?>
</div>