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
 * @link       http://website.orange-management.de
 */
$head = $this->getData('head');
?>
<!DOCTYPE HTML>
<html lang="<?= $this->printHtml($this->response->getHeader()->getL11n()->getLanguage()); ?>">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8">
    <link rel="manifest" href="<?= \phpOMS\Uri\UriFactory::build('{/base}/Web/Backend/manifest.json'); ?>">
    <?= $head->getMeta()->render(); ?>
    <title><?= $this->printHtml($head->getTitle()); ?></title>
    <?= $head->renderAssets(); ?>
    <style><?= $head->renderStyle(); ?></style>
    <script><?= $head->renderScript(); ?></script>
    <style type="text/css">
        html, body {
            height: 100%;
            font-family: arial, serif;
            background: #2F2F2F;
            color: #fff;
        }

        form label {
            color: #fff;
            text-shadow: none;
        }

        .floater {
            float: left;
            width: 100%;
        }

        #parent {
            display: table;
            position: static;
            clear: left;
            margin: 0 auto;
            width: 100%;
        }

        #child {
            display: table-cell;
            vertical-align: middle;
            width: 100%;
            margin: 0 auto;
            text-align: center;
            position: relative;
            font-size: 1.0em;
            padding: 20px;
            background: #232323;
            box-shadow: 0 0 5px 1px rgba(0,0,0,0.75);
        }

        #inner {
            text-align: left;
            margin: 0 auto;
            display: inline-block;
        }

        #title {
            text-align: center;
            font-size: 10em;
            padding-bottom: 20px;
        }

        h1 {
            margin-bottom: 30px;
        }

        #bg-animation {
            background: none;
            border: none;
            position: absolute;
        }
    </style>
</head>
<body>
<canvas id="bg-animation"></canvas>
<div class="floater"></div>
<div id="parent">
    <div id="child">
        <div id="inner">
            <header><h1>Orange Management</h1></header>
            <div class="floatLeft">
                <img alt="Logo" src="<?= \phpOMS\Uri\UriFactory::build('{/base}/Web/Backend/img/logo.png'); ?>" width="200">
            </div>
            <div class="floatLeft" style="padding: 30px 0 0 50px">
                <form id="login" method="POST" action="<?= \phpOMS\Uri\UriFactory::build('{/base}/{/lang}/api/login?{?}&csrf={$CSRF}'); ?>">
                    <table class="layout">
                        <tr><td><label for="iName"><?= $this->getHtml('Username', 0, 0); ?></label>
                        <tr><td><input id="iName" type="text" name="user" value="admin">
                        <tr><td><label for="iPassword"><?= $this->getHtml('Password', 0, 0); ?></label>
                        <tr><td><input id="iPassword" type="password" name="pass" value="orange">
                        <tr><td><input type="submit" value="<?= $this->getHtml('Login', 0, 0); ?>">
                    </table>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $head->renderAssetsLate(); ?>
