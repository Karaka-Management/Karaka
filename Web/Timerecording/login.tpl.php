<?php
/**
 * Orange Management
 *
 * PHP Version 7.4
 *
 * @package   Web\Timerecording
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
    <meta name="theme-color" content="#9e51c5">
    <meta name="msapplication-navbutton-color" content="#9e51c5">
    <meta name="theme-color" content="#9e51c5">
    <meta name="description" content="<?= $this->getHtml(':meta', '0', '0'); ?>">
    <link rel="manifest" href="<?= \phpOMS\Uri\UriFactory::build('Web/Timerecording/manifest.json'); ?>">
    <link rel="shortcut icon" href="<?= \phpOMS\Uri\UriFactory::build('Web/Timerecording/img/favicon.ico'); ?>" type="image/x-icon">
    <?= $head->getMeta()->render(); ?>
    <title><?= $this->printHtml($head->getTitle()); ?></title>
    <style><?= $head->renderStyle(); ?></style>
    <script><?= $head->renderScript(); ?></script>
    <?= $head->renderAssets(); ?>
    <style type="text/css">
        :root {
            --main-background: #2e1a5a;
            --main-background-highlight: #9e51c5;

            --input-border: rgba(166, 135, 232, .4);
            --input-border-active: rgba(166, 135, 232, .7);
            --input-color: rgba(166, 135, 232, .6);
            --input-color-active: rgba(166, 135, 232, .8);

            --input-icon-color: rgba(166, 135, 232, .6);
            --input-icon-color-active: rgba(166, 135, 232, 1);

            --button-main-background: rgba(166, 135, 232, .6);
            --button-main-background-active: rgba(166, 135, 232, .8);
            --button-main-color: rgba(255, 255, 255, .9);

            --text-on-background-color: rgba(255, 255, 255, 0.7);
        }

        html, body {
            height: 100%;
            font-family: 'Roboto', sans-serif;
            background-image: linear-gradient(var(--main-background-highlight), var(--main-background));
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
            max-width: 800px;
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
            max-width: 200px;
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
            margin-bottom: 1rem;
        }

        #login-logo, #login-form {
            text-align: center;
        }

        form {
            margin-bottom: 1rem;
            display: inline-block;
            text-align: center;
            width: 100%;
        }

        form label {
            text-shadow: none;
            color: var(--text-on-background-color);
            cursor: pointer;
        }

        form input[type=submit], button {
            width: 100%;
            max-width: 20rem;
            background-color: var(--button-main-background);
            border: none;
            text-shadow: none;
            box-shadow: none;
            color: var(--button-main-color);
            cursor: pointer;
            transition : background-color 500ms ease-out;
            margin-bottom: 1rem;
        }

        form input[type=submit]:hover, button:hover,
        form input[type=submit]:focus, button:focus {
            background-color: var(--button-main-background-active);
            border: none;
            text-shadow: none;
            box-shadow: none;
        }

        video {
            width: 100%;
            height: 100%;
        }
    </style>
</head>
<body>
<div id="login-container">
    <div id="login-logo">
        <img alt="<?= $this->getHtml('Logo', '0', '0'); ?>" src="<?= \phpOMS\Uri\UriFactory::build('Web/Backend/img/logo.png'); ?>">
    </div>
    <div id="login-form">
        <form id="login" method="POST" action="<?= \phpOMS\Uri\UriFactory::build('{/api}login?{?}'); ?>">
            <button id="iLoginButton" name="loginButton" type="button" tabindex="1"><?= $this->getHtml('Login', '0', '0'); ?></button>
            <h1 id="iLoginText" class="hidden">Please hold your ID in front of the camera:</h1>
            <video id="iVideoCanvas" class="hidden"></video>
            <div id="iCountdown" class="hidden">Camera turns off in: <span id="iCountdownClock"></span> (s)</div>
        </form>
    </div>
</div>
<?= $head->renderAssetsLate(); ?>
