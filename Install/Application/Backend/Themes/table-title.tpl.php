<?php declare(strict_types=1);

use phpOMS\Uri\UriFactory;

$previous = $this->getPreviousLink(
    $this->request,
    empty($this->objects) || !$this->getData('hasPrevious') ? null : \reset($this->objects)
);

$next = $this->getNextLink(
    $this->request,
    empty($this->objects) ? null : \end($this->objects),
    $this->getData('hasNext') ?? false
);

$search = $this->getSearchLink(
    $this->id . '-searchbox'
);
?>
<span>
    <?php if ($this->getData('hasPrevious') ?? false) : ?>
        <a rel="prefetch" href="<?= UriFactory::build($previous); ?>"><i class="fa lni lni-chevron-left btn"></i></a>
    <?php endif; ?>
    <?= $data[0]; ?>
    <?php if ($this->getData('hasNext') ?? false) : ?>
        <a rel="prefetch" href="<?= UriFactory::build($next); ?>"><i class="fa lni lni-chevron-right btn"></i></a>
    <?php endif; ?>
    <?php if ($data[1]) : ?>
    <form class="inline" id="<?= $this->id; ?>-search" method="GET" action="<?= UriFactory::build($search); ?>&search={#<?= $this->id; ?>-searchbox}">
        <span role="search" class="inputWrapper">
            <span class="textWrapper">
                <input id="<?= $this->id; ?>-searchbox" name="search" type="text" autocomplete="off" value="<?= $this->request->getData('search') ?? ''; ?>" autofocus>
                <i class="endIcon lni lni-close close" aria-hidden="true"></i>
            </span>
            <button type="submit"><i class="frontIcon lni lni-search-alt" aria-hidden="true"></i></button>
        </span>
    </form>
    <?php endif; ?>
</span>
<?= $this->renderExport(); ?>
