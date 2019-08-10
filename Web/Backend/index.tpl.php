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
 * @link       https://orange-management.org
 */
$nav = $this->getData('nav');

$nav->setTemplate('/Modules/Navigation/Theme/Backend/top');
$top = $nav->render();

$nav->setTemplate('/Modules/Navigation/Theme/Backend/side');
$side = $nav->render();

$head     = $this->getData('head');
$dispatch = $this->getData('dispatch') ?? [];
?>
<!DOCTYPE HTML>
<html lang="<?= $this->printHtml($this->response->getHeader()->getL11n()->getLanguage()); ?>">
<head>
    <?= $head->getMeta()->render(); ?>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#712b91">
    <meta name="msapplication-navbutton-color" content="#712b91">
    <meta name="apple-mobile-web-app-status-bar-style" content="#712b91">
    <meta name="description" content="<?= $this->getHtml(':meta', '0', '0'); ?>">
    <base href="<?= \phpOMS\Uri\UriFactory::build('{/base}'); ?>/">
    <link rel="manifest" href="<?= \phpOMS\Uri\UriFactory::build('Web/Backend/manifest.json'); ?>">
    <link rel="shortcut icon" href="<?= \phpOMS\Uri\UriFactory::build('Web/Backend/img/favicon.ico'); ?>" type="image/x-icon">
    <title><?= $this->printHtml($head->getTitle()); ?></title>
    <?= $head->renderAssets(); ?>
    <style><?= $head->renderStyle(); ?></style>
    <script><?= $head->renderScript(); ?></script>
</head>
<body>
<div class="vh" id="dim"></div>
    <input type="checkbox" id="nav-trigger" name="nav-hamburger" class="nav-trigger">
    <nav>
        <span id="u-box">
            <a href="<?= \phpOMS\Uri\UriFactory::build('{/prefix}profile/single?{?}&id=' . $this->request->getHeader()->getAccount()); ?>">
                <img alt="<?= $this->getHtml('User', '0', '0'); ?>" data-lazyload="<?= $this->getProfileImage(); ?>">
            </a>
            <span id="logo" itemscope itemtype="http://schema.org/Organization">
                <select
                    class="plain" id="unit-selector" name="unit"
                    data-action='[{"listener": "change", "action": [{"key": 1, "type": "redirect", "uri": "{%}&u={#unit-selector}", "target": "self"}]}]'
                    title="Unit selector">
                    <?php foreach ($this->organizations as $organization) : ?>
                        <option value="<?= $this->printHtml($organization->getId()); ?>"<?= $this->getData('orgId') == $organization->getId() ? ' selected' : ''; ?>><?= $this->printHtml($organization->getName()); ?>
                    <?php endforeach; ?>
                </select>
            </span>
            <label class="ham-trigger" for="nav-trigger"><i class="fa fa-bars p"></i></label>
        </span>
        <?= $side; ?>
    </nav>
    <main>
        <header>
            <form id="s-bar" method="GET" action="<?= \phpOMS\Uri\UriFactory::build('{/api}search?{?}&csrf={$CSRF}'); ?>&search={#iSearchBox}">
                <label class="ham-trigger" for="nav-trigger"><i class="fa fa-bars p"></i></label>
                <span role="search" class="inputWrapper">
                    <span class="textWrapper">
                        <input id="iSearchBox" name="search" type="text" autofocus="autofocus">
                        <i class="frontIcon fa fa-search fa-lg fa-fw" aria-hidden="true"></i>
                        <i class="endIcon fa fa-times fa-lg fa-fw" aria-hidden="true"></i>
                    </span>
                    <input type="submit" id="iSearchButton" name="searchButton" value="<?= $this->getHtml('Search', '0', '0'); ?>">
                </span>
            </form>
            <div id="t-nav-container"><?= $top ?></div>
        </header>

        <div id="content" class="container-fluid" role="main">
            <?php
            foreach ($dispatch as $view) {
                if ($view instanceof \phpOMS\Contract\RenderableInterface) {
                    echo $view->render();
                }
            }
            ?>

            <template id="table-filter-tpl">
                <div id="table-filter">some table filter</div>
            </template>
        </div>
    </main>
<div id="app-message-container" style="position: absolute; margin: 0 auto; right: 0; top: 0; padding: 85px 10px 0 0;">
    <template id="app-message-tpl">
        <div class="log-msg" style="z-index: 11; position: relative; margin: 0 auto; right: 0; top: 0; margin-bottom: 10px;">
            <h1 class="log-msg-title"></h1>
            <div class="log-msg-content"></div>
        </div>
    </template>
</div>
<?= $head->renderAssetsLate(); ?>
