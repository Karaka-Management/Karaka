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

/** @var Web\Backend\BackendView $this */
$nav = $this->getData('nav');

$nav->setTemplate('/Modules/Navigation/Theme/Backend/top');
$top = $nav->render();

$nav->setTemplate('/Modules/Navigation/Theme/Backend/side');
$side = $nav->render();

/** @var phpOMS\Model\Html\Head $head */
$head = $this->getData('head');

/** @var array $dispatch */
$dispatch = $this->getData('dispatch') ?? [];
?>
<!DOCTYPE HTML>
<html lang="<?= $this->printHtml($this->response->getLanguage()); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#343a40">
    <meta name="msapplication-navbutton-color" content="#343a40">
    <meta name="apple-mobile-web-app-status-bar-style" content="#343a40">
    <meta name="description" content="<?= $this->getHtml(':meta', '0', '0'); ?>">
    <?= $head->meta->render(); ?>

    <base href="<?= UriFactory::build('{/base}'); ?>/">

    <link rel="manifest" href="<?= UriFactory::build('Web/Backend/manifest.json'); ?>">
    <link rel="manifest" href="<?= UriFactory::build('Web/Backend/manifest.webmanifest'); ?>">
    <link rel="shortcut icon" href="<?= UriFactory::build('Web/Backend/img/favicon.ico'); ?>" type="image/x-icon">

    <title><?= $this->printHtml($head->title); ?></title>

    <?= $head->renderAssets(); ?>

    <style><?= $head->renderStyle(); ?></style>
    <script><?= $head->renderScript(); ?></script>
</head>
<body>
<div class="vh" id="dim"></div>
    <input type="checkbox" id="nav-trigger" name="nav-hamburger" class="nav-trigger">
    <nav id="nav-side">
        <span id="u-box">
            <a href="<?= UriFactory::build('{/prefix}profile/single?{?}&id=' . $this->profile->getId()); ?>">
                <img alt="<?= $this->getHtml('User', '0', '0'); ?>" loading="lazy" src="<?= $this->getProfileImage(); ?>">
            </a>
            <span id="logo" itemscope itemtype="http://schema.org/Organization">
                <div>&nbsp;</div>
                <select
                    class="plain" id="unit-selector" name="unit"
                    data-action='[{"listener": "change", "action": [{"key": 1, "type": "redirect", "uri": "{%}&u={!#unit-selector}", "target": "self"}]}]'
                    title="Unit selector">
                    <?php foreach ($this->organizations as $organization) : ?>
                        <option value="<?= $this->printHtml((string) $organization->getId()); ?>"<?= $this->getData('orgId') == $organization->getId() ? ' selected' : ''; ?>><?= $this->printHtml($organization->name); ?>
                    <?php endforeach; ?>
                </select>
                <div id="nav-side-settings">
                    <input id="audio-output" type="checkbox">
                    <label for="audio-output"><i class="fa fa-volume-up"></i><i class="fa fa-volume-down"></i></label>

                    <input id="speech-recognition" type="checkbox">
                    <label for="speech-recognition"><i class="fa fa-microphone"></i>
                </div>
            </span>
            <label class="ham-trigger" for="nav-trigger"><i class="fa fa-bars p"></i></label>
        </span>
        <?= $side; ?>
    </nav>
    <main>
        <header>
            <form id="s-bar" method="GET" action="<?= UriFactory::build('{/api}search?{?}&app=Backend&csrf={$CSRF}'); ?>&search={!#iSearchBox}">
                <label class="ham-trigger" for="nav-trigger"><i class="fa fa-bars p"></i></label>
                <span role="search" class="inputWrapper">
                    <label id="iSearchType" for="iSearchType-check" class="dropdown search-type">
                        <div class="dropdown-closed">
                            <input id="iSearchType-e1" name="dropdown" type="radio" checked>
                            <label for="iSearchType-check"><i class="fa fa-map-marker"></i></label>

                            <input id="iSearchType-e2" name="dropdown" type="radio">
                            <label for="iSearchType-check"><i class="fa fa-globe"></i></label>
                        </div>
                        <input id="iSearchType-check" type="checkbox">
                        <div class="dropdown-container">
                            <div class="dropdown-search"></div>
                            <div class="dropdown-content">
                                <label for="iSearchType-e1"><i class="fa fa-map-marker"></i> Page</label>
                                <label for="iSearchType-e2"><i class="fa fa-globe"></i> Global</label>
                                <label for="iSearchType-check">Close</label>
                            </div>
                        </div>
                    </label>

                    <span class="textWrapper">
                        <input id="iSearchBox" name="search" type="text" autocomplete="off" autofocus>
                        <i class="frontIcon fa fa-search fa-lg fa-fw" aria-hidden="true"></i>
                        <i class="endIcon fa fa-times fa-lg fa-fw" aria-hidden="true"></i>
                    </span>
                    <input type="submit" id="iSearchButton" name="searchButton" value="<?= $this->getHtml('Search', '0', '0'); ?>">
                </span>
            </form>
            <div id="t-nav-container"><?= $top; ?></div>
        </header>

        <div id="content" class="container-fluid" role="main">
            <?php
            $c = 0;
            foreach ($dispatch as $view) {
                if (!($view instanceof \phpOMS\Views\NullView)
                    && $view instanceof \phpOMS\Contract\RenderableInterface
                ) {
                    ++$c;
                    echo $view->render();
                }
            }

            if ($c === 0) {
                echo '<div class="emptyPage"></div>';
            }
            ?>
        </div>
    </main>
<div id="app-message-container">
    <template id="app-message-tpl">
        <div class="log-msg">
            <h1 class="log-msg-title"></h1><i class="close fa fa-times"></i>
            <div class="log-msg-content"></div>
        </div>
    </template>
</div>

<template id="table-context-menu-tpl">
    <div id="table-context-menu" class="context-menu">
        <ul>
            <li class="context-line">
                <label class="checkbox" for="itable1-visibile-">
                    <input type="checkbox" id="itable1-visibile-" name="itable1-visible" checked>
                    <span class="checkmark"></span>
                </label>
            </li>
        </ul>
    </div>
</template>
<?= $head->renderAssetsLate(); ?>
