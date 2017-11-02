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

/* Looping through all links */
if (isset($this->nav[\Modules\Navigation\Models\NavigationType::CONTENT_SIDE])) {
    echo '<div class="b b-5 c3-2 c3" id="i3-2-5">'
         . '<h1>' . $this->getHtml('Navigation')
         . '<i class="fa fa-minus min"></i><i class="fa fa-plus max vh"></i>'
         . '</h1>'
         . '<div class="bc-1">'
         . '<ul id="ms-nav" role="navigation">';

    foreach ($this->nav[\Modules\Navigation\Models\NavigationType::CONTENT_SIDE] as $key => $parent) {
        foreach ($parent as $link) {
            /** @var array $data */
            if ($link['nav_parent'] == $data[1]) {
                echo '<li><a href="' . \phpOMS\Uri\UriFactory::build($link['nav_uri']) . '">'
                     . $this->getHtml(5, 'Backend', $link['nav_name']) . '</a>';
            }
        }
    }

    echo '</ul></div></div>';
}
