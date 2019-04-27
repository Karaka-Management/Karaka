<?php
/**
 * Orange Management
 *
 * PHP Version 7.2
 *
 * @package    TBD
 * @copyright  Dennis Eichhorn
 * @license    OMS License 1.0
 * @version    1.0.0
 * @link       http://website.orange-management.de
 */
$head = $this->getData('head');
?>
<!DOCTYPE HTML>
<html lang="<?= $this->printHtml($this->response->getHeader()->getL11n()->getLanguage()); ?>">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8">
    <base href="<?= \phpOMS\Uri\UriFactory::build('{/base}'); ?>/">
    <link rel="manifest" href="<?= \phpOMS\Uri\UriFactory::build('Web/Backend/manifest.json'); ?>">
    <?= $head->getMeta()->render(); ?>
    <title><?= $this->printHtml($head->getTitle()); ?></title>
    <?= $head->renderAssets(); ?>
    <style><?= $head->renderStyle(); ?></style>
    <script><?= $head->renderScript(); ?></script>
    <style type="text/css">
        html, body {
            height: 100%;
            font-family: arial, serif;
            background: #232323;
            color: #fff;
            text-align: center;
        }

        form label {
            color: #fff;
            text-shadow: none;
        }

        #login {
            text-align: left;
        }

        #login-container {
            font-size: 1.0em;
            padding: 20px;
            text-align: left;
            margin: 0 auto;
            display: inline-block;
        }

        #login-form {
            padding: 30px 0 0 50px;
        }

        #login-logo {
            text-align: center;
        }

        h1 {
            margin-bottom: 30px;
        }

        table.layout {
            width: 100%;
        }

        @media screen and (max-width: 600px) {
            .floatLeft {
                float: none;
            }

            #login-form {
                padding: 30px 0 0 0;
            }
        }
    </style>
</head>
<body>
<div id="login-container">
    <header><h1>Orange Management</h1></header>
    <div id="login-logo" class="floatLeft">
        <img alt="Logo" src="<?= \phpOMS\Uri\UriFactory::build('Web/Backend/img/logo.png'); ?>" width="200">
    </div>
    <div id="login-form" class="floatLeft">
        <form id="login" method="POST" action="<?= \phpOMS\Uri\UriFactory::build('{/api}login?{?}'); ?>">
            <table class="layout">
                <tr><td><label for="iName"><?= $this->getHtml('Username', '0', '0'); ?></label>
                <tr><td><input id="iName" type="text" name="user" tabindex="1" autofocus>
                <tr><td><label for="iPassword"><?= $this->getHtml('Password', '0', '0'); ?></label>
                <tr><td><input id="iPassword" type="password" name="pass" tabindex="2">
                <tr><td><input id="iLoginButton" name="loginButton" type="submit" value="<?= $this->getHtml('Login', '0', '0'); ?>" tabindex="3">
            </table>
        </form>
    </div>
</div>
<?= $head->renderAssetsLate(); ?>
