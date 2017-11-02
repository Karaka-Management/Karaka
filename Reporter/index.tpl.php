<?php
/**
 * Orange Management
 *
 * PHP Version 7.1
 *
 * @category   TBD
 * @package    TBD
 * @copyright  Dennis Eichhorn
 * @license    OMS License 1.0
 * @version    1.0.0
 * @link       http://orange-management.com
 */
/**
 * @var \Web\Views\Page\GenericView $this
 */
$nav = new \Modules\Navigation\Views\NavigationView($this->app, $this->request, $this->response);
$nav->setTemplate('/Modules/Navigation/Theme/Backend/top');
$nav->setNav($this->getData('nav'));
$nav->setLanguage($this->l11n->language);
$top  = $nav->render();
$head = $this->response->getHead();
?>
<!DOCTYPE HTML>
<html>
<head>
    <?= $this->printHtml($head->getMeta()->render()); ?>
    <title><?= $this->printHtml($a = $head->getTitle()); ?></title>
    <?= $this->printHtml($head->renderAssets()); ?>
    <style>
        <?= $this->printHtml($head->renderStyle()); ?>
    </style>
    <script>
        <?= $this->printHtml($head->renderScript()); ?>
    </script>
</head>
<body>
<div class="vh" id="dim"></div>
<div id="h">
    <div id="bar-s">
        <?= $this->printHtml($top); ?>
    </div>
    <div id="bar-b">
        <span class="vC" id="logo" itemscope itemtype="http://schema.org/Organization"><a
                href="<?= \phpOMS\Uri\UriFactory::build('/{/lang}/reporter'); ?>"
                itemprop="legalName"><?= $this->printHtml($this->getData('Name')); ?></a>
        </span>
        <span class="vC" id="s-bar" role="search">
            <label> <input type="text" autofocus="autofocus"> </label>
            <input type="submit" value="<?= $this->printHtml($this->l11n->getHtml(0, 'Backend', 'Search')); ?>">
        </span>
        <span class="vC" id="u-box">
            <img class="rf" src="<?= $this->printHtml('/Web/Backend/img/default-user.jpg'); ?>">
        </span>

        <div id="u-logo" itemscope itemtype="http://schema.org/Person"></div>
    </div>
</div>
<div id="out">
    <div id="cont" role="main">
        <?= $this->printHtml($this->app->moduleManager->get('Content')->call($this->request, $this->response)); ?>
    </div>
</div>
