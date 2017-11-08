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
/**
 * @var \phpOMS\Views\View $this
 */

echo $this->getData('nav')->render(); ?>

<div class="row">
    <div class="col-xs-12 col-sm-6 col-lg-3">
        <section class="box wf-100">
            <header><h1>Line Chart</h1></header>
            <div class="inner">
                <a href="<?= \phpOMS\Uri\UriFactory::build('/{/lang}/backend/chart/create/line'); ?>" class="wf-100 centerText" style="background: #fff; display: inline-block">
                    <img src="<?= \phpOMS\Uri\UriFactory::build('/Modules/Chart/Img/thumb-line-chart.png'); ?>">
                </a>
            </div>
        </section>

        <section class="box wf-100">
            <header><h1>Area Chart</h1></header>
            <div class="inner">
                <a href="<?= \phpOMS\Uri\UriFactory::build('/{/lang}/backend/chart/create/area'); ?>" class="wf-100 centerText" style="background: #fff; display: inline-block">
                    <img src="<?= \phpOMS\Uri\UriFactory::build('/Modules/Chart/Img/thumb-area-chart.png'); ?>">
                </a>
            </div>
        </section>

        <section class="box wf-100">
            <header><h1>Stacked Area Chart</h1></header>
            <div class="inner">
                <a href="#" class="wf-100 centerText" style="background: #fff; display: inline-block">
                    <img src="<?= \phpOMS\Uri\UriFactory::build('/Modules/Chart/Img/chart-thumb.png'); ?>">
                </a>
            </div>
        </section>

        <section class="box wf-100">
            <header><h1>Grouped Column Chart</h1></header>
            <div class="inner">
                <a href="<?= \phpOMS\Uri\UriFactory::build('/{/lang}/backend/chart/create/column?{?}&subtype=grouped'); ?>" class="wf-100 centerText" style="background: #fff; display: inline-block">
                    <img src="<?= \phpOMS\Uri\UriFactory::build('/Modules/Chart/Img/thumb-grouped-column-chart.png'); ?>">
                </a>
            </div>
        </section>
    </div>

    <div class="col-xs-12 col-sm-6 col-lg-3">
        <section class="box wf-100">
            <header><h1>Stacked Column Chart</h1></header>
            <div class="inner">
                <a href="<?= \phpOMS\Uri\UriFactory::build('/{/lang}/backend/chart/create/column?{?}&suptype=stacked'); ?>" class="wf-100 centerText" style="background: #fff; display: inline-block">
                    <img src="<?= \phpOMS\Uri\UriFactory::build('/Modules/Chart/Img/thumb-stacked-column-chart.png'); ?>">
                </a>
            </div>
        </section>

        <section class="box wf-100">
            <header><h1>Grouped Bar Chart</h1></header>
            <div class="inner">
                <a href="#" class="wf-100 centerText" style="background: #fff; display: inline-block">
                    <img src="<?= \phpOMS\Uri\UriFactory::build('/Modules/Chart/Img/chart-thumb.png'); ?>">
                </a>
            </div>
        </section>

        <section class="box wf-100">
            <header><h1>Stacked Bar Chart</h1></header>
            <div class="inner">
                <a href="#" class="wf-100 centerText" style="background: #fff; display: inline-block">
                    <img src="<?= \phpOMS\Uri\UriFactory::build('/Modules/Chart/Img/chart-thumb.png'); ?>">
                </a>
            </div>
        </section>

        <section class="box wf-100">
            <header><h1>Pie Chart</h1></header>
            <div class="inner">
                <a href="#" class="wf-100 centerText" style="background: #fff; display: inline-block">
                    <img src="<?= \phpOMS\Uri\UriFactory::build('/Modules/Chart/Img/chart-thumb.png'); ?>">
                </a>
            </div>
        </section>
    </div>

    <div class="col-xs-12 col-sm-6 col-lg-3">
        <section class="box wf-100">
            <header><h1>Scatterplot</h1></header>
            <div class="inner">
                <a href="#" class="wf-100 centerText" style="background: #fff; display: inline-block">
                    <img src="<?= \phpOMS\Uri\UriFactory::build('/Modules/Chart/Img/chart-thumb.png'); ?>">
                </a>
            </div>
        </section>

        <section class="box wf-100">
            <header><h1>Box Plot</h1></header>
            <div class="inner">
                <a href="#" class="wf-100 centerText" style="background: #fff; display: inline-block">
                    <img src="<?= \phpOMS\Uri\UriFactory::build('/Modules/Chart/Img/chart-thumb.png'); ?>">
                </a>
            </div>
        </section>

        <section class="box wf-100">
            <header><h1>Heatmap</h1></header>
            <div class="inner">
                <a href="#" class="wf-100 centerText" style="background: #fff; display: inline-block">
                    <img src="<?= \phpOMS\Uri\UriFactory::build('/Modules/Chart/Img/chart-thumb.png'); ?>">
                </a>
            </div>
        </section>

        <section class="box wf-100">
            <header><h1>Pyramid Chart</h1></header>
            <div class="inner">
                <a href="#" class="wf-100 centerText" style="background: #fff; display: inline-block">
                    <img src="<?= \phpOMS\Uri\UriFactory::build('/Modules/Chart/Img/chart-thumb.png'); ?>">
                </a>
            </div>
        </section>
    </div>

    <div class="col-xs-12 col-sm-6 col-lg-3">
        <section class="box wf-100">
            <header><h1>Radar Chart</h1></header>
            <div class="inner">
                <a href="#" class="wf-100 centerText" style="background: #fff; display: inline-block">
                    <img src="<?= \phpOMS\Uri\UriFactory::build('/Modules/Chart/Img/chart-thumb.png'); ?>">
                </a>
            </div>
        </section>

        <section class="box wf-100">
            <header><h1>Bubble Chart</h1></header>
            <div class="inner">
                <a href="#" class="wf-100 centerText" style="background: #fff; display: inline-block">
                    <img src="<?= \phpOMS\Uri\UriFactory::build('/Modules/Chart/Img/chart-thumb.png'); ?>">
                </a>
            </div>
        </section>

        <section class="box wf-100">
            <header><h1>High Low Chart</h1></header>
            <div class="inner">
                <a href="#" class="wf-100 centerText" style="background: #fff; display: inline-block">
                    <img src="<?= \phpOMS\Uri\UriFactory::build('/Modules/Chart/Img/chart-thumb.png'); ?>">
                </a>
            </div>
        </section>

        <section class="box wf-100">
            <header><h1>Candlestick Chart</h1></header>
            <div class="inner">
                <a href="#" class="wf-100 centerText" style="background: #fff; display: inline-block">
                    <img src="<?= \phpOMS\Uri\UriFactory::build('/Modules/Chart/Img/chart-thumb.png'); ?>">
                </a>
            </div>
        </section>
    </div>

    <div class="col-xs-12 col-sm-6 col-lg-3">
        <section class="box wf-100">
            <header><h1>Gantt Chart</h1></header>
            <div class="inner">
                <a href="#" class="wf-100 centerText" style="background: #fff; display: inline-block">
                    <img src="<?= \phpOMS\Uri\UriFactory::build('/Modules/Chart/Img/chart-thumb.png'); ?>">
                </a>
            </div>
        </section>

        <section class="box wf-100">
            <header><h1>Waterfall</h1></header>
            <div class="inner">
                <a href="#" class="wf-100 centerText" style="background: #fff; display: inline-block">
                    <img src="<?= \phpOMS\Uri\UriFactory::build('/Modules/Chart/Img/chart-thumb.png'); ?>">
                </a>
            </div>
        </section>

        <section class="box wf-100">
            <header><h1>Tree</h1></header>
            <div class="inner">
                <a href="#" class="wf-100 centerText" style="background: #fff; display: inline-block">
                    <img src="<?= \phpOMS\Uri\UriFactory::build('/Modules/Chart/Img/chart-thumb.png'); ?>">
                </a>
            </div>
        </section>

        <section class="box wf-100">
            <header><h1>Map</h1></header>
            <div class="inner">
                <a href="#" class="wf-100 centerText" style="background: #fff; display: inline-block">
                    <img src="<?= \phpOMS\Uri\UriFactory::build('/Modules/Chart/Img/chart-thumb.png'); ?>">
                </a>
            </div>
        </section>
    </div>
</div>