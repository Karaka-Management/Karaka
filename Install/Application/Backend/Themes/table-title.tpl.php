<?php

use phpOMS\Uri\UriFactory;
?>
<span>
    <a rel="prefetch" href="<?= UriFactory::build($previous); ?>"><i class="fa fa-chevron-left btn"></i></a>
    <?= $this->getHtml('Audits'); ?>
    <a rel="prefetch" href="<?= UriFactory::build($next); ?>"><i class="fa fa-chevron-right btn"></i></a>
    <form id="<?= $this->id; ?>-searchbar" method="GET" action="<?= UriFactory::build($search); ?>">
        <span role="search" class="inputWrapper">
            <span class="textWrapper">
                <input id="iSearchBoxTable" name="search" type="text" autocomplete="off" value="<?= $search; ?>" autofocus>
                <i class="endIcon fa fa-times fa-lg fa-fw" aria-hidden="true"></i>
            </span>
            <button type="submit" id="iSearchButtonTable" name="searchButtonTable"><i class="frontIcon fa fa-search fa-fw" aria-hidden="true"></i></button>
        </span>
    </form>
</span>
<?= $tableView->renderExport(); ?>