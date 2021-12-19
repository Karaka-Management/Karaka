<?php
/**
 * Orange Management
 *
 * PHP Version 8.0
 *
 * @package   Template
 * @copyright Dennis Eichhorn
 * @license   OMS License 1.0
 * @version   1.0.0
 * @link      https://orange-management.org
 */
declare(strict_types=1);

use phpOMS\Utils\Parser\Markdown\Markdown;

$content = $this->getData('content');
?>

<div class="row">
    <div class="col-xs-12">
        <section class="portlet">
            <article><?= Markdown::parse($content->getL11n()->content); ?></article>
        </section>
    </div>
</div>