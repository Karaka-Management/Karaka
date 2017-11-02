<div class="b b-3 m-<?= $this->printHtml($this->module); ?> mp-<?= $this->printHtml(($this->module + $this->pageId)); ?>"
     id="i-<?= $this->printHtml(($this->module + $this->id)); ?>">
    <h1>
        <?= $this->printHtml($this->title ); ?>
        <i class="fa fa-minus min"></i>
        <i class="fa fa-plus max vh"></i>
    </h1>

    <div class="bc-1">
        <?php
        /** @var  \phpOMS\Views\View $view */
        foreach ($this->views as $view) {
            echo $view->render();
        }
        ?>
    </div>
</div>