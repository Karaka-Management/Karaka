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
$loginForm = new \Web\Views\Form\FormView($this->app, $this->request, $this->response);
$loginForm->setTemplate('/Web/Templates/Forms/FormFull');
$loginForm->setSubmit('submit1', $this->l11n->getHtml(0, 'Backend', 'Login'));
$loginForm->setAction($this->request->getUri()->getScheme() . '://' . $this->request->getUri()->getHost() . '/' . $this->l11n->getLanguage() . '/api/login.php');
$loginForm->setMethod(\phpOMS\Message\Http\RequestMethod::POST);

$loginForm->setElement(0, 0, [
    'type'      => \phpOMS\Html\TagType::INPUT,
    'subtype'   => 'text',
    'name'      => 'user',
    'tabindex'  => 0,
    'autofocus' => true,
    'label'     => $this->l11n->getHtml(0, 'Backend', 'Username'),
]);

$loginForm->setElement(1, 0, [
    'type'     => \phpOMS\Html\TagType::INPUT,
    'subtype'  => 'password',
    'name'     => 'pass',
    'tabindex' => 0,
    'label'    => $this->l11n->getHtml(0, 'Backend', 'Password'),
]);

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
    <style type="text/css">
        html, body {
            height: 100%;
            padding: 0;
            margin: 0 auto;
            font-family: arial, serif;
            background: #d9392d;
            color: #fff;
        }

        html, body, div {
            margin: 0;
            padding: 0;
        }

        li {
            list-style-type: none;
        }

        input {
            margin-bottom: 5px;
        }

        .floater {
            float: left;
            height: 50%;
            width: 100%;
            margin-bottom: -130px;
        }

        #parent {
            display: table;
            position: static;
            clear: left;
            height: 230px;
            width: 270px;
            margin: 0 auto;
        }

        #child {
            display: table-cell;
            vertical-align: middle;
            width: 100%;
            position: relative;
            font-size: 1.0em;
        }

        #title {
            text-align: center;
            font-size: 10em;
            padding-bottom: 20px;
        }

        #content {
        }
    </style>
</head>
<body>
<div class="floater"></div>
<div id="parent">
    <div id="child">
        <?= $this->printHtml($loginForm->render()); ?>
    </div>
</div>
</body>
</html>
