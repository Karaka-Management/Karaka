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

use phpOMS\Uri\UriFactory;

?>
<div class="centerText box">
    <div>This content doesn't exist.</div>
</div>

<div class="centerText box">
    <div><img src="<?= UriFactory::build('Web/Backend/img/inline_404.svg'); ?>" width="30%"></div>
</div>

<div class="centerText box">
    <div>Please contact an admin if you think this is an unexpected error.</div>
</div>