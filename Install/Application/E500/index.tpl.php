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
<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#343a40">
    <meta name="msapplication-navbutton-color" content="#343a40">
    <meta name="apple-mobile-web-app-status-bar-style" content="#343a40">

    <base href="<?= UriFactory::build('{/base}'); ?>/">

    <title>Error 500</title>

    <?= $this->getData('head')->renderAssets(); ?>
</head>
<body>
<header></header>
<main class="centerText">
    <h1 class="leftText"><?= $this->getHtml('ErrorMessage', '0', '0'); ?></h1>
    <img alt="500 error image" src="<?= UriFactory::build('{/base}/Web/E500/img/logo_error.png'); ?>">
    <p><?= $this->getHtml('Description', '0', '0'); ?></p>
</main>
<footer></footer>