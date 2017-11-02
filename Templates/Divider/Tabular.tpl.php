<div class="tabview">
    <!-- @formatter:off -->
    <ul class="tab-links">
        <?php $i = 0; foreach ($this->tab as $element): $i++; ?>
            <li<?= $this->printHtml(($this->active === $i) ? ' class="active"' : ''); ?>><a href=".tab-<?= $this->printHtml($i); ?>"><?= $this->printHtml($element['title'] ); ?></a>
        <?php endforeach; ?>
    </ul>
    <!-- @formatter:on -->

    <div class="tab-content">
        <?php $i = 0;
        foreach ($this->tab as $element): $i++; ?>
            <div class="tab tab-<?= $this->printHtml($i); ?><?= $this->printHtml(($this->active === $i) ? ' active' : ''); ?>">
                <?= $this->printHtml($element['content']); ?>
            </div>
        <?php endforeach; ?>
    </div>
</div>