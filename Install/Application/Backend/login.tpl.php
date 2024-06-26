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
<?php include __DIR__ . '/Themes/login/head.tpl.php'; ?>
<main>
    <div id="login-container">
        <div id="login-logo">
            <img class="animated infinite medium-duration pulse" alt="<?= $this->getHtml('Logo', '0', '0'); ?>" src="<?= UriFactory::build('Web/Backend/img/logo.png'); ?>">
        </div>
        <header><h1><?= $this->getHtml('Login', '0', '0'); ?></h1></header>
        <div id="login-form">
            <form id="login" method="POST" action="<?= UriFactory::build('{/api}login?{?}'); ?>">
                <label for="iName"><?= $this->getHtml('Username', '0', '0'); ?>:</label>
                <div class="inputWithIcon">
                    <i class="frontIco g-icon" aria-hidden="true">person</i>
                    <input id="iName" type="text" name="user" tabindex="1" value="" autocomplete="off" spellcheck="false" autofocus>
                    <i class="endIco g-icon" aria-hidden="true">close</i>
                </div>
                <label for="iPassword"><?= $this->getHtml('Password', '0', '0'); ?>:</label>
                <div class="inputWithIcon">
                    <i class="frontIco g-icon" aria-hidden="true">lock</i>
                    <input id="iPassword" type="password" name="pass" tabindex="2" value="">
                    <i class="endIco g-icon" aria-hidden="true">close</i>
                </div>
                <input id="iLoginButton" name="loginButton" type="submit" value="<?= $this->getHtml('Login', '0', '0'); ?>" tabindex="3">
            </form>
        </div>

        <div id="below-form"><a href="<?= UriFactory::build('{/base}/forgot'); ?>" tabindex="4"><?= $this->getHtml('ForgotPassword', '0', '0'); ?></a></div>

        <div id="app-message-container">
            <template id="app-message-tpl">
                <div class="log-msg">
                    <h1 class="log-msg-title"></h1><i class="close g-icon">close</i>
                    <div class="log-msg-content"></div>
                    <a class="button primary-button"></a>
                    <a class="button secondary-button"></a>
                </div>
            </template>
        </div>
    </div>
</main>

<?php include __DIR__ . '/Themes/login/foot.tpl.php'; ?>
