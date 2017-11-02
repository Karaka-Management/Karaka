<!DOCTYPE HTML>
<html>
<head>
    <title>Error 500</title>
    <?= $this->getData('head')->renderAssets(); ?>
</head>
<body>
<header></header>
<main class="centerText">
    <h1 class="leftText"><?= $this->getHtml('ErrorMessage', 0, 0); ?></h1>
    <img src="<?= \phpOMS\Uri\UriFactory::build('{/base}/Web/E500/img/logo_error.png'); ?>">
    <p><?= $this->getHtml('Description', 0, 0); ?></p>
</main>
<footer></footer>