<?php
/**
 * Jingga
 *
 * PHP Version 8.1
 *
 * @package   Template
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.0
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

use phpOMS\Uri\UriFactory;

?>
<div class="row">
    <div class="col-xs-12">
        <section class="portlet">
            <div class="portlet-body cT">
                <div>This content doesn't exist</div>
                <img alt="404 error image" style="margin: 1rem; max-height: 90%; max-width: 90%;" src="<?= UriFactory::build('Web/Backend/img/404.svg'); ?>">
                <div>Please contact an admin if you think this is an unexpected behavior</div>
            </div>
        </section>
    </div>
</div>
