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

$head = $this->head;
?>
<!DOCTYPE HTML>
<html lang="<?= $this->printHtml($this->response->header->l11n->language); ?>">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8">
    <base href="/">
    <meta name="theme-color" content="#343a40">
    <meta name="msapplication-navbutton-color" content="#343a40">
    <meta name="theme-color" content="#343a40">
    <link rel="icon" type="image/png" sizes="512x512" href="Web/Backend/img/icon-512x512.png">
    <link rel="icon" type="image/png" sizes="128x128" href="Web/Backend/img/icon-128x128.png">
    <link rel="icon" type="image/png" sizes="32x32" href="Web/Backend/img/icon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="Web/Backend/img/icon-16x16.png">
    <meta name="description" content="<?= $this->getHtml(':meta', '0', '0'); ?>">
    <link rel="manifest" href="<?= UriFactory::build('Web/Backend/manifest.json'); ?>">
    <link rel="manifest" href="<?= UriFactory::build('Web/Backend/manifest.webmanifest'); ?>">
    <link rel="shortcut icon" href="<?= UriFactory::build('Web/Backend/img/favicon.ico'); ?>" type="image/x-icon">
    <?= $head->meta->render(); ?>
    <title><?= $this->printHtml($head->title); ?></title>
    <style><?= $head->renderStyle(); ?></style>
    <script><?= $head->renderScript(); ?></script>
    <?= $head->renderAssets(); ?>
</head>
<body>