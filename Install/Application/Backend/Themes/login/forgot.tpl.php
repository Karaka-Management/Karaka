<?php
/**
 * Jingga
 *
 * PHP Version 8.2
 *
 * @package   Web\Backend
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.0
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

use phpOMS\Uri\UriFactory;

?>
<?php include __DIR__ . '/head.tpl.php'; ?>
<main>
    <div id="login-container">
        <div id="login-logo">
            <img alt="<?= $this->getHtml('Logo', '0', '0'); ?>" src="<?= UriFactory::build('Web/Backend/img/logo.png'); ?>">
        </div>
        <header><h1><?= $this->getHtml('ForgotPassword', '0', '0'); ?></h1></header>
        <div id="login-form">
            <form id="forgot" method="POST" action="<?= UriFactory::build('{/api}forgot?{?}'); ?>">
                <label for="iName"><?= $this->getHtml('Username', '0', '0'); ?>:</label>
                <div class="inputWithIcon">
                    <i class="frontIco g-icon" aria-hidden="true">person</i>
                    <input id="iName" type="text" name="user" tabindex="1" value="" autocomplete="off" spellcheck="false" autofocus>
                    <i class="endIco g-icon close" aria-hidden="true">close</i>
                </div>
                <input id="iForgotButton" name="forgotButton" type="submit" value="<?= $this->getHtml('Submit', '0', '0'); ?>" tabindex="3">
            </form>
        </div>
        <div id="below-form"><a href="<?= UriFactory::build('{/base}/{/backend}'); ?>" tabindex="2"><?= $this->getHtml('Back', '0', '0'); ?></a></div>
    </div>
</main>
<?php include __DIR__ . '/foot.tpl.php'; ?>
