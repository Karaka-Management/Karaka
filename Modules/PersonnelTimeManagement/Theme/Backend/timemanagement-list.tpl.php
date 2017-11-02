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
 * @var \phpOMS\Views\View $this
 */

/*
 * UI Logic
 */
$timeMgmtView = new \Web\Views\Lists\ListView($this->app, $this->request, $this->response);
$headerView   = new \Web\Views\Lists\HeaderView($this->app, $this->request, $this->response);

$timeMgmtView->setTemplate('/Web/Templates/Lists/ListFull');
$headerView->setTemplate('/Web/Templates/Lists/Header/HeaderTable');

/*
 * Header
 */
$headerView->setTitle($this->getHtml('TimeManagement'));
$headerView->setHeader([
    ['title' => '', 'sortable' => false],
    ['title' => $this->getHtml('ID'), 'sortable' => true],
    ['title' => $this->getHtml('Type'), 'sortable' => true],
    ['title' => $this->getHtml('Name'), 'sortable' => true, 'full' => true],
    ['title' => $this->getHtml('Working'), 'sortable' => true],
    ['title' => $this->getHtml('Vacation'), 'sortable' => true],
    ['title' => $this->getHtml('Sick'), 'sortable' => true],
    ['title' => $this->getHtml('Other'), 'sortable' => true],
]);
$timeMgmtView->addView('header', $headerView);

/*
 * Settings
 */
/**
 * @var \phpOMS\Views\View $this
 */
$panelSettingsView = new \Web\Views\Panel\PanelView($this->app, $this->request, $this->response);
$panelSettingsView->setTemplate('/Web/Templates/Panel/BoxFull');
$panelSettingsView->setTitle($this->getHtml('Settings'));
$this->addView('settings', $panelSettingsView);

$settingsFormView = new \Web\Views\Form\FormView($this->app, $this->request, $this->response);
$settingsFormView->setTemplate('/Web/Templates/Forms/FormFull');
$settingsFormView->setHasSubmit(false);
$settingsFormView->setOnChange(true);
$settingsFormView->setAction($this->request->getUri()->getScheme() . '://' . $this->request->getUri()->getHost());
$settingsFormView->setMethod(\phpOMS\Message\Http\RequestMethod::POST);

$settingsFormView->setElement(0, 0, [
    'type'    => \phpOMS\Html\TagType::SELECT,
    'options' => [
        ['value' => 0, 'content' => $this->getHtml('All')],
        ['value' => 1, 'content' => $this->getHtml('Day')],
        ['value' => 2, 'content' => $this->getHtml('Week')],
        ['value' => 3, 'content' => $this->getHtml('Month'), 'selected' => true],
        ['value' => 4, 'content' => $this->getHtml('Year')],
    ],
    'label'   => $this->getHtml('Interval'),
    'name'    => 'interval',
]);

$this->getView('settings')->addView('form', $settingsFormView);

/*
 * Statistics
 */
$panelStatView = new \Web\Views\Panel\PanelView($this->app, $this->request, $this->response);
$panelStatView->setTemplate('/Web/Templates/Panel/BoxFull');
$panelStatView->setTitle($this->getHtml('General'));
$this->addView('stats', $panelStatView);

$statTableView = new \Web\Views\Lists\ListView($this->app, $this->request, $this->response);
$statTableView->setTemplate('/Web/Templates/Lists/AssocList');
$statTableView->setElements([
    [$this->getHtml('Working'), '136'],
    [$this->getHtml('Late'), '3'],
    [$this->getHtml('Vacation'), '5'],
    [$this->getHtml('Sick'), '1'],
    [$this->getHtml('Travel'), '17'],
    [$this->getHtml('Remote'), '2'],
    [$this->getHtml('Off'), '0'],
    [$this->getHtml('Other'), '0'],
]);

$this->getView('stats')->addView('stat::table', $statTableView);

/*
 * Navigation
 */
$nav = new \Modules\Navigation\Views\NavigationView($this->app, $this->request, $this->response);
$nav->setTemplate('/Modules/Navigation/Theme/Backend/mid');
$nav->setNav($this->getData('nav'));
$nav->setLanguage($this->l11n->language);
$nav->setParent(1003501001);
?>
<?= $this->printHtml($nav->render()); ?>

<div class="b-7" id="i3-2-1">
    <?= $this->printHtml($this->getView('settings')->render()); ?>

    <?= $this->printHtml($this->getView('stats')->render()); ?>
</div>
<div class="b-6">
    <?= $this->printHtml($timeMgmtView->render()); ?>
</div>
