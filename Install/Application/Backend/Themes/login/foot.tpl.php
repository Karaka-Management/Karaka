<?php
/**
 * Karaka
 *
 * PHP Version 8.1
 *
 * @package   Web\Backend
 * @copyright Dennis Eichhorn
 * @license   OMS License 1.0
 * @version   1.0.0
 * @link      https://karaka.app
 */
declare(strict_types=1);

use phpOMS\Uri\UriFactory;
?>
<footer>
    <ul>
        <li><a href="<?= UriFactory::build('{/backend}?{?}'); ?>"><?= $this->getHtml('Login', '0', '0'); ?></a>
        <li><a href="<?= UriFactory::build('{/prefix}privacy?{?}'); ?>"><?= $this->getHtml('PrivacyPolicy', '0', '0'); ?></a>
        <li><a href="<?= UriFactory::build('{/prefix}terms?{?}'); ?>"><?= $this->getHtml('Terms', '0', '0'); ?></a>
        <li><a href="<?= UriFactory::build('{/prefix}imprint?{?}'); ?>"><?= $this->getHtml('Imprint', '0', '0'); ?></a>
    </ul>
</footer>

<?= $head->renderAssetsLate(); ?>