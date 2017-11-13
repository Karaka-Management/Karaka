<?php
$categories = $this->getData('categories');
echo $this->getData('nav')->render(); ?>

<div class="row">
    <div class="col-xs-12">
        <?php foreach ($categories as $category) : ?>
        <section class="box wf-100 wiki-list">
            <div class="inner">
                <a href="<?= \phpOMS\Uri\UriFactory::build('/{/lang}/backend/wiki/doc/list?{?}&id=' . $category->getId()); ?>"><?= $this->printHtml($category->getName()); ?></a>
            </div>
        </section>
        <?php endforeach; ?>
    </div>
</div>
