<?php
/**
 * Jingga
 *
 * PHP Version 8.2
 *
 * @package   Template
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.0
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

use phpOMS\Utils\Parser\Markdown\Markdown;

$content = $this->getData('content');
?>

<div class="row">
    <div class="col-xs-12">
        <section class="portlet">
            <article><?= Markdown::parse($content); ?></article>
        </section>
    </div>
</div>