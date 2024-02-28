<?php
/**
 * Jingga
 *
 * PHP Version 8.1
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
<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#343a40">
    <meta name="msapplication-navbutton-color" content="#343a40">
    <meta name="apple-mobile-web-app-status-bar-style" content="#343a40">

    <base href="/">

    <title>Error 500</title>

    <?= $this->head->renderAssets(); ?>
</head>
<body>
<main class="container-fluid">
    <div class="row">
        <div class="col-xs-12">
            <section class="portlet">
                <div class="portlet-body cT">
                    <div><?= $this->getHtml('ErrorMessage', '0', '0'); ?></div>
                    <img alt="500 error image" style="margin: 1rem; max-height: 90%; max-width: 90%;" src="<?= UriFactory::build('Web/E500/img/server_error.svg'); ?>">
                    <div><?= $this->getHtml('Description', '0', '0'); ?></div>
                </div>
            </section>
        </div>
    </div>
</main>
