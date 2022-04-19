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

$head = $this->getData('head');
?>
<?php include __DIR__ . '/head.tpl.php'; ?>
<body>
<main>
    <div id="login-container">
        <div id="login-logo">
            <img alt="<?= $this->getHtml('Logo', '0', '0'); ?>" src="<?= UriFactory::build('Web/Backend/img/logo.png'); ?>">
        </div>
        <header><h1><?= $this->getHtml('ResetPassword', '0', '0'); ?></h1></header>
        <div id="login-form">
            <form id="forgot" method="POST" action="<?= UriFactory::build('{/api}reset?{?}'); ?>">
                <input id="iResetButton" name="resetButton" type="submit" value="<?= $this->getHtml('Reset', '0', '0'); ?>" tabindex="3">
            </form>
        </div>
        <div id="below-form"><a href="<?= UriFactory::build('{/backend}'); ?>" tabindex="2"><?= $this->getHtml('Back', '0', '0'); ?></a></div>
    </div>
</main>
<?php include __DIR__ . '/foot.tpl.php'; ?>
