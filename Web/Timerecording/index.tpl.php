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
declare(strict_types=1);

$nav = $this->getData('nav');

$nav->setTemplate('/Modules/Navigation/Theme/Backend/top');
$top = $nav->render();

/** @var phpOMS\Model\Html\Head $head */
$head = $this->getData('head');

/** @var array $dispatch */
$dispatch = $this->getData('dispatch') ?? [];
?>
<!DOCTYPE HTML>
<html lang="<?= $this->printHtml($this->response->getHeader()->getL11n()->getLanguage()); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#712b91">
    <meta name="msapplication-navbutton-color" content="#712b91">
    <meta name="apple-mobile-web-app-status-bar-style" content="#712b91">
    <meta name="description" content="<?= $this->getHtml(':meta', '0', '0'); ?>">
    <?= $head->getMeta()->render(); ?>

    <base href="<?= \phpOMS\Uri\UriFactory::build('{/base}'); ?>/">

    <link rel="manifest" href="<?= \phpOMS\Uri\UriFactory::build('Web/Timerecording/manifest.json'); ?>">
    <link rel="shortcut icon" href="<?= \phpOMS\Uri\UriFactory::build('Web/Timerecording/img/favicon.ico'); ?>" type="image/x-icon">

    <title><?= $this->printHtml($head->getTitle()); ?></title>

    <?= $head->renderAssets(); ?>

    <style><?= $head->renderStyle(); ?></style>
    <script><?= $head->renderScript(); ?></script>
</head>
<body>
<div class="vh" id="dim"></div>
<header><div id="t-nav-container"><?= $top ?></div></header>
<main id="content" class="container-fluid" role="main">
<?php
foreach ($dispatch as $view) {
    if ($view instanceof \phpOMS\Contract\RenderableInterface) {
        echo $view->render();
    }
}
?>
</main>
<div id="app-message-container">
    <template id="app-message-tpl">
        <div class="log-msg">
            <h1 class="log-msg-title"></h1>
            <div class="log-msg-content"></div>
        </div>
    </template>
</div>
<?= $head->renderAssetsLate(); ?>