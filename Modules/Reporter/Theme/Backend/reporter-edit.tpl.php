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
$tabView = new \Web\Views\Divider\TabularView($this->app, $this->request, $this->response);
$tabView->setTemplate('/Web/Templates/Divider/Tabular');

echo $this->getData('nav')->render(); ?>

<div class="b-7" id="i3-2-1">
    <div class="b b-5 c3-2 c3" id="i3-2-5">
        <div class="bc-1">
            <ul class="l-1">
                <li>
                    <a href="<?= \phpOMS\Uri\UriFactory::build('{/base}/{/lang}/backend/reporter/single?{?}&id=' . $this->getData('name')); ?>"
                       class="button"><?= $this->getHtml('Report') ?></a>
            </ul>
        </div>
    </div>
</div>
<div class="b-6">
    <?php
    /**
     * @var \phpOMS\Views\View $this
     */
    $overviwPanel    = new \Web\Views\Panel\PanelView($this->app, $this->request, $this->response);
    $permissionPanel = clone $overviwPanel;

    $overviwPanel->setTitle($this->getHtml('Create'));
    $permissionPanel->setTitle($this->getHtml('Permission'));

    $this->addView('createFormPanel', $overviwPanel);
    $this->getView('createFormPanel')->setTemplate('/Web/Templates/Panel/BoxHalf');

    $this->addView('permissionFormPanel', $permissionPanel);
    $this->getView('permissionFormPanel')->setTemplate('/Web/Templates/Panel/BoxHalf');

    /*
     * Overview
     */

    $formOverview = new \Web\Views\Form\FormView($this->app, $this->request, $this->response);
    $formOverview->setTemplate('/Web/Templates/Forms/FormFull');
    $formOverview->setSubmit('submit1', $this->getHtml('Edit'));
    $formOverview->setSubmit('submit2', $this->getHtml('Delete'));
    $formOverview->setAction($this->request->getUri()->getScheme() . '://' . $this->request->getUri()->getHost());
    $formOverview->setMethod(\phpOMS\Message\Http\RequestMethod::POST);

    $formOverview->setElement(0, 0, [
        'type'    => \phpOMS\Html\TagType::INPUT,
        'subtype' => 'text',
        'name'    => 'rname',
        'label'   => $this->getHtml('Name'),
    ]);

    $formOverview->setElement(1, 0, [
        'type'    => \phpOMS\Html\TagType::INPUT,
        'subtype' => 'text',
        'name'    => 'mdirectory',
        'label'   => $this->getHtml('MediaDirectory'),
        'active'  => false,
    ]);

    $formOverview->setElement(1, 1, [
        'type'    => \phpOMS\Html\TagType::BUTTON,
        'content' => $this->getHtml('Select'),
    ]);

    $formOverview->setElement(2, 0, [
        'type'    => \phpOMS\Html\TagType::INPUT,
        'subtype' => 'text',
        'name'    => 'template',
        'label'   => $this->getHtml('Template'),
        'active'  => false,
    ]);

    $formOverview->setElement(2, 1, [
        'type'    => \phpOMS\Html\TagType::BUTTON,
        'content' => $this->getHtml('Select'),
    ]);

    $this->getView('createFormPanel')->addView('form', $formOverview);

    /*
     * Permission Add
     */

    $formPermissionAdd = new \Web\Views\Form\FormView($this->app, $this->request, $this->response);
    $formPermissionAdd->setTemplate('/Web/Templates/Forms/FormFull');
    $formPermissionAdd->setSubmit('submit1', $this->getHtml('Add', 0, 0));
    $formPermissionAdd->setAction($this->request->getUri()->getScheme() . '://' . $this->request->getUri()->getHost());
    $formPermissionAdd->setMethod(\phpOMS\Message\Http\RequestMethod::POST);

    $formPermissionAdd->setElement(0, 0, [
        'type'     => \phpOMS\Html\TagType::SELECT,
        'options'  => [
            [
                'value'   => 0,
                'content' => 'Group',
            ],
            [
                'value'   => 1,
                'content' => 'Account',
            ],
        ],
        'selected' => '',
        'label'    => $this->getHtml('Type'),
        'name'     => 'type',
    ]);

    $formPermissionAdd->setElement(1, 0, [
        'type'    => \phpOMS\Html\TagType::INPUT,
        'subtype' => 'text',
        'name'    => 'id',
        'label'   => $this->getHtml('ID'),
    ]);

    $formPermissionAdd->setElement(2, 0, [
        'type'    => \phpOMS\Html\TagType::INPUT,
        'subtype' => 'text',
        'name'    => 'perm',
        'label'   => $this->getHtml('Permission'),
    ]);

    $this->getView('permissionFormPanel')->addView('form', $formPermissionAdd);

    /*
     * Permission List
     */
    $permissionListView = new \Web\Views\Lists\ListView($this->app, $this->request, $this->response);
    $headerView         = new \Web\Views\Lists\HeaderView($this->app, $this->request, $this->response);

    $permissionListView->setTemplate('/Web/Templates/Lists/ListFull');
    $headerView->setTemplate('/Web/Templates/Lists/Header/HeaderTable');

    /*
     * Header
     */
    $headerView->setTitle($this->getHtml('Permission'));
    $headerView->setHeader([
        ['title' => $this->getHtml('Type'), 'sortable' => true],
        ['title' => $this->getHtml('Name'), 'sortable' => true, 'full' => true],
        ['title' => $this->getHtml('Permission'), 'sortable' => true],
    ]);

    $permissionListView->addView('header', $headerView);
    $this->addView('permissionList', $permissionListView);

    $tabView->addTab($this->getHtml('Overview'), $overviwPanel->render() . $permissionPanel->render() . $permissionListView->render(), 'Backend', 'overview');

    /*
 * UI Logic
 */
    $sourceList           = new \Web\Views\Lists\ListView($this->app, $this->request, $this->response);
    $sourceListHeaderView = new \Web\Views\Lists\HeaderView($this->app, $this->request, $this->response);

    $sourceList->setTemplate('/Web/Templates/Lists/ListFull');
    $sourceListHeaderView->setTemplate('/Web/Templates/Lists/Header/HeaderTable');

    /*
     * Header
     */
    $sourceListHeaderView->setTitle($this->getHtml('Sources'));
    $sourceListHeaderView->setHeader([
        ['title' => $this->getHtml('ID'), 'sortable' => true],
        ['title' => $this->getHtml('Name'), 'sortable' => true, 'full' => true],
        ['title' => $this->getHtml('Created'), 'sortable' => true],
        ['title' => $this->getHtml('CreatedBy'), 'sortable' => true],
    ]);

    $sourceList->setFreeze(3, 2);
    $sourceList->addView('header', $sourceListHeaderView);

    $tabView->addTab($this->getHtml('Reporter', 'Sources'), $sourceList->render(), 'Backend', 'sources');

    /*
     * Create
     */
    $createPanel = new \Web\Views\Panel\PanelView($this->app, $this->request, $this->response);
    $mediaPanel  = clone $createPanel;

    $createPanel->setTitle($this->getHtml('Create'));
    $mediaPanel->setTitle($this->getHtml('Media'));

    $this->addView('createFormPanel', $createPanel);
    $this->getView('createFormPanel')->setTemplate('/Web/Templates/Panel/BoxHalf');

    $this->addView('permissionFormPanel', $mediaPanel);
    $this->getView('permissionFormPanel')->setTemplate('/Web/Templates/Panel/BoxHalf');

    $formCreateForm = new \Web\Views\Form\FormView($this->app, $this->request, $this->response);
    $formCreateForm->setTemplate('/Web/Templates/Forms/FormFull');
    $formCreateForm->setSubmit('submit1', $this->getHtml('Submit'));
    $formCreateForm->setAction($this->request->getUri()->getScheme() . '://' . $this->request->getUri()->getHost());
    $formCreateForm->setMethod(\phpOMS\Message\Http\RequestMethod::POST);

    $formCreateForm->setElement(0, 0, [
        'type'    => \phpOMS\Html\TagType::INPUT,
        'subtype' => 'text',
        'name'    => 'rname',
        'label'   => $this->getHtml('Name'),
    ]);

    $createPanel->addView('createform', $formCreateForm);

    /*
     * Media Add
     */

    // TODO: add media upload drop panel

    $tabView->addTab($this->getHtml('Reporter', 'New'), $createPanel->render() . $mediaPanel->render(), 'Backend', 'new');
    ?>
    <?= $this->printHtml($tabView->render()); ?>
</div>

<script>
    jsOMS.ready(function () {
        assetManager.load(Url + '/Modules/Media/JS', 'MediaUpload.js', 'js');
    });
</script>
