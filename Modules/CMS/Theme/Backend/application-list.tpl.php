<?php
/**
 * Orange Management
 *
 * PHP Version 7.4
 *
 * @package   Modules\Profile
 * @copyright Dennis Eichhorn
 * @license   OMS License 1.0
 * @version   1.0.0
 * @link      https://orange-management.org
 */
declare(strict_types=1);

use phpOMS\Uri\UriFactory;

/**
 * @var \phpOMS\Views\View                $this
 * @var \Modules\CMS\Models\Application[] $applications
 */
$applications = $this->getData('applications') ?? [];

$previous = empty($applications) ? '{/prefix}cms/application/list' : '{/prefix}cms/application/list?{?}&id=' . \reset($applications)->getId() . '&ptype=-';
$next     = empty($applications) ? '{/prefix}cms/application/list' : '{/prefix}cms/application/list?{?}&id=' . \end($applications)->getId() . '&ptype=+';

echo $this->getData('nav')->render();
?>