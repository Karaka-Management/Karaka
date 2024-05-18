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

use phpOMS\Application\ApplicationStatus;
use phpOMS\Uri\UriFactory;

/** @var Web\Backend\BackendView $this */
$nav = $this->data['nav'];

$nav->setTemplate('/Modules/Navigation/Theme/Backend/top');
$top = $nav->render();

$nav->setTemplate('/Modules/Navigation/Theme/Backend/side');
$side = $nav->render();

/** @var phpOMS\Model\Html\Head $head */
$head = $this->head;

/** @var array $dispatch */
$dispatch = $this->data['dispatch'] ?? [];
?>
<!DOCTYPE HTML>
<html lang="<?= $this->printHtml($this->response->header->l11n->language); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#343a40">
    <meta name="msapplication-navbutton-color" content="#343a40">
    <meta name="apple-mobile-web-app-status-bar-style" content="#343a40">
    <link rel="icon" type="image/png" sizes="512x512" href="Web/Backend/img/icon-512x512.png">
    <link rel="icon" type="image/png" sizes="128x128" href="Web/Backend/img/icon-128x128.png">
    <link rel="icon" type="image/png" sizes="32x32" href="Web/Backend/img/icon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="Web/Backend/img/icon-16x16.png">
    <meta name="description" content="<?= $this->getHtml(':meta', '0', '0'); ?>">
    <?= $head->meta->render(); ?>

    <base href="/">

    <link rel="manifest" href="<?= UriFactory::build('Web/Backend/manifest.json'); ?>">
    <link rel="manifest" href="<?= UriFactory::build('Web/Backend/manifest.webmanifest'); ?>">
    <link rel="shortcut icon" href="<?= UriFactory::build('Web/Backend/img/favicon.ico?v=1.0.0'); ?>" type="image/x-icon">

    <title><?= $this->printHtml($head->title); ?></title>

    <?= $head->renderAssets(); ?>

    <style><?= $head->renderStyle(); ?></style>
    <script><?= $head->renderScript(); ?></script>
</head>
<body>
<div class="vh" id="dim"></div>
<input id="hover-preview-checkbox" class="vh" type="checkbox">
<div class="checked-visibility" id="hover-preview"></div>
<?php
    if ($this->data['appStatus'] === ApplicationStatus::READ_ONLY
        || $this->data['appStatus'] === ApplicationStatus::DISABLED
    ) :
?>
    <div id="stickyMessage warning">The application is currently in maintenance mode, you cannot make any changes.</div>
<?php endif; ?>
<input type="checkbox" id="nav-trigger" name="nav-hamburger" class="nav-trigger">
<nav id="nav-side">
    <span id="u-box">
        <a href="<?= UriFactory::build('{/base}/profile/view?{?}&id=' . $this->profile->id); ?>">
            <img alt="<?= $this->getHtml('User', '0', '0'); ?>" loading="lazy" src="<?= $this->getProfileImage(); ?>">
        </a>
        <span id="logo" itemscope itemtype="http://schema.org/Organization">
            <div>&nbsp;</div>
            <select
                class="plain" id="unit-selector" name="unit"
                data-action='[{"listener": "change", "action": [{"key": 1, "type": "redirect", "uri": "{%}&u={!#unit-selector}", "target": "self"}]}]'
                title="Unit selector">
                <?php foreach ($this->organizations as $organization) : ?>
                    <option value="<?= $organization->id; ?>"<?= $this->data['unitId'] == $organization->id ? ' selected' : ''; ?>><?= $this->printHtml($organization->name); ?>
                <?php endforeach; ?>
            </select>
            <div id="nav-side-settings">
                <input id="audio-output" type="checkbox">
                <label for="audio-output"><i class="g-icon volume_up">volume_up</i><i class="g-icon volume_down">volume_down</i></label>

                <input id="speech-recognition" type="checkbox">
                <label for="speech-recognition"><i class="g-icon">mic</i>
            </div>
        </span>
        <label class="ham-trigger" for="nav-trigger"><i class="g-icon p">menu</i></label>
    </span>
    <?= $side; ?>
</nav>
<main>
    <header>
        <form id="s-bar" method="GET" action="<?= UriFactory::build('{/base}/search?{?}&app=Backend&csrf={$CSRF}'); ?>">
            <label class="ham-trigger" for="nav-trigger"><i class="g-icon p">menu</i></label>
            <span role="search" class="inputWrapper">
                <span class="txtWrap">
                    <input id="iSearchBox" name="search" type="text" autocomplete="off" value="<?= $this->request->getDataString('search') ?? ''; ?>" autofocus>
                    <i class="frontIco g-icon" aria-hidden="true">search</i>
                    <i class="endIco g-icon" aria-hidden="true">close</i>
                </span>
                <a class="button" href="<?= UriFactory::build('{/base}/search?{?}&app=Backend&csrf={$CSRF}'); ?>&search={#iSearchBox}"><?= $this->getHtml('Search', '0', '0'); ?></a>
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
                $render = $view->render();
                if ($render === '') {
                    continue;
                }

                echo $render;
                ++$c;
            }
        }

        if ($c === 0) {
            include __DIR__ . '/Error/404.tpl.php';
        }
        ?>
    </div>
</main>
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

<template id="table-ctx-menu-tpl">
    <div id="table-ctx-menu" class="ctx-menu">
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
