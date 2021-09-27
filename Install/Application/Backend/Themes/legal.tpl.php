<?php

use phpOMS\Utils\Parser\Markdown\Markdown;

$content = $this->getData('content');
?>

<div class="row">
    <div class="col-xs-12">
        <section class="portlet">
            <article><?= Markdown::parse($content->getL11n()->content); ?></article>
        </section>
    </div>
</div>