<div class="tabview">
    <!-- @formatter:off -->
    <ul class="tab-links">
        <?php $i = 0; foreach ($this->getViews() as $tab): $i++; ?>
            <li<?= $this->printHtml(($tab->getData('active') === true ? ' class="a"' : '')); ?>><a href=".tab-<?= $this->printHtml($this->id); ?>-<?= $this->printHtml($i); ?>"><?= $this->printHtml($this->tab->title); ?></a>
        <?php endforeach; ?>
    </ul>
    <!-- @formatter:on -->

    <div class="tab-content">
        <!-- @formatter:off -->
        <?php $i = 0; foreach ($this->getViews() as $tab): $i++; ?>
            <div class="tab tab-<?= $this->printHtml($this->id); ?>-<?= $this->printHtml($i); ?><?= $this->printHtml(($tab->getData('active') === true ? ' a' : '')); ?>">
                <?= $this->printHtml($tab->render()); ?>
            </div>
        <?php endforeach; ?>
        <!-- @formatter:on -->
    </div>
</div>