<?php
/**
 * Jingga
 *
 * PHP Version 8.2
 *
 * @package   Web\Backend
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.2
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

use phpOMS\Uri\UriFactory;

?>
<footer>
    <ul>
        <li><a href="<?= UriFactory::build('{/base}/?{?}'); ?>"><?= $this->getHtml('Login', '0', '0'); ?></a>
        <li><a href="<?= UriFactory::build('{/base}/privacy?{?}'); ?>"><?= $this->getHtml('PrivacyPolicy', '0', '0'); ?></a>
        <li><a target="_blank" href="<?= UriFactory::build('https://jingga.app/terms'); ?>"><?= $this->getHtml('Terms', '0', '0'); ?></a>
        <li><a href="<?= UriFactory::build('{/base}/imprint?{?}'); ?>"><?= $this->getHtml('Imprint', '0', '0'); ?></a>
    </ul>
</footer>

<?= $head->renderAssetsLate(); ?>