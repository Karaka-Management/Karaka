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
$nav = $this->getData('nav');

$nav->setTemplate('/Modules/Navigation/Theme/Backend/top');
$top = $nav->render();

$nav->setTemplate('/Modules/Navigation/Theme/Backend/side');
$side = $nav->render();

$head = $this->getData('head');
$dispatch = $this->getData('dispatch') ?? [];
?>
<!DOCTYPE HTML>
<html lang="<?= $this->printHtml($this->response->getHeader()->getL11n()->getLanguage()); ?>">
<head>
    <?= $head->getMeta()->render(); ?>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#2f2f2f">
    <meta name="msapplication-navbutton-color" content="#2f2f2f">
    <meta name="apple-mobile-web-app-status-bar-style" content="#2f2f2f">
    <base href="<?= \phpOMS\Uri\UriFactory::build('{/base}'); ?>">
    <link rel="manifest" href="<?= \phpOMS\Uri\UriFactory::build('/Web/Backend/manifest.json'); ?>">
    <link rel="shortcut icon" href="<?= \phpOMS\Uri\UriFactory::build('/Web/Backend/img/favicon.ico'); ?>" type="image/x-icon">
    <title><?= $this->printHtml($head->getTitle()); ?></title>
    <?= $head->renderAssets(); ?>
    <style><?= $head->renderStyle(); ?></style>
    <script><?= $head->renderScript(); ?></script>
</head>
<body>
<div class="vh" id="dim"></div>
<header>
    <div id="bar-s"><?= $top ?></div>
    <div id="bar-b">
        <span class="vC" id="ham-trigger">
            <label for="nav-trigger"><i class="fa fa-bars"></i></label>
        </span>
        <span class="vC" id="logo" itemscope itemtype="http://schema.org/Organization">
            <select class="plain" id="unit-selector" name="unit" data-action='[{"listener": "change", "action": [{"key": 1, "type": "redirect", "uri": "{%}&u={#unit-selector}", "target": "self"}]}]' title="Unit selector">
                <?php foreach ($this->organizations as $organization) : ?>
                <option value="<?= $this->printHtml($organization->getId()); ?>"<?= $this->request->getData('u') == $organization->getId() ? ' selected' : ''; ?>><?= $this->printHtml($organization->getName()); ?>
                <?php endforeach; ?>
            </select>
        </span>
        <span class="vC" id="s-bar" role="search">
            <span> <input id="iSearchBox" name="search" type="text" autofocus="autofocus"> </span>
            <input type="submit" id="iSearchButton" name="searchButton" value="<?= $this->getHtml('Search', 0, 0); ?>">
        </span>
        <span class="vC" id="u-box">
            <a href="<?= \phpOMS\Uri\UriFactory::build('/{/lang}/backend/profile/single?{?}&id=' . $this->request->getHeader()->getAccount()); ?>">
                <span><?= $this->printHtml($this->profile->getAccount()->getName1()); ?></span>
                <img alt="<?= $this->getHtml('AccountImage', 0, 0); ?>" data-lazyload="<?= $this->getProfileImage(); ?>">
            </a>
        </span>
    </div>
</header>
<div id="out">
    <?= $side; ?>
    <input type="checkbox" id="nav-trigger" class="nav-trigger" checked>
    <main class="container-fluid">
        <?php
        foreach ($dispatch as $view) {
            if ($view instanceOf \Serializable) {
                echo $view->render();
            }
        }
        ?>
        <div id="app-message-container" style="position: absolute; margin: 0 auto; right: 1%; top: 1%;">
            <template id="app-message">
                <div class="log-msg" style="z-index: 11; position: relative; margin: 0 auto; right: 0; top: 0; margin-bottom: 10px;">
                    <h1 class="log-msg-title"></h1>
                    <div class="log-msg-content"></div>
                </div>
            </template>
        </div>
    </main>
</div>
<?= $head->renderAssetsLate(); ?>
