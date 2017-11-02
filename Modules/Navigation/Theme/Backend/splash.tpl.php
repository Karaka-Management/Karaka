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
 * @link       http://orange-management.com
 */
/**
 * @var \Modules\Navigation\Views\NavigationView $this
 */
if (isset($this->nav[\Modules\Navigation\Models\NavigationType::CONTENT])) :
    foreach ($this->nav[\Modules\Navigation\Models\NavigationType::CONTENT] as $key => $parent) :
        foreach ($parent as $link) :
            if ($link['nav_parent'] == $this->parent) : ?>
                <section class="box w-33 floatLeft">
                    <div class="inner centerText">
                        <a href="<?= \phpOMS\Uri\UriFactory::build($link['nav_uri']); ?>">
                            <p><i class="fa-5x <?= $this->printHtml($link['nav_icon']); ?>"></i></p>
                            <p><?= $this->getHtml($link['nav_name']); ?></p>
                        </a>
                    </div>
                </section>
<?php endif; endforeach; endforeach; endif;
