<?php
/**
 * Orange Management
 *
 * PHP Version 7.1
 *
 * @category   TBD
 * @package    TBD
 * @copyright  Dennis Eichhorn
 * @license    OMS License 1.0
 * @version    1.0.0
 * @link       http://website.orange-management.de
 */
/**
 * @var \Modules\Navigation\Views\NavigationView $this
 */
if (isset($this->nav[\Modules\Navigation\Models\NavigationType::TOP])): ?>
    <ul id="t-nav" role="navigation">

        <?php $unread = $this->getData('unread');
        foreach ($this->nav[\Modules\Navigation\Models\NavigationType::TOP] as $key => $parent) :
        foreach ($parent as $link) : ?>
        <li><a href="<?= \phpOMS\Uri\UriFactory::build($link['nav_uri']); ?>">

                <?php if (isset($link['nav_icon'])) : ?>
                    <i class="<?= $this->printHtml($link['nav_icon']); ?> infoIcon"><?php if (isset($unread[$link['nav_from']]) && $unread[$link['nav_from']] > 0) : ?><span class="badge"><?= $this->printHtml($unread[$link['nav_from']]); ?></span><?php endif; ?></i>
                <?php endif; ?>

                <?= $this->getHtml($link['nav_name']) ?></a>
            <?php endforeach;
            endforeach; ?>

    </ul>
<?php endif;
