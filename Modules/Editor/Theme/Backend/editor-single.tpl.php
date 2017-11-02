<?= $this->getData('nav')->render(); ?>

<div class="row">
    <div class="col-xs-12">
        <section class="box wf-100">
            <div class="inner"><?= $this->getData('doc')->getContent(); ?></div>
        </section>
    </div>
</div>