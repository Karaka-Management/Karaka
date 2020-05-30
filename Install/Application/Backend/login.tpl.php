<?php declare(strict_types=1);
/**
 * Orange Management
 *
 * PHP Version 7.4
 *
 * @package   Web\Backend
 * @copyright Dennis Eichhorn
 * @license   OMS License 1.0
 * @version   1.0.0
 * @link      https://orange-management.org
 */
$head = $this->getData('head');
?>
<!DOCTYPE HTML>
<html lang="<?= $this->printHtml($this->response->getHeader()->getL11n()->getLanguage()); ?>">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8">
    <base href="<?= \phpOMS\Uri\UriFactory::build('{/base}'); ?>/">
    <meta name="theme-color" content="#343a40">
    <meta name="msapplication-navbutton-color" content="#343a40">
    <meta name="theme-color" content="#343a40">
    <meta name="description" content="<?= $this->getHtml(':meta', '0', '0'); ?>">
    <link rel="manifest" href="<?= \phpOMS\Uri\UriFactory::build('Web/Backend/manifest.json'); ?>">
    <link rel="shortcut icon" href="<?= \phpOMS\Uri\UriFactory::build('Web/Backend/img/favicon.ico'); ?>" type="image/x-icon">
    <?= $head->getMeta()->render(); ?>
    <title><?= $this->printHtml($head->getTitle()); ?></title>
    <style><?= $head->renderStyle(); ?></style>
    <script><?= $head->renderScript(); ?></script>
    <?= $head->renderAssets(); ?>
    <style type="text/css">
        :root {
            --main-background: #343a40;

            --input-border: rgba(54, 150, 219, 0.4);
            --input-border-active: rgba(54, 150, 219, 0.7);
            --input-color: rgba(166, 135, 232, .6);
            --input-color-active: rgba(166, 135, 232, .8);

            --input-icon-color: rgba(54, 150, 219, .6);
            --input-icon-color-active: rgba(54, 150, 219, 1);

            --button-main-background: #3697db;
            --button-main-background-active: #4aabf0;
            --button-main-color: rgba(255, 255, 255, .9);

            --text-on-background-color: rgba(255, 255, 255, 0.7);
        }

        html, body {
            height: 100%;
            font-family: 'Roboto', sans-serif;
            background: var(--main-background);
            color: var(--text-on-background-color);
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            height: 100%;
            flex-direction: column;
            font-weight: 300;
        }

        #login-container {
            width: 90%;
            max-width: 300px;
            margin: 0 auto;
        }

        #login-logo {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 185px;
        }

        #login-logo img {
            animation: pulse 1.5s ease infinite alternate;
            width: 60%;
        }

        @keyframes pulse {
            0% {
                width: 60%;
            }

            30%, 100% {
                width: 65%;
            }
        }

        header {
            text-align: left;
            margin-bottom: 1rem;
        }

        header h1 {
            font-weight: 300;
        }

        #login-logo {
            margin-bottom: 10%;
        }

        #login-logo {
            text-align: center;
        }

        form {
            margin-bottom: 10%;
        }

        form label {
            text-shadow: none;
            color: var(--text-on-background-color);
            cursor: pointer;
        }

        form input[type=text],
        form input[type=password] {
            margin-bottom: .5rem;
            background: rgba(0, 0, 0, .15);
            border: 1px solid var(--input-border);
            text-shadow: none;
            box-shadow: none;
            color: var(--text-on-background-color);
            width: 100%;
            transition : border 500ms ease-out;
            outline: none;
            box-sizing: border-box;
            line-height: 1rem;
        }

        .inputWithIcon {
            position: relative;
        }

        .inputWithIcon input {
            padding-left: 2.5rem;
        }

        .inputWithIcon .frontIcon {
            color: var(--input-icon-color);
            font-size: 1rem;
            position: absolute;
            left: 0;
            top: 0;
            padding: .65rem;
        }

        .inputWithIcon .endIcon {
            color: var(--input-icon-color);
            font-size: 1rem;
            position: absolute;
            right: 0;
            top: 0;
            padding: .65rem;
        }

        form input[type=text]:active, form input[type=text]:focus,
        form input[type=password]:active, form input[type=password]:focus {
            border: 1px solid var(--input-border-active);
            color: var(--text-on-background-color);
        }

        form input[type=text]:active~.frontIcon, form input[type=text]:focus~.frontIcon,
        form input[type=password]:active~.frontIcon, form input[type=password]:focus~.frontIcon,
        form input[type=text]:active~.endIcon, form input[type=text]:focus~.endIcon,
        form input[type=password]:active~.endIcon, form input[type=password]:focus~.endIcon {
            color: var(--input-icon-color-active);
        }

        form input[type=text]~.endIcon, form input[type=text]~.endIcon,
        form input[type=password]~.endIcon, form input[type=password]~.endIcon {
            cursor: pointer;
        }

        form input[type=submit] {
            width: 100%;
            background-color: var(--button-main-background);
            border: none;
            text-shadow: none;
            box-shadow: none;
            color: var(--button-main-color);
            cursor: pointer;
            transition : background-color 500ms ease-out;
        }

        form input[type=submit]:hover,
        form input[type=submit]:focus {
            background-color: var(--button-main-background-active);
            border: none;
            text-shadow: none;
            box-shadow: none;
        }

        #forgot-password {
            text-align: center;
        }

        #forgot-password a {
            padding-bottom: .5rem;
            cursor: pointer;
            transition : border-bottom 100ms ease-out;
        }

        #forgot-password a:hover,
        #forgot-password a:focus {
            color: rgba(255, 255, 255, .8);
            border-bottom: 1px solid rgba(255, 255, 255, .6);
        }
    </style>
</head>
<body>
<div id="login-container">
    <div id="login-logo">
        <img alt="<?= $this->getHtml('Logo', '0', '0'); ?>" src="<?= \phpOMS\Uri\UriFactory::build('Web/Backend/img/logo.png'); ?>">
    </div>
    <header><h1><?= $this->getHtml('Login', '0', '0'); ?></h1></header>
    <div id="login-form">
        <form id="login" method="POST" action="<?= \phpOMS\Uri\UriFactory::build('{/api}login?{?}'); ?>">
            <label for="iName"><?= $this->getHtml('Username', '0', '0'); ?>:</label>
            <div class="inputWithIcon">
                <input id="iName" type="text" name="user" tabindex="1" value="admin" autofocus>
                <i class="frontIcon fa fa-user fa-lg fa-fw" aria-hidden="true"></i>
                <i class="endIcon fa fa-times fa-lg fa-fw" aria-hidden="true"></i>
            </div>
            <label for="iPassword"><?= $this->getHtml('Password', '0', '0'); ?>:</label>
            <div class="inputWithIcon">
                <input id="iPassword" type="password" name="pass" tabindex="2" value="orange">
                <i class="frontIcon fa fa-lock fa-lg fa-fw" aria-hidden="true"></i>
                <i class="endIcon fa fa-times fa-lg fa-fw" aria-hidden="true"></i>
            </div>
            <input id="iLoginButton" name="loginButton" type="submit" value="<?= $this->getHtml('Login', '0', '0'); ?>" tabindex="3">
        </form>
    </div>
    <div id="forgot-password"><a href="#" tabindex="4">Forgot Password?</a></div>
</div>
<?= $head->renderAssetsLate(); ?>
