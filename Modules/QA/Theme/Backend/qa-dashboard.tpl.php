<?php
$questions = $this->getData('questions');
echo $this->getData('nav')->render(); ?>

<div class="row">
    <div class="col-xs-12">
        <?php foreach ($questions as $question) : ?>
        <section class="box wf-100 qa-list">
            <div class="inner">
                <div class="row middle-xs">
                    <div class="col-xs-1 scores">
                        <span class="score<?= $this->printHtml($question->hasAccepted() ? ' done' : ''); ?>"><?= $this->printHtml(count($question->getAnswers())); ?></span>
                    </div>
                    <div class="title col-xs-11">
                        <a href="<?= \phpOMS\Uri\UriFactory::build('{/base}/{/lang}/backend/qa/question?{?}&id=' . $question->getId()); ?>"><?= $this->printHtml($question->getName()); ?></a>
                    </div>
                </div>
                <div class="tags">
                <?php $badges = $question->getBadges(); foreach ($badges as $badge) : ?>
                    <span class="tag red"><?= $this->printHtml($badge->getName()); ?></span>
                <?php endforeach; ?>
                </div>
            </div>
        </section>
        <?php endforeach; ?>
    </div>
</div>
