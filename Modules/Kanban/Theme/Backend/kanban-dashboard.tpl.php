<?php
$boards = $this->getData('boards');

echo $this->getData('nav')->render(); ?>

<div class="row">
    <?php foreach ($boards as $board) : ?>  
    <div class="col-xs-12 col-sm-6 col-lg-3">
        <a href="<?= $this->printHtml(\phpOMS\Uri\UriFactory::build('/{/lang}/backend/kanban/board?{?}&id=' . $board->getId())); ?>">
        <section class="box wf-100">
            <header><h1><?= $this->printHtml($board->getName()); ?></h1></header>
            <div class="inner">
                <?= $this->printHtml($board->getDescription()); ?>
            </div>
        </section>
        </a>
    </div>
    <?php endforeach; ?>
<div>