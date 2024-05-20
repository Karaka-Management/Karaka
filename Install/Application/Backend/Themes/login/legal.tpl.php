<?php
/**
 * Jingga
 *
 * PHP Version 8.2
 *
 * @package   Web\Backend
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.2
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

use phpOMS\Utils\Parser\Markdown\Markdown;

?>
<?php include __DIR__ . '/head.tpl.php'; ?>
<body>
<main>
    <article><?= Markdown::parse($this->data['content'] ?? ''); ?></article>
</main>
<?php include __DIR__ . '/foot.tpl.php'; ?>
