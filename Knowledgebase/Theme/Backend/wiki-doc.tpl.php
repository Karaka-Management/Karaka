<?php 

$doc = $this->getData('doc');

/**
 * @var \phpOMS\Views\View $this
 */
echo $this->getData('nav')->render();
?>

<div class="row">
    <div class="col-xs-12">
        <section class="box wf-100">
            <header><h1><?= $this->printHtml($doc->getTitle()); ?></h1></header>
            <div class="inner">
                <article>
                    <?= $this->printHtml($doc->getDoc()); ?>
                </article>
            </div>
        </section>
    </div>
</div>